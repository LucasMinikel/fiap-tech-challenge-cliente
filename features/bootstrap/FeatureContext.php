<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use App\Application\UseCases\CriarClienteUseCase;
use App\Application\DTOs\CriarClienteDTO;
use App\Domain\Repositories\ClienteRepositoryInterface;

class FeatureContext implements Context
{
    private $criarClienteUseCase;
    private $clienteData;
    private $resultado;

    public function __construct()
    {
        $clienteRepository = $this->createMock(ClienteRepositoryInterface::class);
        $this->criarClienteUseCase = new CriarClienteUseCase($clienteRepository);
    }

    /**
     * @Given eu tenho os dados do cliente
     */
    public function euTenhoOsDadosDoCliente(TableNode $table)
    {
        $this->clienteData = $table->getHash()[0];
    }

    /**
     * @When eu solicito a criação do cliente
     */
    public function euSolicitoACriacaoDoCliente()
    {
        $dto = new CriarClienteDTO(
            $this->clienteData['nome'],
            $this->clienteData['cpf'],
            $this->clienteData['email']
        );
        $this->resultado = $this->criarClienteUseCase->execute($dto);
    }

    /**
     * @Then o cliente deve ser criado com sucesso
     */
    public function oClienteDeveSerCriadoComSucesso()
    {
        if (!$this->resultado) {
            throw new Exception("Cliente não foi criado com sucesso");
        }
    }

    /**
     * @Then eu devo receber os dados do cliente criado
     */
    public function euDevoReceberOsDadosDoClienteCriado()
    {
        if (
            $this->resultado->nome !== $this->clienteData['nome'] ||
            $this->resultado->cpf !== $this->clienteData['cpf'] ||
            $this->resultado->email !== $this->clienteData['email']
        ) {
            throw new Exception("Os dados do cliente criado não correspondem aos dados fornecidos");
        }
    }
}
