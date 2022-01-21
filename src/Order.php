<?php

namespace mmerlijn\msgRepo;

use Carbon\Carbon;

class Order
{
    use HasCommentsTrait;

    public function __construct(

        public string     $control = "NW", //NW=new, CA=Cancel
        public string     $request_nr = "",
        public string|int $lab_nr = "",
        public bool       $complete = true,
        public ?Carbon    $request_date = null,
        public bool       $priority = false,
        public string     $order_status = "",
        public string     $result_status = "", //F=final, C=correction
        public string     $action_code = "",//at home => L, else O
        public Requester  $requester = new Requester,
        public Requester  $copy_to = new Requester,
        public array      $comments = [],
        public array      $orderItems = [],
        public string     $material = "",
        public string     $volume = "",
        public ?Carbon    $datetime_of_observation = null,
        public ?Carbon    $datetime_of_observation_end = null,
        public ?Carbon    $datetime_of_analysis = null,
    )
    {
    }

    public function addItem(OrderItem $orderItem): self
    {
        $this->orderItems[] = $orderItem;
        return $this;
    }

    public function addComment(string $comment): self
    {
        $this->comments[] = trim($comment);
        return $this;
    }

    public function toArray(): array
    {
        $orderItems = [];
        foreach ($this->orderItems as $orderItem) {
            $orderItems[] = $orderItem->toArray();
        }
        return [

            'control' => $this->control,
            'request_nr' => $this->request_nr,
            'lab_nr' => $this->lab_nr,
            'complete' => $this->complete,
            'request_date' => $this->request_date,
            'priority' => $this->priority,
            'order_status' => $this->order_status,
            'result_status' => $this->result_status,
            'action_code' => $this->action_code,
            'requester' => $this->requester->toArray(),
            'copy_to' => $this->copy_to->toArray(),
            'comments' => $this->comments,
            'orderItems' => $orderItems,
            'material' => $this->material,
            'volume' => $this->volume,
            'datetime_of_observation' => $this->datetime_of_observation?->format("Y-md H:i:s"),
            'datetime_of_observation_end' => $this->datetime_of_observation_end?->format("Y-md H:i:s"),
            'datetime_of_analysis' => $this->datetime_of_analysis?->format("Y-md H:i:s"),
        ];
    }
}