<?php

namespace App\Application\DTOs;

class AtualizarClienteDTO
{
    public int $id;
    public ?string $nome;
    public ?string $cpf;
    public ?string $email;

    public function __construct(int $id, ?string $nome, ?string $cpf, ?string $email)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->email = $email;
    }
}
