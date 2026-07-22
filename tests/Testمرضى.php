<?php

namespace App\Tests\Controller;

use App\Controller\مرضىController;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use PDO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Testمرضى extends TestCase
{
    private $controller;
    private $pdoMock;

    protected function setUp(): void
    {
        $this->pdoMock = $this->createMock(PDO::class);
        $this->controller = new مرضىController($this->pdoMock);
    }

    public function testGetAll()
    {
        $this->pdoMock->expects($this->once())
            ->method('query')
            ->with('SELECT * FROM مرضى')
            ->willReturn($this->createMock(\PDOStatement::class));

        $request = new Request();
        $response = $this->controller->getAll($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetOne()
    {
        $id = 1;
        $this->pdoMock->expects($this->once())
            ->method('prepare')
            ->with('SELECT * FROM مرضى WHERE id = :id')
            ->willReturn($this->createMock(\PDOStatement::class));
        $this->pdoMock->expects($this->once())
            ->method('execute')
            ->with(['id' => $id])
            ->willReturn(true);

        $request = new Request();
        $response = $this->controller->getOne($request, ['id' => $id]);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCreate()
    {
        $data = ['name' => 'مرضى', 'age' => 30];
        $this->pdoMock->expects($this->once())
            ->method('prepare')
            ->with('INSERT INTO مرضى (name, age) VALUES (:name, :age)')
            ->willReturn($this->createMock(\PDOStatement::class));
        $this->pdoMock->expects($this->once())
            ->method('execute')
            ->with($data)
            ->willReturn(true);

        $request = new Request([], [], ['name' => 'مرضى', 'age' => 30]);
        $response = $this->controller->create($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testUpdate()
    {
        $id = 1;
        $data = ['name' => 'مرضى', 'age' => 30];
        $this->pdoMock->expects($this->once())
            ->method('prepare')
            ->with('UPDATE مرضى SET name = :name, age = :age WHERE id = :id')
            ->willReturn($this->createMock(\PDOStatement::class));
        $this->pdoMock->expects($this->once())
            ->method('execute')
            ->with($data + ['id' => $id])
            ->willReturn(true);

        $request = new Request([], [], ['name' => 'مرضى', 'age' => 30]);
        $response = $this->controller->update($request, ['id' => $id]);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDelete()
    {
        $id = 1;
        $this->pdoMock->expects($this->once())
            ->method('prepare')
            ->with('DELETE FROM مرضى WHERE id = :id')
            ->willReturn($this->createMock(\PDOStatement::class));
        $this->pdoMock->expects($this->once())
            ->method('execute')
            ->with(['id' => $id])
            ->willReturn(true);

        $request = new Request();
        $response = $this->controller->delete($request, ['id' => $id]);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }
}