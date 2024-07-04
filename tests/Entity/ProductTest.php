<?php

namespace App\Tests\Entity;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testGetAndSetId()
    {
        $product = new Product();
        $reflection = new \ReflectionClass($product);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($product, 1);

        $this->assertSame(1, $product->getId());
    }

    public function testGetAndSetName()
    {
        $product = new Product();
        $product->setName('Test Product');
        $this->assertSame('Test Product', $product->getName());
    }

    public function testGetAndSetDescription()
    {
        $product = new Product();
        $product->setDescription('This is a test description.');
        $this->assertSame('This is a test description.', $product->getDescription());
    }

    public function testGetAndSetPrice()
    {
        $product = new Product();
        $product->setPrice(19.99);
        $this->assertSame(19.99, $product->getPrice());
    }

    public function testGetAndSetQuantity()
    {
        $product = new Product();
        $product->setQuantity(100);
        $this->assertSame(100, $product->getQuantity());
    }
}
