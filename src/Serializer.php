<?php

declare(strict_types=1);

namespace Wboyz\PhpXml;

use ReflectionClass;
use DOMDocument;
use DOMElement;
use ReflectionProperty;
use Wboyz\PhpXml\Attributes\XmlElement;
use Wboyz\PhpXml\Attributes\XmlAttribute;
use Wboyz\PhpXml\Attributes\XmlContent;

class Serializer
{
    public function serialize(object $object, DOMDocument $dom = null, DOMElement $root = null)
    {
        $reflection = new ReflectionClass($object);
        $properties = $reflection->getProperties();

        if ($dom === null) {
            $dom = new DOMDocument('1.0', 'UTF-8');
        }

        if ($root === null) {
            $rootName = $this->getRootName($reflection);
            $root = $dom->createElement($rootName);
            $dom->appendChild($root);
        }

        $contentNode = null;
        foreach ($properties as $property) {
            $value = $property->getValue($object);

            if (!empty($property->getAttributes(XmlContent::class))) {
                $contentNode = $dom->createTextNode($property->getValue($object));
            } elseif ($name = $this->getPropertyName($property, XmlAttribute::class)) {
                $root->setAttribute($name, (string) $value);
            } elseif ($name = $this->getPropertyName($property, XmlElement::class)) {
                if (is_object($value)) {
                    $child = $dom->createElement($name);
                    $root->appendChild($child);
                    $this->serialize($value, $dom, $child);
                } else {
                    $element = $dom->createElement($name, (string) $value);
                    $root->appendChild($element);
                }
            }
        }

        if ($contentNode) {
            $root->appendChild($contentNode);
        }

        return $dom->saveXML();
    }

    public function deserialize(string $xml, string $className)
    {
        $dom = new DOMDocument();
        $dom->loadXML($xml);
        $root = $dom->documentElement;
        return $this->deserializeNode($root, $className);
    }

    private function deserializeNode(DOMElement $node, string $className)
    {
        $reflection = new ReflectionClass($className);
        $object = $reflection->newInstanceWithoutConstructor();
        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            if (!empty($property->getAttributes(XmlAttribute::class))) {
                $name = $this->getPropertyName($property, XmlAttribute::class);
                $property->setValue($object, $node->getAttribute($name));
            } elseif (!empty($property->getAttributes(XmlElement::class))) {
                $name = $this->getPropertyName($property, XmlElement::class);
                $childNode = $node->getElementsByTagName($name)->item(0);
                if ($childNode) {
                    if ($childNode->hasChildNodes() && $childNode->childNodes->length > 1) {
                        $property->setValue($object, $this->deserializeNode($childNode, $property->getType()->getName()));
                    } else {
                        $property->setValue($object, $childNode->nodeValue);
                    }
                }
            } elseif (!empty($property->getAttributes(XmlContent::class))) {
                $textContent = '';
                foreach ($node->childNodes as $childNode) {
                    if ($childNode->nodeType === XML_TEXT_NODE) {
                        $textContent .= $childNode->nodeValue;
                    }
                }
                $property->setValue($object, trim($textContent));
            }
        }
        return $object;
    }

    private function getPropertyName(ReflectionProperty $property, string $attributeClass)
    {
        $attributes = $property->getAttributes($attributeClass);
        if (empty($attributes)) {
            return null;
        }
        return $attributes[0]->newInstance()->name ?: $property->getName();
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
