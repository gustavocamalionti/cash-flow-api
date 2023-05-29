# CashFlow - Api

Temos dois tipos de usuários: usuários regulares e comerciantes. Ambos possuem uma carteira com fundos e fazem transferências entre si.

## Tecnologias

- PHP 8.1.
- Laravel 10.10
- Docker (MYSQL) com Laravel Sail.
- Swagger.
- Postman.
- Eloquent ORM.

## Estruturação e Lógica
- Routes: (Todas as rotas possuem prefixo v1, garantia de segurança se precisar de uma grande atualização.
- Requests: Contém todas as regras de validações.
- Controllers: (Se necessário, podemos filtrar a consulta e/ou especificar quais atributos quero de retorno).
- Services: (Adicionei A lógica de Classes Abstratas)
- Repositories (Adicionei A lógica de Classes Abstratas)
- Interfaces: Interfaces aplicadas nos dois métodos abstratos.
- Jobs: foram criados 3 Jobs para garantir uma boa performace da API (Transação, Email Pagador e Email Recebedor).
- ACID para as transações: (Atomicidade, Consistência, Isolamento e Durabilidade.) das transações.

## Arquitetura Geral - Fluxo de transação
![cash-flow](https://github.com/gustavocamalionti/cash-flow-api/assets/54083715/1e021c9a-1dd0-4b28-9772-9c7df9808eb2)

## Banco de Dados
![database](https://github.com/gustavocamalionti/cash-flow-api/assets/54083715/20b13986-249e-4117-94ee-5b2f7dc5dbf4)

## Documentação
Ao executar o projeto, acesse a rota http://localhost/api/documentation e visualize de forma simplificada todos os endpoints da aplicação.
![documentacao-geral](https://github.com/gustavocamalionti/cash-flow-api/assets/54083715/2a58a697-12aa-4f7b-a870-0879be3620b0)

