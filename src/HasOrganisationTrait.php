<?php

namespace mmerlijn\msgRepo;

trait HasOrganisationTrait
{
    /**
     * set contacts organization
     *
     * @param Organization|array $organization
     * @return Contact|HasOrganisationTrait|Order
     */
    public function setOrganization(Organisation|array $organization = new Organisation): self
    {
        if (is_array($organization)) {
            $organization = new Organisation(...$organization);
        }
        $this->organization = $organization;
        return $this;
    }
}