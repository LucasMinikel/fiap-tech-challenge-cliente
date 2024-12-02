<?php

namespace Tests\Unit\Application\UseCases;

use App\Application\DTOs\AtualizarClienteDTO;
use App\Application\DTOs\ClienteDTO;
use App\Application\UseCases\AtualizarClienteUseCase;
use App\Domain\Entities\Cliente;
use App\Domain\Repositories\ClienteRepositoryInterface;
use PHPUnit\Framework\TestCase;

class AtualizarClienteUseCaseTest extends TestCase
{
    public function testExecuteComClienteExistente()
    {
        $cliente = new Cliente('João Silva', '123.456.789-00', 'joao@example.com');
        $cliente->setId('CLIE123');

        $repositoryMock = $this->createMock(ClienteRepositoryInterface::class);
        $repositoryMock->expects($this->once())
            ->method('findById')
            ->with('CLIE123')
            ->willReturn($cliente);
        $repositoryMock->expects($this->once())
            ->method('update')
            ->willReturn(true);

        $useCase = new AtualizarClienteUseCase($repositoryMock);
        $dto = new AtualizarClienteDTO('CLIE123', 'João Silva Atualizado', '123.456.789-00', 'joao.novo@example.com');
        $result = $useCase->execute($dto);

        $this->assertInstanceOf(ClienteDTO::class, $result);
        $this->assertEquals('CLIE123', $result->id);
        $this->assertEquals('João Silva Atualizado', $result->nome);
        $this->assertEquals('joao.novo@example.com', $result->email);
    }

    public function testExecuteComClienteInexistente()
    {
        $repositoryMock = $this->createMock(ClienteRepositoryInterface::class);
        $repositoryMock->expects($this->once())
            ->method('findById')
            ->with('CLIE123')
            ->willReturn(null);

        $useCase = new AtualizarClienteUseCase($repositoryMock);
        $dto = new AtualizarClienteDTO('CLIE123', 'João Silva Atualizado', '123.456.789-00', 'joao.novo@example.com');
        $result = $useCase->execute($dto);

        $this->assertNull($result);
    }

    public function testExecuteComFalhaAoAtualizar()
    {
        $cliente = new Cliente('João Silva', '123.456.789-00', 'joao@example.com');
        $cliente->setId('CLIE123');

        $repositoryMock = $this->createMock(ClienteRepositoryInterface::class);
        $repositoryMock->expects($this->once())
            ->method('findById')
            ->with('CLIE123')
            ->willReturn($cliente);
        $repositoryMock->expects($this->once())
            ->method('update')
            ->willReturn(false);

        $useCase = new AtualizarClienteUseCase($repositoryMock);
        $dto = new AtualizarClienteDTO('CLIE123', 'João Silva Atualizado', '123.456.789-00', 'joao.novo@example.com');
        $result = $useCase->execute($dto);

        $this->assertNull($result);
    }
}
