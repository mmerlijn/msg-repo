<?php

namespace mmerlijn\msgRepo;


trait HasSpecimensTrait
{

    /**
     * add specimen to an order
     * @param Specimen|array $specimen
     * @return Request|HasSpecimensTrait
     */
    public function addSpecimen(Specimen|array $specimen = new Specimen): self
    {
        if (is_array($specimen)) $specimen = new Specimen(...$specimen);
        foreach ($this->specimens as $r) {
            if ($specimen->test->code == $r->test->code) {
                return $this;
            }
        }
        $this->specimens[] = $specimen;
        return $this;
    }

    /**
     * check if specimens are present
     * @return bool
     */
    public function hasSpecimens(): bool
    {
        return !empty($this->specimens);
    }
}