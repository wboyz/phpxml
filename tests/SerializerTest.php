<?php

namespace Wboyz\PhpXml\Tests;

use PHPUnit\Framework\TestCase;
use Wboyz\PhpXml\Serializer;
use Wboyz\PhpXml\Sample;
use Wboyz\PhpXml\Address;

class SerializerTest extends TestCase
{
    public function testSerialize()
    {
        $sample = new Sample();
        $sample->id = 1;
        $sample->name = 'Test Name';
        $sample->age = '30';
        $sample->aboutMe = 'About Test';
        $sample->address = new Address();
        $sample->address->country = 'USA';
        $sample->address->city = 'New York';
        $sample->address->state = 'NY';

        $serializer = new Serializer();

        $xml = $serializer->serialize($sample);

        $this->assertStringContainsString('<Sample Id="1">', $xml);
        $this->assertStringContainsString('<Name>Test Name</Name>', $xml);
        $this->assertStringContainsString('<Age>30</Age>', $xml);
        $this->assertStringContainsString('About Test', $xml);
    }
}