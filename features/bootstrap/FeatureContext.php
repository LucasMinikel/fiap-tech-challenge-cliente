<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use App\Application\UseCases\CriarClienteUseCase;
use App\Application\DTOs\CriarClienteDTO;
use App\Application\DTOs\ClienteDTO;
use App\Infrastructure\Persistence\MockClienteRepository;

class FeatureContext implements Context
{
    private $criarClienteUseCase;
    private $clienteData;
    private $resultado;
    private $erro;

    public function __construct()
    {
        $clienteRepository = new MockClienteRepository();
        $this->criarClienteUseCase = new CriarClienteUseCase($clienteRepository);
    }

    /**
     * @Given eu tenho os dados do cliente
     */
    public function euTenhoOsDadosDoCliente(TableNode $table)
    {
        $rows = $table->getRows();
        $headers = array_shift($rows);
        $this->clienteData = array_combine($headers, $rows[0]);
    }

    /**
     * @Given eu tenho dados inválidos do cliente
     */
    public function euTenhoDadosInvalidosDoCliente(TableNode $table)
    {
        $rows = $table->getRows();
        $headers = array_shift($rows);
        $this->clienteData = array_combine($headers, $rows[0]);
    }

    /**
     * @When eu solicito a criação do cliente
     */
    public function euSolicitoACriacaoDoCliente()
    {
        try {
            $dto = new CriarClienteDTO(
                $this->clienteData['nome'] ?? null,
                $this->clienteData['cpf'] ?? null,
                $this->clienteData['email'] ?? null
            );
            $this->resultado = $this->criarClienteUseCase->execute($dto);
        } catch (\Exception $e) {
            $this->erro = $e->getMessage();
        }
    }

    /**
     * @Then o cliente deve ser criado com sucesso
     */
    public function oClienteDeveSerCriadoComSucesso()
    {
        if (!$this->resultado instanceof ClienteDTO) {
            throw new \Exception("Cliente não foi criado com sucesso. Resultado: " . print_r($this->resultado, true));
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
            throw new \Exception("Os dados do cliente criado não correspondem aos dados fornecidos");
        }
    }

    /**
     * @Then eu devo receber uma mensagem de erro
     */
    public function euDevoReceberUmaMensagemDeErro()
    {
        if (empty($this->erro)) {
            throw new \Exception("Era esperado um erro, mas nenhum ocorreu");
        }
    }

    /**
     * @Then o cliente não deve ser criado
     */
    public function oClienteNaoDeveSerCriado()
    {
        if ($this->resultado instanceof ClienteDTO) {
            throw new \Exception("Um cliente foi criado, mas não deveria ter sido");
        }
    }
}
