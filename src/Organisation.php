<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Helpers\StripUnwanted;

class Organisation implements RepositoryInterface
{

    use HasPhoneTrait, CompactTrait;

    /**
     * @param string $name
     * @param string $department
     * @param string $short
     * @param Phone|string|null $phone
     */
    public function __construct(
        public string            $name = "",
        public string            $department = "",
        public string            $short = "",
        public Phone|string|null $phone = null,
    )
    {
        if (is_string($phone)) $this->phone = new Phone($phone);
        $this->name = StripUnwanted::format($name);
        $this->department = StripUnwanted::format($this->department);
    }


    /**
     * dump state
     *
     * @param bool $compact
     * @return array
     */
    public function toArray(bool $compact = false): array
    {
        return $this->compact([
            'name' => $this->name,
            'department' => $this->department,
            'short' => $this->short,
            'phone' => (string)$this->phone,
        ], $compact);
    }

    //backwards compatibility
    public function fromArray(array $data): Organisation
    {
        return new Organisation(...$data);
    }

}