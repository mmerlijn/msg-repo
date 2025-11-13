<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Helpers\StripUnwanted;

trait HasResultsTrait
{

    /**
     * add result to an order
     * @param Result|array $result
     * @return $this
     */
    public function addResult(Result|array $result = new Result()): self
    {
        if (is_array($result)) $result = new Result(...$result);
        foreach ($this->results as $r) {
            if ($result->test_code == $r->test_code) {
                return $this;
            }
        }
        $this->results[] = $result;
        return $this;
    }
}