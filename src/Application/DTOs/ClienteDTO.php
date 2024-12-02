<?php

namespace App\Application\DTOs;

use App\Domain\Entities\Cliente;

class ClienteDTO
{
    public string $id;
    public ?string $nome;
    public ?string $cpf;
    public ?string $email;

    public function __construct(string $id, ?string $nome, ?string $cpf, ?string $email)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->email = $email;
    }

    public static function fromEntity(Cliente $cliente): self
    {
        return new self(
            $cliente->getId(),
            $cliente->getNome(),
            $cliente->getCpf(),
            $cliente->getEmail()
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'cpf' => $this->cpf,
            'email' => $this->email,
        ];
    }
}
