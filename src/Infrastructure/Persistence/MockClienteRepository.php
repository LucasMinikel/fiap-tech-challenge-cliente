<?php

use App\Domain\Entities\Cliente;
use App\Domain\Repositories\ClienteRepositoryInterface;

class MockClienteRepository implements ClienteRepositoryInterface
{
    private $clientes = [];

    public function save(Cliente $cliente): Cliente
    {
        $id = 'CLIE' . uniqid();
        $cliente->setId($id);
        $this->clientes[$id] = $cliente;
        return $cliente;
    }

    public function findAll(): array
    {
        return array_values($this->clientes);
    }

    public function findById(string $id): ?Cliente
    {
        return $this->clientes[$id] ?? null;
    }

    public function update(Cliente $cliente): bool
    {
        if (!isset($this->clientes[$cliente->getId()])) {
            return false;
        }
        $this->clientes[$cliente->getId()] = $cliente;
        return true;
    }

    public function delete(string $id): bool
    {
        if (!isset($this->clientes[$id])) {
            return false;
        }
        unset($this->clientes[$id]);
        return true;
    }

    public function findByCpf(string $cpf): ?Cliente
    {
        foreach ($this->clientes as $cliente) {
            if ($cliente->getCpf() === $cpf) {
                return $cliente;
            }
        }
        return null;
    }

    public function clear(): void
    {
        $this->clientes = [];
    }
}
