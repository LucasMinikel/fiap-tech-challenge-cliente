<?php

namespace App\Domain\Entities;

class Cliente
{
    private string $id;
    private ?string $nome;
    private ?string $cpf;
    private ?string $email;

    public function __construct(?string $nome = null, ?string $cpf = null, ?string $email = null)
    {
        $this->id = 'CLIE' . uniqid();
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->email = $email;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(?string $nome): void
    {
        $this->nome = $nome;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(?string $cpf): void
    {
        $this->cpf = $cpf;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
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
