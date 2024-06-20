<?php

declare(strict_types=1);

namespace Wboyz\PhpXml\Tests\Stubs;

use Wboyz\PhpXml\Attributes\XmlAttribute;
use Wboyz\PhpXml\Attributes\XmlContent;
use Wboyz\PhpXml\Attributes\XmlElement;

class Person
{
    #[XmlAttribute(name: 'Id')]
    public int $id;

    #[XmlElement(name: 'Name')]
    public string $name = '';

    #[XmlElement(name: 'Age')]
    public int $age;

    #[XmlContent(name: 'AboutMe')]
    public string $aboutMe = '';

    #[XmlElement(name: 'Address')]
    public ?Address $address = null;
}