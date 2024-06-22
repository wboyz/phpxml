<?php

declare(strict_types=1);

namespace Wboyz\PhpXml\Tests\Stubs;

use Wboyz\PhpXml\Attributes\XmlElement;

#[XmlElement('Food')]
class Food
{
    #[XmlElement('Name')]
    public string $name;

    #[XmlElement('Price')]
    public float $price;
}
