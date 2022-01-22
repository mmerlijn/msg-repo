<?php

namespace mmerlijn\msgRepo;

class Insurance implements RepositoryInterface
{
    use HasPhoneTrait, HasAddressTrait;

    public function __construct(
        public string   $uzovi = "",
        public string   $policy_nr = "",
        public string   $company_name = "",
        public ?Phone   $phone = null,
        public ?Address $address = null,
    )
    {
    }

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