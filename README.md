# Sistema de Vendas

O **Sistema de Vendas**, como o nome diz, é um **sistema simples com autenticação e cadastro** de três principais itens: `Pedido`, `Produto` e `TipoProduto`. O sistema possui uma Dashboard que mostra o valor total em reais de cada forma de pagamento e telas para cada um dos cadastros, com suas respectivas funções CRUD.

Essa ideia de sistema foi tirada de um de meus projetos de treinamento do profissionalizante, tentei manter o mais próximo ao original, mas implementando o máximo de funções aprendidas no curso do [SymfonyCast](https://symfonycasts.com/u/allan_rcos).

## Demonstração

![Demonstração do uso do projeto.](https://raw.githubusercontent.com/allan-rcos/sistema-de-vendas/refs/heads/master/assets/sistema-de-vendas.gif)

## Tecnologias
### 1. Básico ao Avançado de PHP;
   
### 2. TWIG templates:
- Layouts; 
- Macros.
  
### 3. POO:
- Interfaces;
- Traits;
- Classes Abstratas e outros.
  
### 4. Symfony Framework:
- Controllers;
- Commands;
- APIs;
- Security;
- Forms;
- Doctrine e seus relacionamentos;
- Dependency Injaction Attributes;
- Services;
- Testes de Unidade e Integração;
- Custom Validators;
- Paginação;
- Factory.

## Instalação

### 1. Crie uma pasta e extraia o código fonte:

Exemplo pelo git:

```bash
gh repo clone allan-rcos/sistema-de-vendas
```

### 2. Configure o Banco de Dados:

Foi utilizado para desenvolvimento o banco [MariaDB v5.5](https://mariadb.org/download/). Sua variável de ambiente segue esse modelo:

```env
DATABASE_URL="mysql://{USUÁRIO}:{SENHA}@127.0.0.1:3306/app?serverVersion=mariadb-{VERSÃO}&charset=utf8mb4"
```

O banco SQLite também está funcional, lembre-se de refazer as migrações. É só retirar o comentário no arquivo *.env*:

```env
...
#
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
# DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8.0.32&charset=utf8mb4"
# DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
# DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8"
...
```

Tutorial disponível na [documentação oficial do Symfony](https://symfony.com/doc/current/doctrine.html#configuring-the-database).

**OBS**: Por motivos desconhecidos o `docker compose up -d` não funciona bem, retorna erros.

### 3. Composer:

Instale o [Composer](https://getcomposer.org/download/) no seu computador e inicie o projeto:

```bash
composer install
```

### 4 Suba o banco de dados:

Crie a tabela, caso ela ainda não exista:

```bash
php bin/console doctrine:database:create
```

Rode as migrações:

```bash
symfony console doctrine:migrations:migrate
```

**OBS**: Caso receba um erro talvez seja necessário refazer as migrações. Então remova toda a pasta `./migrations` e recrie com o `MakeBundle` e rode novamente as migrações.

```bash
symfony console make:migration
```

Caso deseje já começar com dados fictícios é só rodar os Fixtures:
```bash
symfony console doctrine:fixtures:load
```

## Uso

### 1. Iniciando o servidor:

Rode na pasta raiz do projeto:

```bash
symfony serve -d
```

Então é só abrir o link https://127.0.0.1:8000/login, ele aparecerá no log do comando acima.

### 2. Registrando um usuário:

Caso tenha adicionado dados fictícios, vai possuir um email `admin@localhost.dev` com senha `admin`. Porém é possível registrar um usuário via linha de comando:

```bash
# Não se esqueça de substituir os valores.
symfony console app:register EMAIL PASSWORD REPEAT_PASSWORD NAME
```

## Roteiro

- [ ] JavaScript JQuery e suas principais bibliotecas para Symfony (Stimulus e UX-Turbo);
- [ ] Formulário de Pedidos (Aguardando a implementação acima);
- [ ] Barra de pesquisa.

## Status do Projeto

No momento estarei focando em outros frameworks para expandir meu conhecimento na linguagem PHP, porém aindá há tarefas incompletas nesse projeto que poderão ser atualizadas futuramente e inclusive estão no roteiro.

## Contribuir

Esse é um projeto de treinamento, portanto fique a vontade para cloná-lo.

## Licença

[MIT](https://choosealicense.com/licenses/mit/)
