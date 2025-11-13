<?php

namespace mmerlijn\msgRepo;

use Carbon\Carbon;

trait HasDateTrait
{
    /**
     * @param Carbon|string|null $date
     * @return Carbon|null
     */
    public function formatDate(Carbon|string|null $date): ?Carbon
    {
        if(!$date) {
            return null;
        }
        return is_string($date) ? Carbon::create($date) : $date;
    }
}