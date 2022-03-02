<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Enums\PatientSexEnum;
use mmerlijn\msgRepo\Helpers\FormatName;

class Name implements RepositoryInterface
{

    /**
     * @param string $initials
     * @param string $lastname
     * @param string $prefix
     * @param string $own_lastname
     * @param string $own_prefix
     * @param string $name
     * @param PatientSexEnum $sex
     */
    public function __construct(
        public string         $initials = '',
        public string         $lastname = "",
        public string         $prefix = "",
        public string         $own_lastname = "",
        public string         $own_prefix = "",
        public string         $name = "",
        public PatientSexEnum $sex = PatientSexEnum::EMPTY,
    )
    {
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
            $this->own_lastname = trim($parts[1]);
            $this->lastname = trim($parts[0]);
        } else {
            $this->own_lastname = trim($parts[0]);
        }
    }


    /** Split prefixes from lastname
     *
     * @return void
     */
    private function splitPrefixesFromNames()
    {
        $tmp = FormatName::nameSplitter($this->lastname, $this->prefix);
        $this->lastname = ucwords(strtolower($tmp['lastname']));
        $this->prefix = strtolower($tmp['prefix']);
        $tmp = FormatName::nameSplitter($this->own_lastname, $this->own_prefix);
        $this->own_lastname = ucwords(strtolower($tmp['lastname']));
        $this->own_prefix = strtolower($tmp['prefix']);
    }


}