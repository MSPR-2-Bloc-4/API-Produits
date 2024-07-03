<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductControllerTest extends WebTestCase
{
    private $client;
    private $entityManager;
    private $testProductId;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();

        $this->entityManager->createQuery('DELETE FROM App\Entity\Product')->execute();

        $product = new Product();
        $product->setName('Test Product');
        $product->setDescription('Description of test product');
        $product->setPrice(99.99);
        $product->setQuantity(10);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $this->testProductId = $product->getId();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testCreateProduct()
    {
        $this->client->request(
            'POST',
            '/products',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'name' => 'New Product',
                'description' => 'Description of new product',
                'price' => 49.99,
                'quantity' => 20
            ])
        );

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }

    public function testGetProducts()
    {
        $this->client->request('GET', '/products');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testGetProduct()
    {
        $this->client->request('GET', '/products/' . $this->testProductId);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testUpdateProduct()
    {
        $this->client->request(
            'PUT',
            '/products/' . $this->testProductId,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'name' => 'Updated Product',
                'description' => 'Updated description',
                'price' => 79.99,
                'quantity' => 15
            ])
        );

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteProduct()
    {
        $this->client->request('DELETE', '/products/' . $this->testProductId);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }
}
