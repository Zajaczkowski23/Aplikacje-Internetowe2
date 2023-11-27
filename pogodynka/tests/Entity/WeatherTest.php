<?php

namespace App\Tests\Entity;

use App\Entity\Weather;
use PHPUnit\Framework\TestCase;

class WeatherTest extends TestCase
{
    public function dataGetFahrenheit(): array
    {
        return [
            ['0', 32],
            ['-100', -148],
            ['100', 212],
            ['0.5', 32.9],
            ['-0.5', 31.1],
            ['1.1', 33.98],
            ['205', 401],
            ['-205', -337],
            ['10.1', 50.18],
            ['4.4', 39.92]
        ];
    }

        /**
     * @dataProvider dataGetFahrenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void
    {
        $measurement = new Weather();

        // $measurement->setTemperature(0);
        // $this->assertEquals(32, $measurement->getFahrehneit(), 
        //     "Expected 32 Fahrenheit for 0 Celsius, got {$measurement->getFahrehneit()}");

        // $measurement->setTemperature(-100);
        // $this->assertEquals(-148, $measurement->getFahrehneit(), 
        //     "Expected -148 Fahrenheit for -100 Celsius, got {$measurement->getFahrehneit()}");

        // $measurement->setTemperature(100);
        // $this->assertEquals(212, $measurement->getFahrehneit(), 
        //     "Expected 212 Fahrenheit for 100 Celsius, got {$measurement->getFahrehneit()}");

        $measurement->setTemperature($celsius);
        $this->assertEquals($expectedFahrenheit, $measurement->getFahrehneit(), "Expected $expectedFahrenheit Fahrenheit for $celsius Celsius, got {$measurement->getFahrehneit()}");
    }
}
