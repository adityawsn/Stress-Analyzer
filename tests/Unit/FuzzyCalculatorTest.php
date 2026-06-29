<?php

namespace Tests\Unit;

use App\Services\FuzzyCalculator;
use PHPUnit\Framework\TestCase;

class FuzzyCalculatorTest extends TestCase
{
    public function test_category_boundary_seventy_is_high(): void
    {
        $calculator = new FuzzyCalculator();

        $this->assertSame('Rendah', $calculator->getCategory(30));
        $this->assertSame('Sedang', $calculator->getCategory(69.99));
        $this->assertSame('Tinggi', $calculator->getCategory(70));
    }
}
