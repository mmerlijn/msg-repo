<?php

namespace mmerlijn\msgRepo;

use Carbon\Carbon;

class OrderItem
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
        public string           $identifier_code = "", //labcode
        public string           $identifier_label = "",
        public string           $identifier_source = "",
        public string           $references_range = "",
        public string           $abnormal_flags = "",

        public ?Carbon          $datetime_of_observation = null,
        public ?Carbon          $datetime_of_observation_end = null,
        public ?Carbon          $datetime_of_analysis = null,
        public array            $comments = [],
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
            'identifier_code' => $this->identifier_code,
            'identifier_label' => $this->identifier_label,
            'identifier_source' => $this->identifier_source,
            'reference_range' => $this->references_range,
            'abnormal_flag' => $this->abnormal_flags,
            'datetime_of_observation' => $this->datetime_of_observation?->format("Y-md H:i:s"),
            'datetime_of_observation_end' => $this->datetime_of_observation_end?->format("Y-md H:i:s"),
            'datetime_of_analysis' => $this->datetime_of_analysis?->format("Y-md H:i:s"),
            'comments' => $this->comments,
        ];
    }
}