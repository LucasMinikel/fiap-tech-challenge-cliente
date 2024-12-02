<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Cliente;
use App\Domain\Repositories\ClienteRepositoryInterface;

class ObterClienteUseCase
{
    private $clienteRepository;

    public function __construct(ClienteRepositoryInterface $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function execute(int $id): ?Cliente
    {
        return $this->clienteRepository->findById($id);
    }
}
