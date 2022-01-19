<?php

namespace mmerlijn\msgRepo;

class Id implements RepositoryInterface
{
    public function __construct(
        public string $id,
        public string $authority = "", //NLMINBIZA
        public string $type = "",   //bsn / lbs / etc
        public string $code = "",  //NNNLD
    )
    {
        $this->setBsn();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'authority' => $this->authority,
            'type' => $this->type,
            'code' => $this->code,
        ];
    }

    public function setBsn(): self
    {
        if ($this->type == "bsn" or $this->authority == "NLMINBIZA" or $this->code == "NNNLD") {
            $this->type = "bsn";
            $this->authority = "NLMINBIZA";
            $this->code = "NNNLD";
        }
        return $this;
    }
}