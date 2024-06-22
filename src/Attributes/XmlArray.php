<?php

declare(strict_types=1);

namespace Wboyz\PhpXml\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class XmlArray
{
    public function __construct(public string $type, public ?string $name = null)
    {
    }
}
