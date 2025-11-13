<?php

namespace mmerlijn\msgRepo;

trait HasOrganisationTrait
{
    /**
     * set contacts organisation
     *
     * @param Organisation|array $organisation
     * @return Contact|HasOrganisationTrait|Order
     */
    public function setOrganisation(Organisation|array $organisation = new Organisation): self
    {
        if (is_array($organisation)) {
            $organisation = new Organisation(...$organisation);
        }
        $this->organisation = $organisation;
        return $this;
    }
}