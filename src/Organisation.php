<?php

namespace mmerlijn\msgRepo;

class Organisation implements RepositoryInterface
{

    use HasPhoneTrait;

    /**
     * @param string $name
     * @param string $department
     * @param string $short_name
     * @param Phone|null $phone
     */
    public function __construct(
        public string $name = "",
        public string $department = "",
        public string $short_name = "",
        public ?Phone $phone = null,
    )
    {
    }


    /**
     * dump state
     *
     * @return array
     */
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