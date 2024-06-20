<?php

namespace Wboyz\PhpXml\Tests\Stubs;

use Wboyz\PhpXml\Attributes\XmlAttribute;
use Wboyz\PhpXml\Attributes\XmlElement;

#[XmlElement(name: 'Vehicle')]
class Car
{
    #[XmlAttribute]
    public $id;

    #[XmlElement('Brand')]
    public $make;

    #[XmlElement(name: 'Type')]
    public $model;

    #[XmlElement(name: 'ProductionYear')]
    public $year;

    #[XmlElement(name: 'Paint')]
    public $color;
}