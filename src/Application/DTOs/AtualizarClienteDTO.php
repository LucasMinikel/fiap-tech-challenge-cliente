<?php

namespace App\Application\DTOs;

class AtualizarClienteDTO
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
}
