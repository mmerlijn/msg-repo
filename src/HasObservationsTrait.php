<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Helpers\StripUnwanted;

trait HasObservationsTrait
{

    /**
     * add observation to an order
     * @param Observation|array $observation
     * @return Specimen|HasObservationsTrait|Request
     */
    public function addObservation(Observation|array $observation = new Observation()): self
    {
        if (is_array($observation)) $observation = new Observation(...$observation);
        foreach ($this->observations as $r) {
            if ($observation->test->code == $r->test->code) {
                return $this;
            }
        }
        $this->observations[] = $observation;
        return $this;
    }

    public function hasObservations(): bool
    {
        return !empty($this->observations);
    }
}