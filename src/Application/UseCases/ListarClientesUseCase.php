<?php

namespace App\Application\UseCases;

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
        return $this->clienteRepository->findAll();
    }
}
