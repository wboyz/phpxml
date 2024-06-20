<?php

namespace Wboyz\PhpXml;

require_once __DIR__ . '/../vendor/autoload.php';

use Wboyz\PhpXml\Attributes\XmlElement;
use Wboyz\PhpXml\Attributes\XmlAttribute;
use Wboyz\PhpXml\Attributes\XmlContent;
use Wboyz\PhpXml\Serializer;

#[XmlElement(name: "Sample")]
class Sample
{
    #[XmlAttribute(name: "Id")]
    public int $id;

    #[XmlElement(name: "Name")]
    public string $name;

    #[XmlElement(name: "Age")]
    public string $age;

    #[XmlContent(name: "AboutMe")]
    public string $aboutMe;

    #[XmlElement(name: "Address")]
    public ?Address $address = null;
}

#[XmlElement(name: "Address")]
class Address
{
    #[XmlElement(name: "Country")]
    public string $country;

    #[XmlElement(name: "City")]
    public string $city;

    #[XmlElement(name: "State")]
    public string $state;
}

$sample = new Sample();
$sample->id = 1;
$sample->name = 'John Doe';
$sample->age = '30';
$sample->aboutMe = 'I am a';
$sample->address = new Address();
$sample->address->country = 'USA';
$sample->address->city = 'New York';
$sample->address->state = 'NY';

$serializer = new Serializer();
$xml = $serializer->serialize($sample);
file_put_contents('sample.xml', $xml);
