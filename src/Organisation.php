<?php

namespace mmerlijn\msgRepo;

class Organisation implements RepositoryInterface
{
    use HasPhoneTrait;

    public function __construct(
        public string $name = "",
        public string $department = "",
        public string $short_name = "",
        public ?Phone $phone = null,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'department' => $this->department,
            'short' => $this->short_name,
            'phone' => (string)$this->phone,
        ];
    }

}