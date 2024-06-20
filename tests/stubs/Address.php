<?php

namespace Wboyz\PhpXml\Tests\Stubs;

use Wboyz\PhpXml\Attributes\XmlElement;

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