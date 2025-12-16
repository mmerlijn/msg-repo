<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Enums\PatientSexEnum;
use mmerlijn\msgRepo\Helpers\FormatName;
use mmerlijn\msgRepo\Helpers\StripUnwanted;

class Name implements RepositoryInterface
{
    use CompactTrait;

    /**
     * @param string $initials
     * @param string|null $firstname
     * @param string|null $lastname
     * @param string|null $prefix
     * @param string $own_lastname
     * @param string|null $own_prefix
     * @param string|null $name
     * @param string|PatientSexEnum $sex
     * @param string|null $salutation
     */
    public function __construct(
        public string                $initials = '',
        public ?string               $firstname = '',
        public ?string               $lastname = "",
        public ?string               $prefix = "",
        public string                $own_lastname = "",
        public ?string               $own_prefix = "",
        public ?string               $name = "",
        public string|PatientSexEnum $sex = PatientSexEnum::EMPTY,
        public ?string               $salutation = "",
    )
    {
        $this->sex = PatientSexEnum::set($this->sex);
        $this->lastname = StripUnwanted::format($lastname ?? "","names");
        $this->own_lastname = StripUnwanted::format($own_lastname ?? "","names");
        $this->prefix = StripUnwanted::format($prefix ?? "");
        $this->own_prefix = StripUnwanted::format($own_prefix ?? "","names");
        $this->initials = StripUnwanted::format($initials ?? "");
        $this->format();
    }

    /** Export state
     *
     * @param bool $compact
     * @return array
     */
    public function toArray(bool $compact = false): array
    {
        return $this->compact([
            'initials' => $this->initials,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'prefix' => $this->prefix,
            'own_lastname' => $this->own_lastname,
            'own_prefix' => $this->own_prefix,
            'name' => $this->name,
            'sex' => $this->sex->value,
            'salutation' => $this->sex->namePrefix(),
            'full_name' => $this->getFullName(),
        ], $compact);
    }

    public function __toString(): string
    {
        return $this->getName();
    }
    public function hasData(): bool
    {
        return (bool)($this->initials || $this->own_lastname || $this->lastname || $this->name);
    }

    /** Get lastnames only
     *
     * @return string
     */
    public function getLastnames(): string
    {
        return preg_replace('/(\s-\s)$|^(\s-\s)|^\s|\s$/', "",
            ($this->lastname ? $this->prefix . " " . $this->lastname : "") .
            ($this->own_lastname ? " - " . trim($this->own_prefix . " " . $this->own_lastname) : ""));
    }


    /** Get initials + lastname
     *
     * @return string
     */
    public function getName(): string
    {
        return trim(preg_replace('/(.)/', '$1.', $this->initials) . " " . $this->getLastnames());
    }
    /** Get initials + lastname
     *
     * @return string
     */
    public function getInformalName(): string
    {
        return trim(preg_replace('/(.)/', '$1.', ($this->firstname?:$this->initials)) . " " . $this->getLastnames());
    }


    /** Get initials (formatted)
     *
     * @return string
     */
    public function getInitials(): string
    {
        return preg_replace('/(.)/', '$1.', $this->initials);
    }


    /**
     * Trim initials for database storage
     *
     * @return string
     */
    public function getInitialsForStorage(): string
    {
        return strtoupper(preg_replace('/[^A-z]/', "", $this->initials));
    }

    /** IF sex is set, full name with Dhr/Mevr
     * @return string
     */
    public function getFullName(): string
    {
        return $this->sex->namePrefix() . $this->getName();
    }

    /**
     * reformat name data
     *
     * @return void
     */
    public function format(): void
    {
        if(str_contains($this->name, ",")){
            $parts = explode(",", $this->name);
            $o = $this->hasPrefix($parts[0]);
            if($o->prefix) $this->own_prefix = $o->prefix;
            $this->name = trim($o->name);
            $o = $this->hasPrefix($parts[1]);
            if($o->prefix) $this->own_prefix = $o->prefix;
            $this->initials = trim(str_replace(".","", $o->name));
        }
        if ($this->name and !$this->lastname and !$this->own_lastname) {
            $this->splitName();
        }
        $this->initials = $this->getInitialsForStorage();
        $this->splitPrefixesFromNames();
        if (($this->lastname or $this->own_lastname)) {
            $this->name = $this->getName();
        }
        if ($this->sex->value) {
            $this->salutation = $this->sex->namePrefix();
        }
    }

