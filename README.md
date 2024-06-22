# Wboyz/PhpXml

This is a PHP library for serializing and deserializing PHP to XML.

## Installation

Use the package manager [composer](https://getcomposer.org/) to install Wboyz/PhpXml.

```sh
composer require wboyz/phpxml
```

## Usage

### Usage of Attributes

This library provides several attributes to help with the serialization and deserialization process. Here are some examples:

#### XmlAttribute

Use the `XmlAttribute` attribute to map a PHP class property to an XML attribute.

```php
use Wboyz\PhpXml\Attributes\XmlAttribute;

class Car
{
    #[XmlAttribute]
    public int $id;
}
```
In this example, the `id` property of the `Car` class will be serialized to an XML attribute in the `Car` XML element.

#### XmlElement
Use the `XmlElement` attribute to map a PHP class property to an XML element.

```php
<?php
use Wboyz\PhpXml\Attributes\XmlElement;

class Car
{
    #[XmlElement('Brand')]
    public string $make;
}
```

In this example, the `make` property of the `Car` class will be serialized to an XML element named 'Brand'.

#### XmlContent

Use the `XmlContent` attribute to map a PHP class property to the content of an XML element.

```php
<?php
use Wboyz\PhpXml\Attributes\XmlContent;

class Person
{
    #[XmlContent(name: 'AboutMe')]
    public string $aboutMe = '';
}
```
In this example, the `aboutMe` property of the `Person` class will be serialized as a simple content of the xml element.

```
Please replace the Car and Person class with your actual classes.
```

### Usage of serializer

```php
// Import the Wboyz\PhpXml\Serializer namespace at the top of your file
use Wboyz\PhpXml\Serializer;

// Create an instance of the Serializer class
$serializer = new Serializer();

// Use the serialize and deserialize methods
$serialized = $serializer->serialize($data);
$deserialized = $serializer->deserialize($xml, YourClass::class);
```

## Running Tests

To run tests, use PHPUnit:

```sh
./vendor/bin/phpunit
```

## Testing in Docker

To run tests inside a Docker container, follow these steps:

1. Build the Docker image for the application (if you haven't already). Ensure you are in the project root directory and run:

    ```sh
    docker build -t php-xml-dev .
    ```

2. Once the image is built, you can run the composer install inside a Docker container using the following command:

    ```sh
    docker run --rm -v ${PWD}:/app php-xml-dev composer install
    docker run --rm -v ${PWD}:/app php-xml-dev ./vendor/bin/phpunit tests/
    ```

3. After the composer install you can run the tests:

    ```sh
    docker run --rm -v ${PWD}:/app php-xml-dev ./vendor/bin/phpunit tests/
    ```

## License

This project is licensed under the [MIT License](https://opensource.org/license/MIT).