<?php

declare(strict_types=1);

namespace Wboyz\PhpXml\Tests;

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Wboyz\PhpXml\Serializer;
use Wboyz\PhpXml\Tests\Stubs\Person;
use Wboyz\PhpXml\Tests\Stubs\Address;
use Wboyz\PhpXml\Tests\Stubs\Car;
use Wboyz\PhpXml\Tests\Stubs\Animal;
use Wboyz\PhpXml\Tests\Stubs\Food;

class SerializerTest extends TestCase
{
    private Serializer $serializer;

    protected function setUp(): void
    {
        $this->serializer = new Serializer();
    }

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

        $xml = $this->serializer->serializeToXml($person);
        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>\n<Person Id="1"><Name>Test Name</Name><Age>30</Age>About Test<Address><Country>USA</Country><City>New York</City><State>NY</State></Address></Person>\n', $xml);
    }

    public function test_serialize_with_custom_names()
    {
        $car = new Car();
        $car->id = 1;
        $car->make = 'Toyota';
        $car->model = 'Corolla';
        $car->year = 2021;
        $car->color = 'Red';

        $xml = $this->serializer->serializeToXml($car);

        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>
<Vehicle id="1"><Brand>Toyota</Brand><Type>Corolla</Type><ProductionYear>2021</ProductionYear><Paint>Red</Paint></Vehicle>
', $xml);
    }

    /*public function test_deserialize_with_default_data()
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

        $deserializedPerson = $this->serializer->deserialize($xml, Person::class);

        $this->assertEquals(1, $deserializedPerson->id);
        $this->assertEquals('Test Name', $deserializedPerson->name);
        $this->assertEquals(30, $deserializedPerson->age);
        $this->assertEquals('About Test', $deserializedPerson->aboutMe);
        $this->assertEquals('USA', $deserializedPerson->address->country);
        $this->assertEquals('New York', $deserializedPerson->address->city);
        $this->assertEquals('NY', $deserializedPerson->address->state);
    }*/

    /*public function test_deserialize_with_car()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <Vehicle id="1">
                    <Brand>Toyota</Brand>
                    <Type>Corolla</Type>
                    <ProductionYear>2021</ProductionYear>
                    <Paint>Red</Paint>
                </Vehicle>';

        $deserializedCar = $this->serializer->deserialize($xml, Car::class);

        $this->assertEquals(1, $deserializedCar->id);
        $this->assertEquals('Toyota', $deserializedCar->make);
        $this->assertEquals('Corolla', $deserializedCar->model);
        $this->assertEquals(2021, $deserializedCar->year);
        $this->assertEquals('Red', $deserializedCar->color);
    }*/

    public function test_array_serialize()
    {
        $food1 = new Food();
        $food1->name = 'Bone';
        $food1->price = 5.99;
        $food2 = new Food();
        $food2->name = 'Meat';
        $food2->price = 10.99;
        $animal = new Animal();
        $animal->id = 1;
        $animal->name = 'Dog';
        $animal->sounds = ['Bark', 'Woof'];
        $animal->foods = [$food1, $food2];

        $xml = $this->serializer->serializeToXml($animal);

        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>
<Animal Id="1"><Name>Dog</Name><Sound>Bark</Sound><Sound>Woof</Sound><Food><Name>Bone</Name><Price>5.99</Price></Food><Food><Name>Meat</Name><Price>10.99</Price></Food></Animal>', $xml);
    }
}
