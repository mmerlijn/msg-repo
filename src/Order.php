<?php

namespace mmerlijn\msgRepo;

use Carbon\Carbon;
use mmerlijn\msgRepo\Enums\OrderControlEnum;
use mmerlijn\msgRepo\Enums\OrderStatusEnum;
use mmerlijn\msgRepo\Enums\OrderWhereEnum;

class Order implements RepositoryInterface
{

    use HasCommentsTrait;

    /**
     * @param OrderControlEnum $control
     * @param string $request_nr
     * @param string|int $lab_nr
     * @param bool $complete
     * @param bool $priority
     * @param OrderStatusEnum $order_status
     * @param OrderWhereEnum $where
     * @param Contact $requester
     * @param Contact $copy_to
     * @param Carbon|null $dt_of_request
     * @param Carbon|null $dt_of_observation
     * @param Carbon|null $dt_of_observation_end
     * @param Carbon|null $dt_of_analysis
     * @param string $admit_reason_code
     * @param string $admit_reason_name
     * @param array $results
     * @param array $requests
     * @param array $comments
     */
    public function __construct(
        public OrderControlEnum $control = OrderControlEnum::NEW, //N=new, C=Cancel
        public string           $request_nr = "", //AB12341234
        public string|int       $lab_nr = "", //internal processing nr
        public bool             $complete = true,
        public bool             $priority = false,
        public OrderStatusEnum  $order_status = OrderStatusEnum::FINAL,
        //public string     $result_status = "", //F=final, C=correction
        public OrderWhereEnum   $where = OrderWhereEnum::EMPTY,//home , other
        public Contact          $requester = new Contact(),
        public Contact          $copy_to = new Contact(),
        //public string     $material = "",
        //public string     $volume = "",
        public ?Carbon          $dt_of_request = null, //dt of execution time
        public ?Carbon          $dt_of_observation = null,
        public ?Carbon          $dt_of_observation_end = null,
        public ?Carbon          $dt_of_analysis = null,
        public string           $admit_reason_code = "",
        public string           $admit_reason_name = "",
        public array            $results = [],
        public array            $requests = [],
        public array            $comments = [],
    )
    {
    }


    /**
     * add result to an order
     * @param Result $result
     * @return $this
     */
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


    /**
     * Add request to an order
     *
     * @param Request $request
     * @return $this
     */
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


    /**
     * Filter out unwanted testcodes
     *
     * @param array|string $filter
     * @return $this
     */
    public function filterTestCodes(array|string $filter): self
    {
        if (gettype($filter) == "string") {
            $filter = [$filter];
        }
        foreach ($this->requests as $k => $request) {
            if (in_array($request->test_code, $filter)) {
                unset($this->requests[$k]);
            }
        }

        foreach ($this->requests as $k => $request) {
            if (in_array($request->test_code, $filter)) {
                unset($this->requests[$k]);
            }
        }
        $this->results = array_values($this->results);
        $this->requests = array_values($this->requests);
        return $this;
    }


    /**
     * Give all requested testcodes
     *
     * @return array
     */
    public function getRequestedTestcodes(): array
    {
        $testcodes = [];
        foreach ($this->requests as $request) {
            $testcodes[] = $request->test_code;
        }
        return $testcodes;
    }


    /**
     * Dump state
     *
     * @return array
     */
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
            'control' => $this->control->value,
            'request_nr' => $this->request_nr,
            'lab_nr' => $this->lab_nr,
            'complete' => $this->complete,
            'priority' => $this->priority,
            'order_status' => $this->order_status->value,
            //'result_status' => $this->result_status,
            'where' => $this->where->value,
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

    public function fromArray(array $data): Order
    {
        $this->control = OrderControlEnum::set($data['control']);
        $this->request_nr = $data['request_nr'];
        $this->lab_nr = $data['lab_nr'];
        $this->complete = $data['complete'];
        $this->priority = $data['priority'];
        $this->order_status = OrderStatusEnum::set($data['order_status']);
        $this->where = OrderWhereEnum::set($data['where']);
        $this->requester = (new Contact())->fromArray($data['requester']);
        $this->copy_to = (new Contact())->fromArray($data['copy_to']);
        if ($data['dt_of_request']) {
            $this->dt_of_request = Carbon::create($data['dt_of_request']);
        }
        if ($data['dt_of_observation']) {
            $this->dt_of_observation = Carbon::create($data['dt_of_observation']);
        }
        if ($data['dt_of_observation_end']) {
            $this->dt_of_observation_end = Carbon::create($data['dt_of_observation_end']);
        }
        if ($data['dt_of_analysis']) {
            $this->dt_of_analysis = Carbon::create($data['dt_of_analysis']);
        }

        foreach ($data['results'] as $result) {
            $this->addResult((new Result())->fromArray($result));
        }
        foreach ($data['requests'] as $requests) {
            $this->addRequest((new Request())->fromArray($requests));
        }
        $this->comments = $data['comments'];
        return $this;
    }
}