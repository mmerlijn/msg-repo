<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Enums\ResultFlagEnum;
use mmerlijn\msgRepo\Helpers\StripUnwanted;

class Result implements RepositoryInterface
{

    use HasCommentsTrait, CompactTrait;

    /**
     * @param string $type_of_value
     * @param string|float|int $value
     * @param string $test_code
     * @param string $test_name
     * @param string $test_source
     * @param string $other_test_code
     * @param string $other_test_name
     * @param string $other_test_source
     * @param string $units
     * @param string $quantity
     * @param string $reference_range
     * @param ResultFlagEnum|string $abnormal_flag H = high, L = low
     * @param array $comments
     * @param bool $done item is processed
     * @param bool $change item is changed
     */
    public function __construct(
        public string                $type_of_value = "",
        public string|float|int      $value = "",
        public string                $test_code = "",
        public string                $test_name = "",
        public string                $test_source = '',

        public string                $other_test_code = '',
        public string                $other_test_name = '',
        public string                $other_test_source = '',

        public string                $units = "",
        public string                $quantity = "",
        public string                $reference_range = "",
        public ResultFlagEnum|string $abnormal_flag = ResultFlagEnum::EMPTY,
        public array                 $comments = [],
        public bool                  $done = true,
        public bool                  $change = false,
    )
    {
        $this->value = StripUnwanted::format($value, 'comment');
        if (is_string($this->abnormal_flag)) $this->abnormal_flag = ResultFlagEnum::set($this->abnormal_flag);
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
            'value' => $this->value,
            'type_of_value' => $this->type_of_value,
            'units' => $this->units,
            'test_code' => $this->test_code,
            'test_name' => $this->test_name,
            'test_source' => $this->test_source,
            'other_test_code' => $this->other_test_code,
            'other_test_name' => $this->other_test_name,
            'other_test_source' => $this->other_test_source,
            'quantity' => $this->quantity,
            'reference_range' => $this->reference_range,
            'abnormal_flag' => $this->abnormal_flag->value,
            'comments' => $this->comments,
            'done' => $this->done,
            'change' => $this->change,
        ], $compact);
    }

    //backwards compatibility
    public function fromArray(array $data): Result
    {
        return new Result(...$data);
    }
}