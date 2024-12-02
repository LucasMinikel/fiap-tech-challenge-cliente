<?php

namespace App\Application\UseCases;

use App\Application\DTOs\ClienteDTO;
use App\Application\DTOs\AtualizarClienteDTO;
use App\Domain\Repositories\ClienteRepositoryInterface;

class AtualizarClienteUseCase
{
    private $clienteRepository;

    public function __construct(ClienteRepositoryInterface $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function execute(AtualizarClienteDTO $dto): ?ClienteDTO
    {
        $cliente = $this->clienteRepository->findById($dto->id);
        if (!$cliente) {
            return null;
        }

        $cliente->setNome($dto->nome);
        $cliente->setCpf($dto->cpf);
        $cliente->setEmail($dto->email);

        $atualizado = $this->clienteRepository->update($cliente);
        if (!$atualizado) {
            return null;
        }

        return ClienteDTO::fromEntity($cliente);
    }
}
