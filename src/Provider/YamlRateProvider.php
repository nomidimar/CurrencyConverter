<?php

namespace App\Provider;

class YamlRateProvider implements RateProviderInterface
{
    /**
     * @param array<string, array<string, float>> $rates
     */
    public function __construct(private array $rates = [])
    {
    }

    public function getRate(string $from, string $to): ?float
    {
        return $this->rates[$from][$to] ?? null;
    }
}
