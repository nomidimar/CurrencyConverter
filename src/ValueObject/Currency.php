<?php

namespace App\ValueObject;

final class Currency
{
    public function __construct(public string $code)
    {
        $this->code = strtoupper($this->code);
    }

    public function __toString(): string
    {
        return $this->code;
    }
}
