<?php

namespace mmerlijn\msgRepo;

class Request implements RepositoryInterface
{
    use HasCommentsTrait;

    public function __construct(

        public string $test_code = "",
        public string $test_name = "",
        public string $test_source = '',

        public string $other_test_code = '',
        public string $other_test_name = '',
        public string $other_test_source = '',

        //public string           $units = "",
        //public string           $quantity = "",
        public array  $comments = [],
        public bool   $change = false,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'test_code' => $this->test_code,
            'test_name' => $this->test_name,
            'test_source' => $this->test_source,
            'other_test_code' => $this->other_test_code,
            'other_test_name' => $this->other_test_name,
            'other_test_source' => $this->other_test_source,
            'comments' => $this->comments,
            'change' => $this->change,
        ];
    }
}