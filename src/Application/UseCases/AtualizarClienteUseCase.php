<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Cliente;
use App\Domain\Repositories\ClienteRepositoryInterface;

class AtualizarClienteUseCase
{
    private $clienteRepository;

    public function __construct(ClienteRepositoryInterface $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function execute(int $id, ?string $nome, ?string $cpf, ?string $email): ?Cliente
    {
        $cliente = $this->clienteRepository->findById($id);
        if (!$cliente) {
            return null;
        }

        $cliente->setNome($nome);
        $cliente->setCpf($cpf);
        $cliente->setEmail($email);

        if ($this->clienteRepository->update($cliente)) {
            return $cliente;
        }

        return null;
    }
}
