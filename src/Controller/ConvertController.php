<?php

namespace App\Controller;

use App\Service\CurrencyConverter;

class ConvertController
{
    public function __construct(private CurrencyConverter $converter)
    {
    }

    /**
     * @param array<string, string> $query
     * @return array<string, mixed>
     */
    public function convert(array $query): array
    {
        $from = $query['from'] ?? null;
        $to = $query['to'] ?? null;
        $amount = $query['amount'] ?? null;

        if (!$from || !$to || !$amount) {
            throw new \InvalidArgumentException('Parameters "from", "to" and "amount" are required');
        }

        if (!is_numeric($amount)) {
            throw new \InvalidArgumentException('Parameter "amount" must be numeric');
        }

        $result = $this->converter->convert($from, $to, (float)$amount);

        return $result->toArray();
    }
}
