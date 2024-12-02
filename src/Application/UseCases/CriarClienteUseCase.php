<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Cliente;
use App\Domain\Repositories\ClienteRepositoryInterface;

class CriarClienteUseCase
{
    private $clienteRepository;

    public function __construct(ClienteRepositoryInterface $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function execute(?string $nome, ?string $cpf, ?string $email): Cliente
    {
        $cliente = new Cliente($nome, $cpf, $email);
        return $this->clienteRepository->save($cliente);
    }
}
