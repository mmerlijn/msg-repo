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
        $this->results[] = $result;
        return $this;
    }

    public function addRequest(Request $request = new Request()): self
    {
        $this->requests[] = $request;
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
            'dt_of_request' => $this->dt_of_request?->format("Y-md H:i:s"),
            'dt_of_observation' => $this->dt_of_observation?->format("Y-md H:i:s"),
            'dt_of_observation_end' => $this->dt_of_observation_end?->format("Y-md H:i:s"),
            'dt_of_analysis' => $this->dt_of_analysis?->format("Y-md H:i:s"),
            'results' => $results,
            'requests' => $requests,
            'comments' => $this->comments,
        ];
    }
}