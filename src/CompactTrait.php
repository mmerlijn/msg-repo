<?php

namespace mmerlijn\msgRepo;

trait CompactTrait
{
    public function compact(array $array, bool $compact = true): array
    {
        if (!$compact) {
            return $array;
        }
        return array_filter($array, fn($value) => !is_null($value) and $value !== '' and $value !== []);
    }
}