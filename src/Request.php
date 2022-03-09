<?php

namespace mmerlijn\msgRepo;

class Request implements RepositoryInterface
{

    use HasCommentsTrait;

    /**
     * @param string $test_code
     * @param string $test_name
     * @param string $test_source
     * @param string $other_test_code
     * @param string $other_test_name
     * @param string $other_test_source
     * @param array $comments
     * @param bool $change
     */
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

    /**
     * dump state
     *
     * @return array
     */
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

    public function fromArray(array $data): Request
    {
        $this->test_code = $data['test_code'];
        $this->test_name = $data['test_name'];
        $this->test_source = $data['test_source'];
        $this->other_test_code = $data['other_test_code'];
        $this->other_test_name = $data['other_test_name'];
        $this->other_test_source = $data['other_test_source'];
        $this->comments = $data['comments'];
        $this->change = $data['change'];
        return $this;
    }
}