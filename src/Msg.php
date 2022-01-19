<?php

namespace mmerlijn\msgRepo;

use Carbon\Carbon;

class Msg implements RepositoryInterface
{
    use HasCommentsTrait;
    
    public function __construct(
        public Patient  $patient = new Patient,
        public Order    $order = new Order,
        public Sender   $sender = new Sender,
        public Receiver $receiver = new Receiver,
        public Carbon   $datetime = new Carbon,
        public MsgType  $msgType = new MsgType,
        public string   $id = "",
        public string   $security_id = "",
        public string   $processing_id = "",
        public array    $comments = [],
        //public string   $version_id="",
    )
    {
    }

    public function toArray(): array
    {
        return [
            'patient' => $this->patient->toArray(),
            'order' => $this->order->toArray(),
            'sender' => $this->sender->toArray(),
            'receiver' => $this->receiver->toArray(),
            'datetime' => $this->datetime->format('Y-m-d H:i:s'),
            'msgType' => $this->msgType->toArray(),
            'id' => $this->id,
            'security_id' => $this->security_id,
            'processing_id' => $this->processing_id,
            'comments' => $this->comments,
            //'version_id' => $this->version_id,

        ];
    }
}