<?php

namespace App\Tests\Controller;

use App\Controller\StockController;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use PDO;
use PDOStatement;

class Testمخزون_الأدوية extends TestCase
{
    private $controller;
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->controller = new StockController($this->pdo);
    }

    public function testGetAllStocks()
    {
        $expectedData = [
            ['id' => 1, 'name' => 'Stock 1'],
            ['id' => 2, 'name' => 'Stock 2'],
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetchAll')->willReturn($expectedData);
        $this->pdo->method('prepare')->willReturn($stmt);

        $response = $this->controller->getAllStocks();

        $this->assertEquals($expectedData, $response);
    }

    public function testCreateStock()
    {
        $data = ['name' => 'New Stock'];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $this->pdo->method('prepare')->willReturn($stmt);

        $response = $this->controller->createStock($data);

        $this->assertTrue($response);
    }

    public function testUpdateStock()
    {
        $data = ['id' => 1, 'name' => 'Updated Stock'];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $this->pdo->method('prepare')->willReturn($stmt);

        $response = $this->controller->updateStock($data);

        $this->assertTrue($response);
    }

    public function testDeleteStock()
    {
        $id = 1;

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $this->pdo->method('prepare')->willReturn($stmt);

        $response = $this->controller->deleteStock($id);

        $this->assertTrue($response);
    }
}



// StockController.php

namespace App\Controller;

use PDO;

class StockController
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllStocks()
    {
        $stmt = $this->pdo->prepare('SELECT * FROM stocks');
        return $stmt->fetchAll();
    }

    public function createStock(array $data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO stocks (name) VALUES (:name)');
        $stmt->execute($data);
        return true;
    }

    public function updateStock(array $data)
    {
        $stmt = $this->pdo->prepare('UPDATE stocks SET name = :name WHERE id = :id');
        $stmt->execute($data);
        return true;
    }

    public function deleteStock(int $id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM stocks WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return true;
    }
}