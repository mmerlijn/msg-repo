<?php

namespace mmerlijn\msgRepo;

class Ids implements RepositoryInterface
{
    public array $ids = [];

    public function __construct(?Id $id = null)
    {
        if ($id)
            $this->ids[] = $id;
    }

    public function set(Id $id): self
    {
        $overwrite = false;
        foreach ($this->ids as $k => $v) {
            if ($v->type == $id->type or $v->authority == $id->authority or $v->code == $id->code) {
                $v[$k] = $id; //overwrite
                $overwrite = true;
            }
        }
        if (!$overwrite) {
            $this->ids[] = $id;
        }
        return $this;
    }

    public function toArray(): array
    {
        $return = [];
        foreach ($this->ids as $id) {
            $return[] = $id->toArray();
        }
        return $return;
    }
}