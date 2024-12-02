<?php

namespace App\Application\DTOs;

class CriarClienteDTO
{
    public ?string $nome;
    public ?string $cpf;
    public ?string $email;

    public function __construct(?string $nome, ?string $cpf, ?string $email)
    {
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->email = $email;
    }
}