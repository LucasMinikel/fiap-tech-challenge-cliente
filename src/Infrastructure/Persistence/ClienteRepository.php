<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Cliente;
use App\Domain\Repositories\ClienteRepositoryInterface;
use PDO;

class ClienteRepository implements ClienteRepositoryInterface
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM clientes');
        $clientes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cliente = new Cliente($row['nome'], $row['cpf'], $row['email']);
            $cliente->setId($row['id']);
            $clientes[] = $cliente;
        }
        return $clientes;
    }

    public function findById(string $id): ?Cliente
    {
        $stmt = $this->pdo->prepare('SELECT * FROM clientes WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $cliente = new Cliente($row['nome'], $row['cpf'], $row['email']);
        $cliente->setId($row['id']);
        return $cliente;
    }

    public function save(Cliente $cliente): Cliente
    {
        $stmt = $this->pdo->prepare('INSERT INTO clientes (id, nome, cpf, email) VALUES (:id, :nome, :cpf, :email)');
        $stmt->execute([
            'id' => $cliente->getId(),
            'nome' => $cliente->getNome(),
            'cpf' => $cliente->getCpf(),
            'email' => $cliente->getEmail()
        ]);

        return $cliente;
    }

    public function update(Cliente $cliente): bool
    {
        $stmt = $this->pdo->prepare('UPDATE clientes SET nome = :nome, cpf = :cpf, email = :email WHERE id = :id');
        return $stmt->execute([
            'id' => $cliente->getId(),
            'nome' => $cliente->getNome(),
            'cpf' => $cliente->getCpf(),
            'email' => $cliente->getEmail()
        ]);
    }

    public function delete(string $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM clientes WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
