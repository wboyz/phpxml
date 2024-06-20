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
        $person = new Person();
        $person->id = 1;
        $person->name = 'Test Name';
        $person->age = '30';
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

    // public function test_deserialize_with_default_data()
    // {
    //     $person = new Person();
    //     $person->id = 1;
    //     $person->name = 'Test Name';
    //     $person->age = 30;
    //     $person->aboutMe = 'About Test';
    //     $person->address = new Address();
    //     $person->address->country = 'USA';
    //     $person->address->city = 'New York';
    //     $person->address->state = 'NY';

    //     $serializer = new Serializer();

    //     $xml = $serializer->serialize($person);
    //     $deserializedPerson = $serializer->deserialize($xml, Person::class);

    //     $this->assertEquals($person->id, $deserializedPerson->id);
    //     $this->assertEquals($person->name, $deserializedPerson->name);
    //     $this->assertEquals($person->age, $deserializedPerson->age);
    //     $this->assertEquals($person->aboutMe, $deserializedPerson->aboutMe);
    //     $this->assertEquals($person->address->country, $deserializedPerson->address->country);
    //     $this->assertEquals($person->address->city, $deserializedPerson->address->city);
    //     $this->assertEquals($person->address->state, $deserializedPerson->address->state);
    // }

    public function test_deserialize_with_car()
    {
        $car = new Car();
        $car->id = 1;
        $car->make = 'Toyota';
        $car->model = 'Corolla';
        $car->year = '2021';
        $car->color = 'Red';

        $serializer = new Serializer();

        $xml = $serializer->serialize($car);

        $deserializedCar = $serializer->deserialize($xml, Car::class);

        $this->assertEquals($car->id, $deserializedCar->id);
        $this->assertEquals($car->make, $deserializedCar->make);
        $this->assertEquals($car->model, $deserializedCar->model);
        $this->assertEquals($car->year, $deserializedCar->year);
        $this->assertEquals($car->color, $deserializedCar->color);
    }
}
