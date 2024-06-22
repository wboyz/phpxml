<?php

declare(strict_types=1);

namespace Wboyz\PhpXml\Tests\Stubs;

use Wboyz\PhpXml\Attributes\XmlElement;

#[XmlElement('Ingredient')]
class Ingredient
{
    #[XmlElement('Name')]
    public string $name;

    #[XmlElement('Quantity')]
    public float $quantity;
}