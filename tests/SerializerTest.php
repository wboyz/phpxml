<?php

namespace Wboyz\PhpXml\Tests;

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Wboyz\PhpXml\Serializer;
use Wboyz\PhpXml\Tests\Stubs\Person;
use Wboyz\PhpXml\Tests\Stubs\Address;
use Wboyz\PhpXml\Tests\Stubs\Car;

class SerializerTest extends TestCase
{
    public function test_serialize_with_default()
    {
        $sample = new Person();
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

        $this->assertStringContainsString('<Person Id="1">', $xml);
        $this->assertStringContainsString('<Name>Test Name</Name>', $xml);
        $this->assertStringContainsString('<Age>30</Age>', $xml);
        $this->assertStringContainsString('About Test', $xml);
        $this->assertStringContainsString('<Address>', $xml);
        $this->assertStringContainsString('<Country>USA</Country>', $xml);
        $this->assertStringContainsString('<City>New York</City>', $xml);
        $this->assertStringContainsString('<State>NY</State>', $xml);
        $this->assertStringContainsString('</Person>', $xml);
    }

    public function test_serialize_with_custom_names()
    {
        $car = new Car();
        $car->id = 1;
        $car->make = 'Toyota';
        $car->model = 'Corolla';
        $car->year = '2021';
        $car->color = 'Red';

        $serializer = new Serializer();

        $xml = $serializer->serialize($car);

        $this->assertStringContainsString('<Vehicle id="1">', $xml);
        $this->assertStringContainsString('<Brand>Toyota</Brand>', $xml);
        $this->assertStringContainsString('<Type>Corolla</Type>', $xml);
        $this->assertStringContainsString('<ProductionYear>2021</ProductionYear>', $xml);
        $this->assertStringContainsString('<Paint>Red</Paint>', $xml);
        $this->assertStringContainsString('</Vehicle>', $xml);
    }
}