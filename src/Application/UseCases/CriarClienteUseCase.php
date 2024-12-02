<?php

namespace App\Application\UseCases;

use App\Application\DTOs\ClienteDTO;
use App\Application\DTOs\CriarClienteDTO;
use App\Domain\Entities\Cliente;
use App\Domain\Repositories\ClienteRepositoryInterface;

class CriarClienteUseCase
{
    private $clienteRepository;

    public function __construct(ClienteRepositoryInterface $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function execute(CriarClienteDTO $dto): ClienteDTO
    {
        $cliente = new Cliente($dto->nome, $dto->cpf, $dto->email);
        $clienteSalvo = $this->clienteRepository->save($cliente);
        return ClienteDTO::fromEntity($clienteSalvo);
    }
}
