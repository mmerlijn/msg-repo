<?php

namespace mmerlijn\msgRepo;

class Organisation implements RepositoryInterface
{

    use HasPhoneTrait;

    /**
     * @param string $name
     * @param string $department
     * @param string $short
     * @param Phone|null $phone
     */
    public function __construct(
        public string $name = "",
        public string $department = "",
        public string $short = "",
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
            'short' => $this->short,
            'phone' => (string)$this->phone,
        ];
    }

    public function fromArray(array $data): Organisation
    {
        $this->name = $data['name'];
        $this->department = $data['department'];
        $this->short = $data['short'];
        $this->setPhone($data['phone']);
        return $this;
    }

}