<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Cliente;

interface ClienteRepositoryInterface
{
    public function findAll(): array;
    public function findById(int $id): ?Cliente;
    public function save(Cliente $cliente): Cliente;
    public function update(Cliente $cliente): bool;
    public function delete(int $id): bool;
}
