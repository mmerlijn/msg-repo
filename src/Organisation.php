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
     * @param string|null $agbcode
     * @param string|null $source
     * @param Phone|string $phone
     */
    public function __construct(
        public string       $name = "",
        public string       $department = "",
        public string       $short = "",
        public string|null  $agbcode = null,
        public string|null  $source = null,
        public Phone|string $phone = new Phone,
    )
    {
        $this->setPhone($phone);
        $this->name = StripUnwanted::format($name);
        $this->department = StripUnwanted::format($department);
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
            'agbcode' => $this->agbcode,
            'source' => $this->source,
            'phone' => (string)$this->phone,

        ], $compact);
    }

    //backwards compatibility
    public function fromArray(array $data): Organisation
    {
        return new Organisation(...$data);
    }

    public function hasData():bool
    {
        return $this->name  || $this->department  || $this->agbcode  || $this->source ;
    }

}