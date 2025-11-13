<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Helpers\StripUnwanted;

trait HasResultsTrait
{

    /**
     * add result to an order
     * @param Result|array $result
     * @return HasResultsTrait|Order|Request
     */
    public function addResult(Result|array $result = new Result()): self
    {
        if (is_array($result)) $result = new Result(...$result);
        foreach ($this->results as $r) {
            if ($result->test->code == $r->test->code) {
                return $this;
            }
        }
        $this->results[] = $result;
        return $this;
    }

    public function hasResults(): bool
    {
        return !empty($this->results);
    }
}