<?php

namespace Tests\Unit\Application\UseCases;

use App\Application\DTOs\ClienteDTO;
use App\Application\UseCases\ObterClienteUseCase;
use App\Domain\Entities\Cliente;
use App\Domain\Repositories\ClienteRepositoryInterface;
use PHPUnit\Framework\TestCase;

class ObterClienteUseCaseTest extends TestCase
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

        $useCase = new ObterClienteUseCase($repositoryMock);
        $result = $useCase->execute('CLIE123');

        $this->assertInstanceOf(ClienteDTO::class, $result);
        $this->assertEquals('CLIE123', $result->id);
        $this->assertEquals('João Silva', $result->nome);
    }

    public function testExecuteComClienteInexistente()
    {
        $repositoryMock = $this->createMock(ClienteRepositoryInterface::class);
        $repositoryMock->expects($this->once())
            ->method('findById')
            ->with('CLIE123')
            ->willReturn(null);

        $useCase = new ObterClienteUseCase($repositoryMock);
        $result = $useCase->execute('CLIE123');

        $this->assertNull($result);
    }
}
