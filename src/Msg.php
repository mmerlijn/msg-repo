<?php

namespace mmerlijn\msgRepo;

use Carbon\Carbon;

class Msg implements RepositoryInterface
{

    use HasCommentsTrait, CompactTrait, HasDateTrait;

    /**
     * @param array|Patient $patient
     * @param array|Order $order
     * @param array|Contact $sender
     * @param array|Contact $receiver
     * @param string|Carbon $datetime
     * @param array|MsgType $msgType
     * @param string $id
     * @param string $security_id
     * @param string $processing_id
     * @param array $comments
     */
    public function __construct(
        public array|Patient $patient = new Patient,
        public array|Order   $order = new Order,
        public array|Contact $sender = new Contact,
        public array|Contact $receiver = new Contact,
        public string|Carbon $datetime = new Carbon,
        public array|MsgType $msgType = new MsgType,
        public string        $id = "",
        public string        $security_id = "",
        public string        $processing_id = "",
        public array         $comments = [],
    )
    {
        $this->setPatient($patient);
        $this->setOrder($order);
        $this->setSender($sender);
        $this->setReceiver($receiver);
        $this->setMsgType($msgType);
        $this->datetime = $this->formatDate($datetime);
        $this->comments = [];
        foreach ($comments as $comment) {
            $this->addComment($comment);
        }
    }

    /**
     * dump state
     *
     * @param bool $compact
     * @return array
     */
    public function toArray(bool $compact = false): array
    {
        return $this->compact([
            'patient' => $this->patient->toArray($compact),
            'order' => $this->order->toArray($compact),
            'sender' => $this->sender->toArray($compact),
            'receiver' => $this->receiver->toArray($compact),
            'datetime' => $this->datetime->format('Y-m-d H:i:s'),
            'msgType' => $this->msgType->toArray($compact),
            'id' => $this->id,
            'security_id' => $this->security_id,
            'processing_id' => $this->processing_id,
            'comments' => $this->comments,
        ], $compact);
    }

    //backwards compatibility
    public function fromArray(array $data): self
    {
        return new Msg(...$data);
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public function fromJson(string $json): Msg
    {
        return $this->fromArray(json_decode($json, true));
    }

    /**
     * set patient to msg object
     *
     * @param array|Patient $patient
     * @return $this
     */
    public function setPatient(array|Patient $patient): self
    {
        if (is_array($patient)) $patient = new Patient(...$patient);
        $this->patient = $patient;
        return $this;
    }


    /**
     * Set order details to msg object
     *
     * @param array|Order $order
     * @return $this
     */
    public function setOrder(array|Order $order): self
    {
        if (is_array($order)) $order = new Order(...$order);
        $this->order = $order;
        return $this;
    }


    /**
     * Set the msg sender
     *
     * @param Contact $sender
     * @return $this
     */
    public function setSender(array|Contact $sender): self
    {
        if (is_array($sender)) $sender = new Contact(...$sender);
        $this->sender = $sender;
        return $this;
    }


    /**
     * Set the msg receiver
     *
     * @param array|Contact $receiver
     * @return $this
     */
    public function setReceiver(array|Contact $receiver): self
    {
        if (is_array($receiver)) $receiver = new Contact(...$receiver);
        $this->receiver = $receiver;
        return $this;
    }


    /**
     * Set message type
     *
     * @param array|MsgType $msgType
     * @return $this
     */
    public function setMsgType(array|MsgType $msgType): self
    {
        if (is_array($msgType)) $msgType = new MsgType(...$msgType);
        $this->msgType = $msgType;
        return $this;
    }
}