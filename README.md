# API de Despesas

Esta é uma API de Despesas que permite gerenciar e acessar informações sobre despesas. Ela foi construída utilizando o framework Laravel 10.

## Funcionalidades

- Cadastro, consulta, atualização e exclusão de despesas
- Autenticação de usuários
- Restrição de acesso com base em políticas
- Validação de dados com Form Requests
- Transformação da API com API Resources
- Roteamento dos recursos utilizando API Resource Routes

## Requisitos

- PHP >= 8.1
- Composer
- Laravel >= 10

## Instalação

1. Clone o repositório:

```shell
git clone https://github.com/albertoelias123/onfly-teste-api-rest.git
```

2. Execute o projeto utilizando o Laravel Sail:

```shell
./vendor/bin/sail up -d
```

3. Configure o arquivo .env com as informações do banco de dados e as demais configurações necessárias.

No arquivo .env.example estão algumas atributos para ativar o debug com o Laravel Sail, já esta configurado para utilizar basta descomentar a linha:
```env
SAIL_XDEBUG_MODE=develop,debug,coverage
```

4. Execute as migrações e seeders do banco de dados:

```shell
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
```

## API

### Autenticação
Faça uma solicitação de login para obter um token de acesso:


```bash
POST /api/login

{
  "email": "usuario@example.com",
  "password": "senha",
  "device_name": "dispositivo"
}
```

Use o token de acesso nas solicitações subsequentes adicionando o cabeçalho Authorization: Bearer {token}.


### Despesas

- Listar todas as despesas

```bash
GET /api/despesas
```

- Cadastrar uma nova despesa
```bash
POST /api/despesas

{
  "descricao": "Despesa 1",
  "valor": 100.00,
  "data": "2023-06-15",
  "dono": 1
}
```

- Consultar uma despesa específica
```bash
GET /api/despesas/{id}
```

- Atualizar uma despesa
```bash
PUT /api/despesas/{id}

{
  "descricao": "Despesa 1",
  "valor": 100.00,
  "data": "2023-06-15",
  "dono": 1
}
```

- Excluir uma despesa
```bash
DELETE /api/despesas/{id}
```

## Detalhes técnicos

- Validação dos dados da despesa é feita utilizando Form Requests.
- Transformação da API é realizada utilizando API Resources.
- Os recursos relacionados às despesas são roteados utilizando API Resource Routes.
- Restrição de acesso é feita utilizando Policies com regras adicionais e tipos de usuário definidos.

## Adição de Links ao Retorno da API

Uma prática interessante ao projetar uma API é adicionar links ao retorno das respostas, seguindo o padrão HATEOAS (Hypermedia as the Engine of Application State). Esses links permitem que os clientes interajam de forma mais dinâmica e descubram facilmente outras ações ou recursos relacionados ao objeto retornado. O padrão HATEOAS promove a descoberta e a navegação da API de forma mais autônoma e orientada pelo próprio recurso retornado.
