<?php

namespace App\DTO;

class ConversionResult
{
    public function __construct(
        public string $from,
        public string $to,
        public float $amount,
        public float $converted,
        public float $rate
    ) {
    }
    /**
     * @return array<string, float|string>
     */
    public function toArray(): array
    {
        return [
            'from' => $this->from,
            'to' => $this->to,
            'amount' => $this->amount,
            'converted' => $this->converted,
            'rate' => $this->rate,
        ];
    }
}
