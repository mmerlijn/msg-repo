<?php

namespace mmerlijn\msgRepo;

class Name implements RepositoryInterface
{
    public function __construct(
        public string $initials = '',
        public string $lastname = "",
        public string $prefix = "",
        public string $own_lastname = "",
        public string $own_prefix = "",
        public string $name = "",
    )
    {
        if (($this->lastname or $this->own_lastname) and !$this->name) {
            $this->name = trim($this->initials . " " . trim($this->prefix . " " . $this->lastname)) .
                ($this->lastname ? " " . trim($this->own_prefix . " " . $this->own_lastname) : "");
        }
        if ($this->name and (!$this->lastname or !$this->own_lastname)) {
            $this->splitName();
        }
        $this->splitPrefixesFromNames();
    }

    public function toArray(): array
    {
        return [
            'initials' => $this->initials,
            'lastname' => $this->lastname,
            'prefix' => $this->prefix,
            'own_lastname' => $this->own_lastname,
            'own_prefix' => $this->own_prefix,
            'name' => $this->name,
        ];
    }

    private function splitName()
    {
        $parts = explode("-", $this->name);
        if (count($parts) == 2) {
            $this->lastname = trim($parts[1]);
            $this->own_lastname = trim($parts[0]);
        } else {
            $this->own_lastname = trim($parts[0]);
        }
    }

    private function splitPrefixesFromNames()
    {
        $tmp = $this->nameSplitter($this->lastname, $this->prefix);
        $this->lastname = $tmp['lastname'];
        $this->prefix = $tmp['prefix'];
        $tmp = $this->nameSplitter($this->own_lastname, $this->own_prefix);
        $this->own_lastname = $tmp['lastname'];
        $this->own_prefix = $tmp['prefix'];
    }

    //split prefix from name
    private function nameSplitter($lastname, $prefix = ""): array
    {
        $prefixes = ['aan', 'af', 'bij', 'de', 'den', 'der', 'd\'', 'het', '\'t', 'in', 'onder', 'op', 'over', '\'s', 'te', 'ten', 'ter', 'tot', 'uit', 'uijt', 'van', 'ver', 'voor',
            'a', 'al', 'am', 'auf', 'aus', 'ben', 'bin', 'da', 'dal', 'dalla', 'della', 'das', 'die', 'den', 'der', 'des', 'deca', 'degli', 'dei', 'del', 'di', 'do', 'don', 'dos', 'du', 'el',
            'i', 'im', 'l', 'la', 'las', 'le', 'les', 'lo', 'los', 'o\'', 'tho', 'thoe', 'thor', 'toe', 'unter', 'vom', 'von', 'vor', 'zu', 'zum', 'zur'];
        $parts = explode(" ", preg_replace('/,/', " ", $lastname));
        $lastname = "";
        foreach ($parts as $part) {
            if (trim($part)) {
                if (in_array(strtolower($part), $prefixes)) { //is prefix
                    $prefix .= " " . strtolower($part);
                } else { //belongs to lastname
                    $lastname .= " " . $part;
                }
            }
        }
        return ['lastname' => trim($lastname), 'prefix' => trim(implode(" ", array_unique(explode(" ", $prefix))))];
    }
}