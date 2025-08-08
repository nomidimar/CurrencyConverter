<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\CurrencyConverter;
use App\Provider\RateProviderInterface;
use App\DTO\ConversionResult;

class CurrencyConverterTest extends TestCase
{
    public function testConvertUsesProviderRate()
    {
        $provider = $this->createMock(RateProviderInterface::class);
        $provider->expects($this->once())
            ->method('getRate')
            ->with('EUR', 'USD')
            ->willReturn(1.0952);

        $converter = new CurrencyConverter($provider);
        $result = $converter->convert('EUR', 'USD', 100.0);

        $this->assertInstanceOf(ConversionResult::class, $result);
        $this->assertEquals(1.0952, $result->rate);
        $this->assertEquals(109.52, $result->converted);
    }

    public function testMissingRateThrows()
    {
        $provider = $this->createMock(RateProviderInterface::class);
        $provider->method('getRate')->willReturn(null);

        $converter = new CurrencyConverter($provider);

        $this->expectException(\InvalidArgumentException::class);
        $converter->convert('AAA', 'BBB', 10.0);
    }

    public function testNegativeAmountThrows()
{
    $provider = $this->createMock(RateProviderInterface::class);
    $converter = new CurrencyConverter($provider);

    $this->expectException(\InvalidArgumentException::class);
    $converter->convert('EUR', 'USD', -10.0);
}
public function testNonNumericAmountThrows()
{
    $provider = $this->createMock(RateProviderInterface::class);

    $converter = new CurrencyConverter($provider);

    $this->expectException(\TypeError::class);
    $converter->convert('EUR', 'USD', 'not-a-number');
}


public function testEmptyFromCurrencyThrows()
{
    $provider = $this->createMock(RateProviderInterface::class);
    $converter = new CurrencyConverter($provider);

    $this->expectException(\InvalidArgumentException::class);
    $converter->convert('', 'USD', 100.0);
}

public function testEmptyToCurrencyThrows()
{
    $provider = $this->createMock(RateProviderInterface::class);
    $converter = new CurrencyConverter($provider);

    $this->expectException(\InvalidArgumentException::class);
    $converter->convert('EUR', '', 100.0);
}

}
