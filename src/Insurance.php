<?php

namespace mmerlijn\msgRepo;

class Insurance implements RepositoryInterface
{
    public function __construct(
        public string $uzovi = "",
        public string $policy_nr = "",
        public string $company_name = ""
    )
    {
    }

    public function toArray(): array
    {
        return [
            'uzovi' => '',
            'policy_nr' => '',
            'company_name' => ''
        ];
    }
}