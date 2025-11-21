<?php

namespace mmerlijn\msgRepo;

trait CompactTrait
{
    /**
     * Remove null, empty string and empty array values from array
     *
     * @param array $array
     * @param bool $compact
     * @return array
     */
    public function compact(array $array, bool $compact = true): array
    {
        if (!$compact) {
            return $array;
        }
        return array_filter($array, fn($value) => !is_null($value) and $value !== '' and $value !== []);
    }

}