<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Enums\PatientSexEnum;
use mmerlijn\msgRepo\Helpers\FormatName;
use mmerlijn\msgRepo\Helpers\StripUnwanted;

class Name implements RepositoryInterface
{

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
        if (gettype($this->sex) == 'string') {
            $this->sex = PatientSexEnum::set($this->sex);
        }
        $this->lastname = StripUnwanted::format($lastname ?? "");
        $this->own_lastname = StripUnwanted::format($own_lastname ?? "");
        $this->prefix = StripUnwanted::format($prefix ?? "");
        $this->own_prefix = StripUnwanted::format($own_prefix ?? "");
        $this->initials = StripUnwanted::format($initials ?? "");
        $this->format();
    }

    /** Export state
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'initials' => $this->initials,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'prefix' => $this->prefix,
            'own_lastname' => $this->own_lastname,
            'own_prefix' => $this->own_prefix,
            'name' => $this->name,
            'sex' => $this->sex->value,
            'salutation' => $this->sex->namePrefix(),
        ];
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
    public function getInitialsForStorage()
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
     * set sex
     *
     * @param string $sex
     * @return $this
     */
    public function setSex(PatientSexEnum|string $sex): self
    {
        if (gettype($sex) == "string") {
            $this->sex = PatientSexEnum::set($sex);
        } else {
            $this->sex = $sex;
        }
        $this->salutation = $this->sex->namePrefix();
        return $this;
    }


    /**
     * reformat name data
     *
     * @return void
     */
    public function format(): void
    {
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
    private function splitName()
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
    private function splitPrefixesFromNames()
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
        //look for initials
        $s_parts = preg_split('/(?:\. | )/', $name);
        if (!$this->initials) {
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

}