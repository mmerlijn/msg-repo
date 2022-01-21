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
        public string           $abnormal_flag = "",
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
            'identifier_code' => $this->identifier_code,
            'identifier_label' => $this->identifier_label,
            'identifier_source' => $this->identifier_source,
            'reference_range' => $this->references_range,
            'abnormal_flag' => $this->abnormal_flag,
            'comments' => $this->comments,
            'done' => $this->done ? "Y" : "N",
            'change' => $this->change ? "Y" : "N",
        ];
    }

    public function addComment(string $comment): self
    {
        $this->comments[] = trim($comment);
        return $this;
    }

}