<?php

namespace App\Provider;

interface RateProviderInterface
{
    /**
     * Return rate for from->to or null if not found
     */
    public function getRate(string $from, string $to): ?float;
}
