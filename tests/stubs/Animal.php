<?php

declare(strict_types=1);

namespace Wboyz\PhpXml\Tests\Stubs;

use Wboyz\PhpXml\Attributes\XmlAttribute;
use Wboyz\PhpXml\Attributes\XmlElement;

#[XmlElement('Animal')]
class Animal
{
    #[XmlAttribute('Id')]
    public int $id;

    #[XmlElement('Name')]
    public string $name;

    #[XmlElement('Sound')]
    public array $sounds;

    #[XmlElement('Food')]
    public array $foods;
}
