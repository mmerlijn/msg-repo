<?php

namespace mmerlijn\msgRepo;

use Carbon\Carbon;
use mmerlijn\msgRepo\Enums\OrderControlEnum;
use mmerlijn\msgRepo\Enums\OrderStatusEnum;
use mmerlijn\msgRepo\Enums\OrderWhereEnum;

class Order implements RepositoryInterface
{

    use HasCommentsTrait, CompactTrait;

    /**
     * @param string|OrderControlEnum $control N=new, C=Cancel
     * @param string $request_nr
     * @param string|int $lab_nr
     * @param bool $complete
     * @param bool $priority
     * @param string|OrderStatusEnum $order_status
     * @param string|OrderWhereEnum $where home , other
     * @param array|Contact $requester
     * @param array|Contact $copy_to
     * @param Carbon|string|null $dt_of_request dt of execution time
     * @param Carbon|string|null $dt_of_observation
     * @param Carbon|string|null $dt_of_observation_end
     * @param Carbon|string|null $dt_of_analysis
     * @param string $admit_reason_code
     * @param string $admit_reason_name
     * @param array $results array if Results
     * @param array $requests array of Requests
     * @param array $comments array of strings
     */
    public function __construct(
        public string|OrderControlEnum $control = OrderControlEnum::NEW,
        public string                  $request_nr = "", //AB12341234
        public string|int              $lab_nr = "", //internal processing nr
        public bool                    $complete = true,
        public bool                    $priority = false,
        public string|OrderStatusEnum  $order_status = OrderStatusEnum::FINAL,
        //public string     $result_status = "", //F=final, C=correction
        public string|OrderWhereEnum   $where = OrderWhereEnum::EMPTY,
        public array|Contact           $requester = new Contact(),
        public array|Contact           $copy_to = new Contact(),
        //public string     $material = "",
        //public string     $volume = "",
        public Carbon|string|null      $dt_of_request = null,
        public Carbon|string|null      $dt_of_observation = null,
        public Carbon|string|null      $dt_of_observation_end = null,
        public Carbon|string|null      $dt_of_analysis = null,
        public string                  $admit_reason_code = "",
        public string                  $admit_reason_name = "",
        public array                   $results = [],
        public array                   $requests = [],
        public array                   $comments = []
    )
    {
        if (is_array($requester)) $this->requester = new Contact(...$requester);
        if (is_array($copy_to)) $this->copy_to = new Contact(...$copy_to);
        if (is_string($dt_of_request)) $this->dt_of_request = Carbon::create($dt_of_request);
        if (is_string($dt_of_observation)) $this->dt_of_observation = Carbon::create($dt_of_observation);
        if (is_string($dt_of_observation_end)) $this->dt_of_observation_end = Carbon::create($dt_of_observation_end);
        if (is_string($dt_of_analysis)) $this->dt_of_analysis = Carbon::create($dt_of_analysis);
        if (is_string($order_status)) $this->order_status = OrderStatusEnum::set($order_status);
        if (is_string($where)) $this->where = OrderWhereEnum::set($where);
        if (is_string($control)) $this->control = OrderControlEnum::set($control);
        $this->results = [];
        foreach ($results as $result) {
            $this->addResult(new Result(...$result));
        }
        $this->requests = [];
        foreach ($requests as $request) {
            $this->addRequest(new Request(...$request));
        }
    }


    /**
     * add result to an order
     * @param Result|array $result
     * @return $this
     */
    public function addResult(Result|array $result = new Result()): self
    {
        if (is_array($result)) $result = new Result(...$result);
        foreach ($this->results as $r) {
            if ($result->test_code == $r->test_code) {
                return $this;
            }
        }
        $this->results[] = $result;
        return $this;
    }


    /**
     * Add request to an order
     *
     * @param Request|array $request
     * @return $this
     */
    public function addRequest(Request|array $request = new Request()): self
    {
        if (is_array($request)) $request = new Request(...$request);
        foreach ($this->requests as $r) {
            if ($request->test_code == $r->test_code) {
                return $this;
            }
        }
        $this->requests[] = $request;
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
        if (is_string($filter)) $filter = [$filter];
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
     * @param string|array $filter
     * @return array
     */
    public function getRequestedTestcodes(string|array $filter = []): array
    {
        if (is_string($filter)) $filter = [$filter];
        $testcodes = [];
        foreach ($this->requests as $request) {
            if (!in_array($request->test_code, $filter)) {
                $testcodes[] = $request->test_code;
            }

        }
        return $testcodes;
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
            'control' => $this->control->value,
            'request_nr' => $this->request_nr,
            'lab_nr' => $this->lab_nr,
            'complete' => $this->complete,
            'priority' => $this->priority,
            'order_status' => $this->order_status->value,
            //'result_status' => $this->result_status,
            'where' => $this->where->value,
            'requester' => $this->requester->toArray($compact),
            'copy_to' => $this->copy_to->toArray($compact),
            //'material' => $this->material,
            //'volume' => $this->volume,
            'dt_of_request' => $this->dt_of_request?->format("Y-m-d H:i:s"),
            'dt_of_observation' => $this->dt_of_observation?->format("Y-m-d H:i:s"),
            'dt_of_observation_end' => $this->dt_of_observation_end?->format("Y-m-d H:i:s"),
            'dt_of_analysis' => $this->dt_of_analysis?->format("Y-m-d H:i:s"),
            'results' => array_map(fn($value) => $value->toArray($compact), $this->results),
            'requests' => array_map(fn($value) => $value->toArray($compact), $this->requests),
            'comments' => $this->comments,
            'admit_reason_code' => $this->admit_reason_code,
            'admit_reason_name' => $this->admit_reason_name,
        ], $compact);
    }

    //backwards compatibility
    public function fromArray(array $data): Order
    {
        return new Order(...$data);
    }
}