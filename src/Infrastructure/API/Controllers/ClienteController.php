<?php

namespace App\Infrastructure\API\Controllers;

use App\Application\UseCases\CriarClienteUseCase;
use App\Application\UseCases\ListarClientesUseCase;
use App\Application\UseCases\ObterClienteUseCase;
use App\Application\UseCases\AtualizarClienteUseCase;
use App\Application\UseCases\ExcluirClienteUseCase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ClienteController
{
    private $criarClienteUseCase;
    private $listarClientesUseCase;
    private $obterClienteUseCase;
    private $atualizarClienteUseCase;
    private $excluirClienteUseCase;

    public function __construct(
        CriarClienteUseCase $criarClienteUseCase,
        ListarClientesUseCase $listarClientesUseCase,
        ObterClienteUseCase $obterClienteUseCase,
        AtualizarClienteUseCase $atualizarClienteUseCase,
        ExcluirClienteUseCase $excluirClienteUseCase
    ) {
        $this->criarClienteUseCase = $criarClienteUseCase;
        $this->listarClientesUseCase = $listarClientesUseCase;
        $this->obterClienteUseCase = $obterClienteUseCase;
        $this->atualizarClienteUseCase = $atualizarClienteUseCase;
        $this->excluirClienteUseCase = $excluirClienteUseCase;
    }

    public function criar(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $cliente = $this->criarClienteUseCase->execute(
            $data['nome'] ?? null,
            $data['cpf'] ?? null,
            $data['email'] ?? null
        );

        $response->getBody()->write(json_encode($cliente->toArray()));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function listar(Request $request, Response $response): Response
    {
        $clientes = $this->listarClientesUseCase->execute();
        $response->getBody()->write(json_encode(array_map(fn($cliente) => $cliente->toArray(), $clientes)));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function obter(Request $request, Response $response, array $args): Response
    {
        $id = (int) $args['id'];
        $cliente = $this->obterClienteUseCase->execute($id);

        if (!$cliente) {
            return $response->withStatus(404);
        }

        $response->getBody()->write(json_encode($cliente->toArray()));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function atualizar(Request $request, Response $response, array $args): Response
    {
        $id = (int) $args['id'];
        $data = $request->getParsedBody();
        $cliente = $this->atualizarClienteUseCase->execute(
            $id,
            $data['nome'] ?? null,
            $data['cpf'] ?? null,
            $data['email'] ?? null
        );

        if (!$cliente) {
            return $response->withStatus(404);
        }

        $response->getBody()->write(json_encode($cliente->toArray()));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function excluir(Request $request, Response $response, array $args): Response
    {
        $id = (int) $args['id'];
        $sucesso = $this->excluirClienteUseCase->execute($id);

        if (!$sucesso) {
            return $response->withStatus(404);
        }

        return $response->withStatus(204);
    }
}
