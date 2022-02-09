<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Enums\ResultFlagEnum;

class Result implements RepositoryInterface
{
    use HasCommentsTrait;

    public function __construct(
        public string           $type_of_value = "",
        public string|float|int $value = "",
        public string           $test_code = "",
        public string           $test_name = "",
        public string           $test_source = '',

        public string           $other_test_code = '',
        public string           $other_test_name = '',
        public string           $other_test_source = '',

        public string           $units = "",
        public string           $quantity = "",
        public string           $references_range = "",
        public ResultFlagEnum   $abnormal_flag = ResultFlagEnum::EMPTY, //H = high, L = low
        public array            $comments = [],
        public bool             $done = true, //item is processed
        public bool             $change = false,
    )
    {

    }

    public function toArray(): array
    {
        return [
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
            'reference_range' => $this->references_range,
            'abnormal_flag' => $this->abnormal_flag->value,
            'comments' => $this->comments,
            'done' => $this->done,
            'change' => $this->change,
        ];
    }

}