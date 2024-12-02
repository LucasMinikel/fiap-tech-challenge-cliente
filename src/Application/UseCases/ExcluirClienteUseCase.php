<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\ClienteRepositoryInterface;

class ExcluirClienteUseCase
{
    private $clienteRepository;

    public function __construct(ClienteRepositoryInterface $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function execute(int $id): bool
    {
        return $this->clienteRepository->delete($id);
    }
}
