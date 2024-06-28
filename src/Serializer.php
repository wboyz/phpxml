<?php

declare(strict_types=1);

namespace Wboyz\PhpXml;

use DOMAttr;
use DOMElement;
use Wboyz\PhpXml\Attributes\XmlAttribute;
use Wboyz\PhpXml\Attributes\XmlContent;
use Wboyz\PhpXml\Attributes\XmlElement;
use Wboyz\PhpXml\Contracts\AttributeStrategy;
use Wboyz\PhpXml\Strategies\XmlAttributeStrategy;
use Wboyz\PhpXml\Strategies\XmlContentStrategy;
use Wboyz\PhpXml\Strategies\XmlElementStrategy;

class Serializer
{
    private array $strategies;

    private \DOMDocument $dom;

    public function __construct()
    {
        $this->strategies = [
            XmlAttribute::class => new XmlAttributeStrategy(),
            XmlElement::class => new XmlElementStrategy(),
            XmlContent::class => new XmlContentStrategy(),
        ];
        $this->dom = new \DOMDocument('1.0', 'UTF-8');
        $this->dom->preserveWhiteSpace = false;
    }

    public function serializeToXml(mixed $object): string
    {
        $root = $this->dom->createElement($this->getRootName(new \ReflectionClass($object)));

        $this->serialize($object, $root);

        $this->dom->appendChild($root);

        return $this->dom->saveXML();
    }

    public function serialize(mixed $object, DOMElement $root)
    {
        $reflection = new \ReflectionClass($object);
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            /** @var AttributeStrategy $strategy */
            foreach ($this->strategies as $attributeClass => $strategy) {
                $attribute = $property->getAttributes($attributeClass)[0] ?? null;
                if (!$attribute) {
                    continue;
                }
                $strategy->serializeValue($this, $property, $attribute->newInstance(), $root, $object);
            }
        }
    }

    public function getDom(): \DOMDocument
    {
        return $this->dom;
    }

    private function getRootName(\ReflectionClass $class)
    {
        $attributes = $class->getAttributes(XmlElement::class);
        if (empty($attributes)) {
            return $class->getShortName();
        }
        return $attributes[0]->newInstance()->name ?: $class->getShortName();
    }
}
