<?php

namespace mmerlijn\msgRepo;

use Carbon\Carbon;

class Order implements RepositoryInterface
{
    use HasCommentsTrait;

    public function __construct(
        public string     $control = "N", //N=new, C=Cancel
        public string     $request_nr = "", //AB12341234
        public string|int $lab_nr = "", //internal processing nr
        public bool       $complete = true,
        public bool       $priority = false,
        public string     $order_status = "",
        //public string     $result_status = "", //F=final, C=correction
        public string     $where = "",//home , other
        public Contact    $requester = new Contact(),
        public Contact    $copy_to = new Contact(),
        //public string     $material = "",
        //public string     $volume = "",
        public ?Carbon    $dt_of_request = null, //dt of execution time
        public ?Carbon    $dt_of_observation = null,
        public ?Carbon    $dt_of_observation_end = null,
        public ?Carbon    $dt_of_analysis = null,
        public string     $admit_reason_code = "",
        public string     $admit_reason_name = "",
        public array      $results = [],
        public array      $requests = [],
        public array      $comments = [],
    )
    {
    }

    public function addResult(Result $result = new Result()): self
    {
        $new = true;
        foreach ($this->results as $r) {
            if ($result->test_code == $r->test_code) {
                $new = false;
            }
        }
        if ($new) {
            $this->results[] = $result;
        }
        return $this;
    }

    public function addRequest(Request $request = new Request()): self
    {
        $new = true;
        foreach ($this->requests as $r) {
            if ($request->test_code == $r->test_code) {
                $new = false;
            }
        }
        if ($new) {
            $this->requests[] = $request;
        }
        return $this;
    }

    public function toArray(): array
    {
        $results = [];
        foreach ($this->results as $result) {
            $results[] = $result->toArray();
        }
        $requests = [];
        foreach ($this->requests as $request) {
            $requests[] = $request->toArray();
        }
        return [
            'control' => $this->control,
            'request_nr' => $this->request_nr,
            'lab_nr' => $this->lab_nr,
            'complete' => $this->complete,
            'priority' => $this->priority,
            'order_status' => $this->order_status,
            //'result_status' => $this->result_status,
            'where' => $this->where,
            'requester' => $this->requester->toArray(),
            'copy_to' => $this->copy_to->toArray(),
            //'material' => $this->material,
            //'volume' => $this->volume,
            'dt_of_request' => $this->dt_of_request?->format("Y-m-d H:i:s"),
            'dt_of_observation' => $this->dt_of_observation?->format("Y-m-d H:i:s"),
            'dt_of_observation_end' => $this->dt_of_observation_end?->format("Y-m-d H:i:s"),
            'dt_of_analysis' => $this->dt_of_analysis?->format("Y-m-d H:i:s"),
            'results' => $results,
            'requests' => $requests,
            'comments' => $this->comments,
        ];
    }
}