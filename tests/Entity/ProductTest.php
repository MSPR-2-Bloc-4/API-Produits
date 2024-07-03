<?php

namespace App\Tests\Entity;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testProductEntity()
    {
        $product = new Product();
        $product->setName('Product 1');
        $product->setDescription('Description of product 1');
        $product->setPrice(99.99);
        $product->setQuantity(10);

        $this->assertEquals('Product 1', $product->getName());
        $this->assertEquals('Description of product 1', $product->getDescription());
        $this->assertEquals(99.99, $product->getPrice());
        $this->assertEquals(10, $product->getQuantity());
    }
}
