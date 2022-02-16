<?php

namespace mmerlijn\msgRepo;

class Insurance implements RepositoryInterface
{

    use HasPhoneTrait, HasAddressTrait;


    /**
     * @param string $uzovi
     * @param string $policy_nr
     * @param string $company_name
     * @param Phone|null $phone
     * @param Address|null $address
     */
    public function __construct(
        public string   $uzovi = "",
        public string   $policy_nr = "",
        public string   $company_name = "",
        public ?Phone   $phone = null,
        public ?Address $address = null,
    )
    {
    }

    /**
     * Dump state
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'uzovi' => '',
            'policy_nr' => '',
            'company_name' => '',
            'phone' => (string)$this->phone,
            'address' => $this->address?->toArray(),
        ];
    }
}