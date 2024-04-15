<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Enums\ResultFlagEnum;
use mmerlijn\msgRepo\Helpers\StripUnwanted;

class Option implements RepositoryInterface
{

    use HasCommentsTrait, CompactTrait;

    /**
     * @param string $label
     * @param string|float|int $value
     * @param string $source
     */
    public function __construct(
        public string           $label = "",
        public string|float|int $value = "",
        public string           $source = "",
    )
    {
        $this->value = StripUnwanted::format($value, 'comment');
    }

    /**
     * Dump state
     *
     * @param bool $compact
     * @return array
     */
    public function toArray(bool $compact = false): array
    {
        return $this->compact([
            'label' => $this->label,
            'value' => $this->value,
            'source' => $this->source,
        ], $compact);
    }

    //backwards compatibility
    public function fromArray(array $data): Option
    {
        return new Option(...$data);
    }
}