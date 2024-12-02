<?php

namespace Tests\Integration\Infrastructure\API\Controllers;

use App\Application\DTOs\ClienteDTO;
use App\Application\UseCases\CriarClienteUseCase;
use App\Application\UseCases\ListarClientesUseCase;
use App\Application\UseCases\ObterClienteUseCase;
use App\Application\UseCases\AtualizarClienteUseCase;
use App\Application\UseCases\ExcluirClienteUseCase;
use App\Infrastructure\API\Controllers\ClienteController;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Factory\ResponseFactory;

class ClienteControllerTest extends TestCase
{
    private $controller;
    private $criarClienteUseCase;
    private $listarClientesUseCase;
    private $obterClienteUseCase;
    private $atualizarClienteUseCase;
    private $excluirClienteUseCase;

    protected function setUp(): void
    {
        $this->criarClienteUseCase = $this->createMock(CriarClienteUseCase::class);
        $this->listarClientesUseCase = $this->createMock(ListarClientesUseCase::class);
        $this->obterClienteUseCase = $this->createMock(ObterClienteUseCase::class);
        $this->atualizarClienteUseCase = $this->createMock(AtualizarClienteUseCase::class);
        $this->excluirClienteUseCase = $this->createMock(ExcluirClienteUseCase::class);

        $this->controller = new ClienteController(
            $this->criarClienteUseCase,
            $this->listarClientesUseCase,
            $this->obterClienteUseCase,
            $this->atualizarClienteUseCase,
            $this->excluirClienteUseCase
        );
    }

    public function testCriar()
    {
        $clienteDTO = new ClienteDTO('CLIE123', 'João Silva', '123.456.789-00', 'joao@example.com');

        $this->criarClienteUseCase->expects($this->once())
            ->method('execute')
            ->willReturn($clienteDTO);

        $request = (new ServerRequestFactory())->createServerRequest('POST', '/clientes')
            ->withParsedBody([
                'nome' => 'João Silva',
                'cpf' => '123.456.789-00',
                'email' => 'joao@example.com'
            ]);

        $response = $this->controller->criar($request, (new ResponseFactory())->createResponse());

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));

        $body = json_decode((string) $response->getBody(), true);
        $this->assertEquals('CLIE123', $body['id']);
        $this->assertEquals('João Silva', $body['nome']);
        $this->assertEquals('123.456.789-00', $body['cpf']);
        $this->assertEquals('joao@example.com', $body['email']);
    }

    public function testListar()
    {
        $clientesDTO = [
            new ClienteDTO('CLIE123', 'João Silva', '123.456.789-00', 'joao@example.com'),
            new ClienteDTO(2, 'Maria Santos', '987.654.321-00', 'maria@example.com')
        ];

        $this->listarClientesUseCase->expects($this->once())
            ->method('execute')
            ->willReturn($clientesDTO);

        $request = (new ServerRequestFactory())->createServerRequest('GET', '/clientes');
        $response = $this->controller->listar($request, (new ResponseFactory())->createResponse());

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));

        $body = json_decode((string) $response->getBody(), true);
        $this->assertCount(2, $body);
        $this->assertEquals('João Silva', $body[0]['nome']);
        $this->assertEquals('Maria Santos', $body[1]['nome']);
    }

    public function testObter()
    {
        $clienteDTO = new ClienteDTO('CLIE123', 'João Silva', '123.456.789-00', 'joao@example.com');

        $this->obterClienteUseCase->expects($this->once())
            ->method('execute')
            ->with('CLIE123')
            ->willReturn($clienteDTO);

        $request = (new ServerRequestFactory())->createServerRequest('GET', '/clientes/')->withAttribute('id', 'CLIE123');
        $response = $this->controller->obter($request, (new ResponseFactory())->createResponse(), ['id' => 'CLIE123']);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));

        $body = json_decode((string) $response->getBody(), true);
        $this->assertEquals('CLIE123', $body['id']);
        $this->assertEquals('João Silva', $body['nome']);
    }

    public function testAtualizar()
    {
        $clienteDTO = new ClienteDTO('CLIE123', 'João Silva Atualizado', '123.456.789-00', 'joao.novo@example.com');

        $this->atualizarClienteUseCase->expects($this->once())
            ->method('execute')
            ->willReturn($clienteDTO);

        $request = (new ServerRequestFactory())->createServerRequest('PUT', '/clientes/')->withAttribute('id', 'CLIE123')
            ->withParsedBody([
                'nome' => 'João Silva Atualizado',
                'email' => 'joao.novo@example.com'
            ]);

        $response = $this->controller->atualizar($request, (new ResponseFactory())->createResponse(), ['id' => 'CLIE123']);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));

        $body = json_decode((string) $response->getBody(), true);
        $this->assertEquals('CLIE123', $body['id']);
        $this->assertEquals('João Silva Atualizado', $body['nome']);
        $this->assertEquals('joao.novo@example.com', $body['email']);
    }

    public function testExcluir()
    {
        $this->excluirClienteUseCase->expects($this->once())
            ->method('execute')
            ->with('CLIE123')
            ->willReturn(true);

        $request = (new ServerRequestFactory())->createServerRequest('DELETE', '/clientes/')->withAttribute('id', 'CLIE123');
        $response = $this->controller->deletar($request, (new ResponseFactory())->createResponse(), ['id' => 'CLIE123']);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
    }
}
