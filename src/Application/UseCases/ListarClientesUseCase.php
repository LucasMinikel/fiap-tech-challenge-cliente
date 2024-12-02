<?php

namespace App\Application\UseCases;

use App\Application\DTOs\ClienteDTO;
use App\Domain\Repositories\ClienteRepositoryInterface;

class ListarClientesUseCase
{
    private $clienteRepository;

    public function __construct(ClienteRepositoryInterface $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function execute(): array
    {
        $clientes = $this->clienteRepository->findAll();
        return array_map(fn($cliente) => ClienteDTO::fromEntity($cliente), $clientes);
    }
}
