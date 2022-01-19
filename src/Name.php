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
        if (strstr($this->name, ",")) {
            $p = explode(",", $this->name);
            $this->lastname = trim($p[0]);
        }
        //TODO
    }
}