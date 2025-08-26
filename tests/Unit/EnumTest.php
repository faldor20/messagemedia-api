<?php

namespace Schoolzine\MessagemediaApi\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Schoolzine\MessagemediaApi\Enum\Status;

class EnumTest extends TestCase
{
    public function testGetValuesReturnsAllEnumValues()
    {
        $expectedValues = [
            'enroute',
            'submitted',
            'delivered',
            'expired',
            'rejected',
            'undeliverable',
            'queued',
            'cancelled',
            'scheduled',
        ];

        $this->assertEquals($expectedValues, Status::getValues());
    }

    public function testIsValidReturnsTrueForValidValue()
    {
        $this->assertTrue(Status::isValid('delivered'));
    }

    public function testIsValidReturnsFalseForInvalidValue()
    {
        $this->assertFalse(Status::isValid('invalid_status'));
    }

    public function testFromReturnsValueForValidValue()
    {
        $this->assertEquals('delivered', Status::from('delivered'));
    }

    public function testFromThrowsExceptionForInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid enum value "invalid_status" for Schoolzine\MessagemediaApi\Enum\Status');
        Status::from('invalid_status');
    }
}
