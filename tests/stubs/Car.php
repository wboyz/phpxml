<?php

namespace Wboyz\PhpXml\Tests\Stubs;

use Wboyz\PhpXml\Attributes\XmlAttribute;
use Wboyz\PhpXml\Attributes\XmlElement;

#[XmlElement(name: 'Vehicle')]
class Car
{
    #[XmlAttribute]
    public int $id;

    #[XmlElement('Brand')]
    public string $make;

    #[XmlElement(name: 'Type')]
    public string $model;

    #[XmlElement(name: 'ProductionYear')]
    public int $year;

    #[XmlElement(name: 'Paint')]
    public string $color;
}