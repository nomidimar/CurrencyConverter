<?php

namespace App\Service;

use App\Provider\RateProviderInterface;
use App\DTO\ConversionResult;
use App\ValueObject\Currency;

class CurrencyConverter
{
    public function __construct(private RateProviderInterface $provider)
    {
    }

    public function convert(string $from, string $to, float $amount): ConversionResult
    {
        $fromVo = new Currency($from);
        $toVo = new Currency($to);

        $rate = $this->provider->getRate((string)$fromVo, (string)$toVo);

        if ($rate === null) {
            throw new \InvalidArgumentException(sprintf('No rate from %s to %s', $fromVo, $toVo));
        }

        $converted = round($amount * $rate, 4);

        return new ConversionResult((string)$fromVo, (string)$toVo, $amount, $converted, $rate);
    }
}
