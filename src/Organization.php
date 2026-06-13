<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Helpers\AgbcodeValidator;

class Organization implements RepositoryInterface
{

    use HasPhoneTrait, CompactTrait, HasAddressTrait;

    /**
     * @param string $name
     * @param string $department
     * @param string $short
     * @param string|null $agbcode
     * @param string|null $source
     * @param Phone|string $phone
     */
    public function __construct(
        public string        $name = "",
        public string        $department = "",
        public string        $short = "",
        public string|null   $agbcode = null,
        public string|null   $source = null,
        public Phone|string  $phone = new Phone,
        public array|Address $address = new Address,
        public ?string       $email = null,
    )
    {
        $this->setPhone($phone);
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
            'address' => $this->address?->toArray($compact),
            'email' => $this->email,

        ], $compact);
    }

    //backwards compatibility
    public function fromArray(array $data): Organization
    {
        return new Organization(...$data);
    }

    public function hasData(): bool
    {
        return $this->name || $this->department || $this->agbcode || $this->source;
    }

    /**
     * Validate agbcode
     *
     * @return bool
     */
    public function hasValidAgbcode(): bool
    {
        return AgbcodeValidator::validate($this->agbcode);
    }

}