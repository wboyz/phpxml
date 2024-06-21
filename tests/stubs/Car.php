<?php

declare(strict_types=1);

namespace Wboyz\PhpXml\Tests\Stubs;

use Wboyz\PhpXml\Attributes\XmlAttribute;
use Wboyz\PhpXml\Attributes\XmlElement;

#[XmlElement(name: 'Vehicle')]
class Car
{
    #[XmlAttribute]
    public int $id = 0;

    #[XmlElement('Brand')]
    public string $make = '';

    #[XmlElement(name: 'Type')]
    public string $model = '';

    #[XmlElement(name: 'ProductionYear')]
    public int $year = 0;

    #[XmlElement(name: 'Paint')]
    public string $color = '';
}