<?php

declare(strict_types=1);

namespace Wboyz\PhpXml;

use ReflectionClass;
use DOMDocument;
use DOMElement;
use Wboyz\PhpXml\Attributes\XmlElement;
use Wboyz\PhpXml\Attributes\XmlAttribute;
use Wboyz\PhpXml\Attributes\XmlContent;
use Wboyz\PhpXml\Strategies\XmlAttributeStrategy;
use Wboyz\PhpXml\Strategies\XmlElementStrategy;
use Wboyz\PhpXml\Strategies\XmlContentStrategy;

class Serializer
{
    private array $strategies;

    public function __construct()
    {
        $this->strategies = [
            XmlAttribute::class => new XmlAttributeStrategy(),
            XmlElement::class => new XmlElementStrategy(),
            XmlContent::class => new XmlContentStrategy(),
        ];
    }

    public function serialize(object $object, DOMDocument $dom = null, DOMElement $root = null)
    {
        $reflection = new ReflectionClass($object);
        $properties = $reflection->getProperties();

        if ($dom === null) {
            $dom = new DOMDocument('1.0', 'UTF-8');
        }

        if ($root === null) {
            $rootName = $this->getRootName($reflection); // Assuming getRootName() is implemented
            $root = $dom->createElement($rootName);
            $dom->appendChild($root);
        }

        foreach ($properties as $property) {
            $property->setAccessible(true);
            foreach ($this->strategies as $attributeClass => $strategy) {
                if ($attribute = $property->getAttributes($attributeClass)[0] ?? null) {
                    $nestedObject = $property->getValue($object);
                    if (is_object($nestedObject)) {
                        $this->serialize($nestedObject, $dom, null);
                        break;
                    }
                    $strategy->serialize($property, $object, $dom, $root, $attribute->newInstance());
                    break;
                }
            }
        }

        return $dom->saveXML();
    }

    public function deserialize($xml, $className)
    {
        $dom = new DOMDocument();
        $dom->loadXML($xml);
        $root = $dom->documentElement;

        return $this->deserializeNode($root, $className);
    }

    private function deserializeNode(DOMElement $node, string $className)
    {
        $object = new $className();
        $reflection = new ReflectionClass($className);
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $property->setAccessible(true);
            foreach ($this->strategies as $attributeClass => $strategy) {
                if ($attribute = $property->getAttributes($attributeClass)[0] ?? null) {
                    if (class_exists($property->getType()->getName())) {
                        $property->setValue($object, $this->deserializeNode($node, $property->getType()->getName()));
                        break;
                    }

                    $strategy->deserialize($property, $node, $object, $attribute->newInstance());
                    break;
                }
            }
        }

        return $object;
    }

    private function getRootName(ReflectionClass $class)
    {
        $attributes = $class->getAttributes(XmlElement::class);
        if (empty($attributes)) {
            return $class->getShortName();
        }
        return $attributes[0]->newInstance()->name ?: $class->getShortName();
    }
}
