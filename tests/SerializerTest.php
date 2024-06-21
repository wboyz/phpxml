<?php

declare(strict_types=1);

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
        $person = new Person();
        $person->id = 1;
        $person->name = 'Test Name';
        $person->age = 30;
        $person->aboutMe = 'About Test';
        $person->address = new Address();
        $person->address->country = 'USA';
        $person->address->city = 'New York';
        $person->address->state = 'NY';

        $serializer = new Serializer();

        $xml = $serializer->serialize($person);

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
        $car->year = 2021;
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

    public function test_deserialize_with_default_data()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <Person Id="1">
                <Name>Test Name</Name>
                <Age>30</Age>
                <Address>
                <Country>USA</Country>
                <City>New York</City>
                <State>NY</State>
                </Address>
                About Test
            </Person>';

        $serializer = new Serializer();

        $deserializedPerson = $serializer->deserialize($xml, Person::class);

        $this->assertEquals(1, $deserializedPerson->id);
        $this->assertEquals('Test Name', $deserializedPerson->name);
        $this->assertEquals(30, $deserializedPerson->age);
        $this->assertEquals('About Test', $deserializedPerson->aboutMe);
        $this->assertEquals('USA', $deserializedPerson->address->country);
        $this->assertEquals('New York', $deserializedPerson->address->city);
        $this->assertEquals('NY', $deserializedPerson->address->state);
    }

    public function test_deserialize_with_car()
    {
        $serializer = new Serializer();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <Vehicle id="1">
                    <Brand>Toyota</Brand>
                    <Type>Corolla</Type>
                    <ProductionYear>2021</ProductionYear>
                    <Paint>Red</Paint>
                </Vehicle>';

        $deserializedCar = $serializer->deserialize($xml, Car::class);

        $this->assertEquals(1, $deserializedCar->id);
        $this->assertEquals('Toyota', $deserializedCar->make);
        $this->assertEquals('Corolla', $deserializedCar->model);
        $this->assertEquals(2021, $deserializedCar->year);
        $this->assertEquals('Red', $deserializedCar->color);
    }
}
