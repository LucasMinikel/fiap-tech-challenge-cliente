<?php

namespace Tests\Unit\Application\UseCases;

use App\Application\UseCases\ExcluirClienteUseCase;
use App\Domain\Repositories\ClienteRepositoryInterface;
use PHPUnit\Framework\TestCase;

class ExcluirClienteUseCaseTest extends TestCase
{
    public function testExecuteComSucesso()
    {
        $repositoryMock = $this->createMock(ClienteRepositoryInterface::class);
        $repositoryMock->expects($this->once())
            ->method('delete')
            ->with('CLIE123')
            ->willReturn(true);

        $useCase = new ExcluirClienteUseCase($repositoryMock);
        $result = $useCase->execute('CLIE123');

        $this->assertTrue($result);
    }

    public function testExecuteComFalha()
    {
        $repositoryMock = $this->createMock(ClienteRepositoryInterface::class);
        $repositoryMock->expects($this->once())
            ->method('delete')
            ->with('CLIE123')
            ->willReturn(false);

        $useCase = new ExcluirClienteUseCase($repositoryMock);
        $result = $useCase->execute('CLIE123');

        $this->assertFalse($result);
    }
}
