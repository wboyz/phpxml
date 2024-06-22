<?php

declare(strict_types=1);

namespace Wboyz\PhpXml\Contracts;

use DOMDocument;
use DOMElement;

interface AttributeStrategy
{
    public function serialize($property, $object, DOMDocument $dom, DOMElement $root, $attribute);
    public function deserialize($property, $node, $object, $attribute);
}