    /** get lastname prefixes, initials
     *
     * @return string
     */
    public function getNameReverse(): string
    {
        return preg_replace('/(\s-\s)$|^(\s-\s)|^\s|\s$/', "",
                ($this->lastname ? $this->lastname . " " . $this->prefix : "") .
                ($this->own_lastname ? " - " . trim($this->own_lastname . " " . $this->own_prefix) : "")) . ", " . $this->getInitials();
    }


    /** Split lastname in parts
     *
     * @return void
     */
    private function splitName(): void
    {
        $parts = explode("-", $this->name);
        if (count($parts) == 2) {
            $this->lookForInitialsInLastname(trim($parts[0]), 'lastname');
            $this->own_lastname = trim($parts[1]);
        } else {
            $this->lookForInitialsInLastname(trim($parts[0]), 'own_lastname');
        }
    }


    /** Split prefixes from lastname
     *
     * @return void
     */
    private function splitPrefixesFromNames(): void
    {
        $tmp = FormatName::nameSplitter($this->lastname ?? "", $this->prefix ?? "");
        $this->lastname = ucwords(strtolower($tmp['lastname']));
        $this->prefix = strtolower($tmp['prefix']);
        $tmp = FormatName::nameSplitter($this->own_lastname ?? "", $this->own_prefix ?? "");
        $this->own_lastname = ucwords(strtolower($tmp['lastname']));
        $this->own_prefix = strtolower($tmp['prefix']);
    }

    private function lookForInitialsInLastname($name, string $name_type): void
    {
        foreach (['Dhr.','Mvr.','Mv','Dr.','Prof.'] as $salutation) {
            if (str_starts_with($name, $salutation)) {
                $name = trim(trim($name, $salutation));
                if (!$this->salutation) {
                    $this->salutation = $salutation;
                }
            }
        }
        //look for initials
        $s_parts = preg_split('/\. | /', $name);
        if (!$this->initials) {
            $s_parts = [...explode(".", $s_parts[0]), ...array_slice($s_parts, 1)];
            $t = false;
            $ln = [];
            foreach ($s_parts as $p) {
                if (strlen($p) == 1) {
                    $this->initials .= $p;
                    $t = true;
                } elseif ($t) {
                    $ln[] = $p;
                }
            }
            if ($t) {
                $this->$name_type = implode(" ", $ln);
            } else {
                $this->$name_type = $name;
            }
        } else {
            $this->$name_type = $name;
        }
    }

     private function hasPrefix(string $text): object
    {
        $prefix_list = [
            "aan 't",
            "a/d",
            "aan de",
            "aan het",
            "abd-el",
            "bij 't",
            "bij de",
            "by 't",
            "de l'",
            "de la",
            "de sousa",
            "del saz",
            "dos reis",
            "in 't",
            "in den",
            "in der",
            "in de",
            "op 't",
            "op den",
            "op der",
            "op het",
            "op ten",
            "op de",
            "uit den",
            "uit de",
            "uyt de",
            "uyt den",
            "van 't",
            "van den",
            "van der",
            "van de",
            "van het",
            "van t",
            "van ter",
            "ven der",
            "von der",
            "voor den",
            "voor de",
            "voor in 't",
            "voor in",
            "v d",
            "v t",
            "v.'t",
            "v.d",
            "v.d.",
            "v/d",
            "v/t",
            "vd",
            "v.",
            "w/v",
            "zum",
            "'d",
            "'t",
            "della",
            "del",
            "dem",
            "den",
            "der",
            "des",
            "dez",
            "de",
            "di",
            "dos",
            "do",
            "du",
            "el",
            "en",
            "er",
            "es",
            "het",
            "et",
            "im",
            "l'",
            "la",
            "le",
            "lo",
            "ten",
            "ter",
            "te",
            "van",
            "vdn",
            "vdr",
            "vom",
            "von",
        ];
        $text = trim($text);
        foreach ($prefix_list as $p) {
            if($text==$p or str_starts_with($text, $p." ") or str_ends_with($text, " ".$p)){
                //found prefix, return prefix and rest of text
                $name = trim(str_replace($p, "", $text));
                return (object)['prefix'=>$p, 'name'=>$name];
            }
        }
        return (object)['prefix'=>'', 'name'=>$text];

    }
}