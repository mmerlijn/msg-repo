<?php

namespace mmerlijn\msgRepo;

class Id implements RepositoryInterface
{
    use CompactTrait;

    /**
     * @param string $id
     * @param string $authority mostly NLMINBIZA
     * @param string $type bsn / lbs / etc
     * @param string $code mostly NNNLD
     */
    public function __construct(
        public string $id,
        public string $authority = "",
        public string $type = "",
        public string $code = ""
    )
    {
        $this->setBsn();
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
            'id' => $this->id,
            'authority' => $this->authority,
            'type' => $this->type,
            'code' => $this->code,
        ], $compact);
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