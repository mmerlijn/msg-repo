<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Helpers\StripUnwanted;

class Insurance implements RepositoryInterface
{

    use HasPhoneTrait, HasAddressTrait, CompactTrait;


    /**
     * @param string $uzovi
     * @param string $policy_nr
     * @param string $company_name
     * @param string|Phone $phone
     */
    public function __construct(
        public string             $uzovi = "",
        public string             $policy_nr = "",
        public string             $company_name = "",
        public string|Phone  $phone = new Phone,
    )
    {
        $this->setPhone($phone);
        //$this->setAddress($address);
        $this->company_name = StripUnwanted::format($company_name);
    }

    /**
     * Dump state
     *
     * @param bool $compact
     * @return array
     */
    public function toArray(bool $compact = false): array
    {
        return $this->compact([
            'uzovi' => $this->uzovi,
            'policy_nr' => $this->policy_nr,
            'company_name' => $this->company_name,
            'phone' => (string)$this->phone,
        ], $compact);
    }


    /**
     * Restore state from array
     *
     * @param array $data
     * @return Insurance
     */
    public function fromArray(array $data): Insurance
    {
        return new Insurance(...$data);
    }

    public function hasData():bool
    {
        return $this->uzovi || $this->policy_nr || $this->company_name;
    }
}