<?php

namespace App\Application\UseCases;

use App\Application\DTOs\ClienteDTO;
use App\Domain\Repositories\ClienteRepositoryInterface;

class ObterClienteUseCase
{
    private $clienteRepository;

    public function __construct(ClienteRepositoryInterface $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function execute(string $id): ?ClienteDTO
    {
        $cliente = $this->clienteRepository->findById($id);
        return $cliente ? ClienteDTO::fromEntity($cliente) : null;
    }
}
