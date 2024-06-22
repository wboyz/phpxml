<?php

declare(strict_types=1);

namespace Wboyz\PhpXml\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class XmlContent
{
    public function __construct(public ?string $name = null)
    {
    }
}
