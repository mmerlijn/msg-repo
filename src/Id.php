<?php

namespace mmerlijn\msgRepo;

class Id implements RepositoryInterface
{

    /**
     * @param string $id
     * @param string $authority
     * @param string $type
     * @param string $code
     */
    public function __construct(
        public string $id,
        public string $authority = "", //NLMINBIZA
        public string $type = "",   //bsn / lbs / etc
        public string $code = "",  //NNNLD
    )
    {
        $this->setBsn();
    }

    /**
     * dump state
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'authority' => $this->authority,
            'type' => $this->type,
            'code' => $this->code,
        ];
    }


    /**
     * makes id BSN
     *
     * @return $this
     */
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