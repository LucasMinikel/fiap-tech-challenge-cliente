Feature: Criar Cliente
  Como um usuário do sistema
  Eu quero criar um novo cliente
  Para poder gerenciar suas informações

  Scenario: Criar um cliente com sucesso
    Given eu tenho os dados do cliente
      | nome      | cpf           | email            |
      | João Silva| 123.456.789-00| joao@example.com |
    When eu solicito a criação do cliente
    Then o cliente deve ser criado com sucesso
    And eu devo receber os dados do cliente criado

  Scenario: Tentar criar um cliente com dados inválidos
    Given eu tenho dados inválidos do cliente
      | nome      | cpf           | email            |
      |           | 123.456.789   | joao             |
    When eu solicito a criação do cliente
    Then eu devo receber uma mensagem de erro
    And o cliente não deve ser criado