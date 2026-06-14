<?php

namespace mmerlijn\msgRepo;

trait HasOrganizationTrait
{
    /**
     * set contacts organization
     *
     * @param Organization|array $organization
     * @return Contact|HasOrganizationTrait|Order
     */
    public function setOrganization(Organization|array $organization = new Organization): self
    {
        if (is_array($organization)) {
            $organization = new Organization(...$organization);
        }
        $this->organization = $organization;
        return $this;
    }
}