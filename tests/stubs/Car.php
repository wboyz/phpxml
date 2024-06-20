<?php

namespace Wboyz\PhpXml\Tests\Stubs;

use Wboyz\PhpXml\Attributes\XmlAttribute;
use Wboyz\PhpXml\Attributes\XmlElement;

#[XmlElement("Vehicle")]
class Car
{
    #[XmlAttribute]
    public $id;

    #[XmlElement("Brand")]
    public $make;

    #[XmlElement("Type")]
    public $model;

    #[XmlElement("ProductionYear")]
    public $year;

    #[XmlElement("Paint")]
    public $color;
}