<?php

namespace Wboyz\PhpXml\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class XmlAttribute
{
    public function __construct(public ?string $name = null) {}
}
