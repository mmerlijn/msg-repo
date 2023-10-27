<?php

namespace mmerlijn\msgRepo;

interface RepositoryInterface
{
    public function toArray(bool $compact = false): array;

}