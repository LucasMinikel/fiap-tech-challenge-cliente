<?php

namespace Tests\Unit\Application\UseCases;

use App\Application\DTOs\ClienteDTO;
use App\Application\DTOs\CriarClienteDTO;
use App\Application\UseCases\CriarClienteUseCase;
use App\Domain\Entities\Cliente;
use App\Domain\Repositories\ClienteRepositoryInterface;
use PHPUnit\Framework\TestCase;

class CriarClienteUseCaseTest extends TestCase
{
    public function testExecute()
    {
        $clienteMock = $this->createMock(Cliente::class);
        $clienteMock->method('getId')->willReturn(1);
        $clienteMock->method('getNome')->willReturn('João Silva');
        $clienteMock->method('getCpf')->willReturn('123.456.789-00');
        $clienteMock->method('getEmail')->willReturn('joao@example.com');

        $repositoryMock = $this->createMock(ClienteRepositoryInterface::class);
        $repositoryMock->expects($this->once())
            ->method('save')
            ->willReturn($clienteMock);

        $useCase = new CriarClienteUseCase($repositoryMock);
        $dto = new CriarClienteDTO('João Silva', '123.456.789-00', 'joao@example.com');
        $result = $useCase->execute($dto);

        $this->assertInstanceOf(ClienteDTO::class, $result);
        $this->assertEquals(1, $result->id);
        $this->assertEquals('João Silva', $result->nome);
        $this->assertEquals('123.456.789-00', $result->cpf);
        $this->assertEquals('joao@example.com', $result->email);
    }
}
