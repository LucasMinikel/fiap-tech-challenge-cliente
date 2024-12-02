<?php

namespace Tests\Integration\Infrastructure\Persistence;

use App\Domain\Entities\Cliente;
use App\Infrastructure\Persistence\ClienteRepository;
use PHPUnit\Framework\TestCase;
use PDO;

class ClienteRepositoryTest extends TestCase
{
    private $pdo;
    private $repository;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->exec('CREATE TABLE clientes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nome TEXT,
            cpf TEXT,
            email TEXT
        )');

        $this->repository = new ClienteRepository($this->pdo);
    }

    public function testSaveAndFindById()
    {
        $cliente = new Cliente('João Silva', '123.456.789-00', 'joao@example.com');

        $savedCliente = $this->repository->save($cliente);
        $this->assertNotNull($savedCliente->getId());

        $foundCliente = $this->repository->findById($savedCliente->getId());
        $this->assertNotNull($foundCliente);
        $this->assertEquals($savedCliente->getId(), $foundCliente->getId());
        $this->assertEquals('João Silva', $foundCliente->getNome());
        $this->assertEquals('123.456.789-00', $foundCliente->getCpf());
        $this->assertEquals('joao@example.com', $foundCliente->getEmail());
    }

    public function testFindAll()
    {
        $cliente1 = new Cliente('João Silva', '123.456.789-00', 'joao@example.com');
        $cliente2 = new Cliente('Maria Souza', '987.654.321-00', 'maria@example.com');

        $this->repository->save($cliente1);
        $this->repository->save($cliente2);

        $clientes = $this->repository->findAll();
        $this->assertCount(2, $clientes);
    }

    public function testUpdate()
    {
        $cliente = new Cliente('João Silva', '123.456.789-00', 'joao@example.com');
        $savedCliente = $this->repository->save($cliente);

        $savedCliente->setNome('João Silva Atualizado');
        $this->repository->update($savedCliente);

        $updatedCliente = $this->repository->findById($savedCliente->getId());
        $this->assertEquals('João Silva Atualizado', $updatedCliente->getNome());
    }

    public function testDelete()
    {
        $cliente = new Cliente('João Silva', '123.456.789-00', 'joao@example.com');
        $savedCliente = $this->repository->save($cliente);

        $this->assertTrue($this->repository->delete($savedCliente->getId()));
        $this->assertNull($this->repository->findById($savedCliente->getId()));
    }
}
