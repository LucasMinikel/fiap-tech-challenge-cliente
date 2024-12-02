<?php

namespace Tests\Unit\Domain\Entities;

use App\Domain\Entities\Cliente;
use PHPUnit\Framework\TestCase;

class ClienteTest extends TestCase
{
    public function testCriacaoCliente()
    {
        $cliente = new Cliente('João Silva', '123.456.789-00', 'joao@example.com');

        $this->assertEquals('João Silva', $cliente->getNome());
        $this->assertEquals('123.456.789-00', $cliente->getCpf());
        $this->assertEquals('joao@example.com', $cliente->getEmail());
    }

    public function testClienteComCamposNulos()
    {
        $cliente = new Cliente();

        $this->assertNull($cliente->getNome());
        $this->assertNull($cliente->getCpf());
        $this->assertNull($cliente->getEmail());
    }

    public function testSettersCliente()
    {
        $cliente = new Cliente();

        $cliente->setNome('Maria Souza');
        $cliente->setCpf('987.654.321-00');
        $cliente->setEmail('maria@example.com');

        $this->assertEquals('Maria Souza', $cliente->getNome());
        $this->assertEquals('987.654.321-00', $cliente->getCpf());
        $this->assertEquals('maria@example.com', $cliente->getEmail());
    }

    public function testToArray()
    {
        $cliente = new Cliente('João Silva', '123.456.789-00', 'joao@example.com');
        $cliente->setId(1);

        $expected = [
            'id' => 1,
            'nome' => 'João Silva',
            'cpf' => '123.456.789-00',
            'email' => 'joao@example.com',
        ];

        $this->assertEquals($expected, $cliente->toArray());
    }
}
