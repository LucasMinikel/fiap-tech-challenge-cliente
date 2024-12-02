<?php

namespace Tests\Unit\Application\UseCases;

use App\Application\DTOs\ClienteDTO;
use App\Application\UseCases\ListarClientesUseCase;
use App\Domain\Entities\Cliente;
use App\Domain\Repositories\ClienteRepositoryInterface;
use PHPUnit\Framework\TestCase;

class ListarClientesUseCaseTest extends TestCase
{
    public function testExecute()
    {
        $cliente1 = new Cliente('João Silva', '123.456.789-00', 'joao@example.com');
        $cliente1->setId(1);
        $cliente2 = new Cliente('Maria Santos', '987.654.321-00', 'maria@example.com');
        $cliente2->setId(2);

        $repositoryMock = $this->createMock(ClienteRepositoryInterface::class);
        $repositoryMock->expects($this->once())
            ->method('findAll')
            ->willReturn([$cliente1, $cliente2]);

        $useCase = new ListarClientesUseCase($repositoryMock);
        $result = $useCase->execute();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(ClienteDTO::class, $result[0]);
        $this->assertInstanceOf(ClienteDTO::class, $result[1]);
        $this->assertEquals('João Silva', $result[0]->nome);
        $this->assertEquals('Maria Santos', $result[1]->nome);
    }
}
