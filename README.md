# API de Despesas

Este repositório contém uma API de Despesas que permite gerenciar e acessar informações sobre despesas. Foi desenvolvido como parte de um teste técnico, sendo um case de estudo que visa demonstrar minha capacidade técnica e habilidades de desenvolvimento.

A API foi construída utilizando o framework Laravel 10, aproveitando seus recursos poderosos e sua vasta comunidade de desenvolvedores. Ela fornece funcionalidades como cadastro, consulta, atualização e exclusão de despesas, autenticação de usuários, restrição de acesso com base em políticas, validação de dados com Form Requests e transformação da API com API Resources.

É importante ressaltar que este projeto não tem a finalidade de ser uma aplicação em produção, mas sim um exemplo de implementação para avaliação técnica. Ele foi desenvolvido para demonstrar minha proficiência em desenvolvimento de APIs e seguir as melhores práticas de desenvolvimento.

Fique à vontade para explorar o código-fonte, revisar a estrutura e as funcionalidades implementadas, e entrar em contato caso tenha alguma dúvida ou sugestão de melhoria.

**Importante:** Este repositório e projeto são apenas para fins de demonstração e estudo, e não têm a intenção de serem usados em produção ou como uma solução completa para gerenciamento de despesas.

## Índice

- [API de Despesas](#api-de-despesas)
  - [Índice](#índice)
  - [Funcionalidades](#funcionalidades)
  - [Requisitos](#requisitos)
  - [Instalação](#instalação)
  - [API](#api)
    - [Testando a API com o Postman](#testando-a-api-com-o-postman)
    - [Autenticação](#autenticação)
    - [Despesas](#despesas)
  - [Detalhes técnicos](#detalhes-técnicos)
    - [Containerização com Laravel Sail e Docker](#containerização-com-laravel-sail-e-docker)
    - [Padrão de Commits Conventional Commit](#padrão-de-commits-conventional-commit)
      - [Como funciona o padrão Conventional Commit?](#como-funciona-o-padrão-conventional-commit)
    - [Testes com Pest Framework](#testes-com-pest-framework)
      - [Padrão de Teste do Pest](#padrão-de-teste-do-pest)
      - [Benefícios do Pest](#benefícios-do-pest)
      - [Sobre a relação com o PHPUnit](#sobre-a-relação-com-o-phpunit)
      - [Executando os testes](#executando-os-testes)
    - [Adição de Links ao Retorno da API (HATEOAS)](#adição-de-links-ao-retorno-da-api-hateoas)



## Funcionalidades

- Cadastro, consulta, atualização e exclusão de despesas
- Autenticação de usuários
- Restrição de acesso com base em políticas
- Validação de dados com Form Requests
- Transformação da API com API Resources
- Roteamento dos recursos utilizando API Resource Routes

## Requisitos

- Docker
- Docker Compose

## Instalação

1. Clone o repositório:

```shell
git clone https://github.com/albertoelias123/api-despesas.git
```

2. Execute o projeto utilizando o Laravel Sail:

```shell
./vendor/bin/sail up -d
```

Certifique-se de ter o Docker e o Docker Compose instalados no seu sistema.

3. Configure o arquivo .env com as informações do banco de dados e as demais configurações necessárias.

No arquivo .env.example estão algumas atributos para ativar o debug com o Laravel Sail, já esta configurado para utilizar basta descomentar a linha:
```env
SAIL_XDEBUG_MODE=develop,debug,coverage
```

Esse atributo `SAIL_XDEBUG_MODE` permite a utilização do XDEBUG para depuração e análise de cobertura de código.

4. Execute as migrações e seeders do banco de dados:

```shell
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
```

## API

### Testando a API com o Postman

Na pasta raiz do repositório, você encontrará um arquivo do Postman chamado `API Despesas.postman_collection.json`. Esse arquivo representa uma coleção de solicitações pré-configuradas que podem ser importadas no Postman para facilitar o teste e a exploração da API de Despesas desenvolvida neste projeto.

Para utilizar o arquivo de coleção do Postman e testar o funcionamento da API, siga as etapas abaixo:

1. Faça o download do arquivo `API Despesas.postman_collection.json` presente na pasta raiz do repositório.

2. Abra o Postman e clique no botão "Import" no canto superior esquerdo do aplicativo.

3. Na janela de importação, selecione a guia "File" e clique em "Upload Files".

4. Navegue até o local onde você salvou o arquivo `API Despesas.postman_collection.json` e selecione-o para importar.

5. Após a importação bem-sucedida, você verá a coleção "API Despesas" na barra lateral esquerda do Postman.

6. Clique na coleção para expandi-la e visualizar as solicitações disponíveis.

7. Para executar uma solicitação, clique nela e, em seguida, clique no botão "Send" para enviar a solicitação para a API. Observe as respostas recebidas e os detalhes das solicitações no painel direito.

8. Você pode explorar e modificar as solicitações existentes, bem como adicionar novas solicitações à coleção conforme necessário.

Utilizando o arquivo de coleção do Postman, você poderá realizar uma série de testes na API de Despesas de forma conveniente e eficiente, aproveitando as solicitações pré-configuradas. Isso permitirá que você verifique o funcionamento correto da API, teste diferentes endpoints e métodos, envie dados de teste e visualize as respostas retornadas pela API.

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
- Foi utilizado o padrão Conventional Commits
- Foi utilizado o Pest para realizar os Testes
- O ambiente de desenvolvimento está totalmente containerizado utilizando o Laravel Sail e Docker

### Containerização com Laravel Sail e Docker

O ambiente de desenvolvimento está totalmente containerizado utilizando o Laravel Sail e Docker. O Laravel Sail é uma maneira simples de configurar um ambiente de desenvolvimento local com Docker para projetos Laravel. Ele fornece um ambiente consistente e isolado para executar o aplicativo Laravel, juntamente com todas as suas dependências. Com o Docker, é possível garantir a portabilidade e a reprodução do ambiente de desenvolvimento em diferentes máquinas.

A utilização do Laravel Sail facilita a configuração do ambiente de desenvolvimento, fornecendo uma estrutura pré-configurada com os serviços necessários, como banco de dados, servidor web e outros. Além disso, a containerização permite isolar o ambiente de desenvolvimento, evitando conflitos entre dependências e facilitando a colaboração em equipe.

### Padrão de Commits Conventional Commit

Neste projeto, foi adotado o padrão de commits Conventional Commit para fornecer uma estrutura consistente e informativa para as mensagens de commit. Esse padrão ajuda a transmitir claramente a intenção de cada commit e facilita a geração de changelogs automatizados.

#### Como funciona o padrão Conventional Commit?

O padrão Conventional Commit segue uma convenção específica para as mensagens de commit, que consiste em três partes principais: tipo, escopo e descrição. Cada parte é separada por dois-pontos (:). Aqui está uma descrição detalhada de cada parte:

1. **Tipo**: Indica a natureza do commit e é representado por palavras-chave específicas. Alguns exemplos comuns de tipos são:

   - ✨ `:sparkles:` **feat**: Novo recurso adicionado ao projeto.
   - 🐛 `:bug:` **fix**: Correção de bug.
   - 📚 `:books:` **docs**: Alterações na documentação.
   - 🚀 `:rocket:` **chore**: Atualizações relacionadas a tarefas de manutenção.
   - ♻️ `:recycle:` **refactor**: Refatoração de código existente.
   - ✅ `:white_check_mark:` **test**: Adição ou modificação de testes.

2. **Escopo** (opcional): Refere-se à parte específica do projeto que está sendo afetada pelo commit. Nem todos os commits terão um escopo.

3. **Descrição**: Fornece uma breve descrição do que foi realizado no commit. Deve ser claro e conciso.

Ao seguir o padrão Conventional Commit e utilizar emojis para os tipos de commit, você contribui para um histórico de commits mais consistente e compreensível, facilitando a colaboração e o acompanhamento das mudanças no projeto.

### Testes com Pest Framework

Neste projeto, optei por utilizar o framework Pest para realizar os testes. Mas afinal, por que utilizei o Pest?

#### Padrão de Teste do Pest

Primeiramente, é importante destacar que o Pest segue um padrão de teste diferente do PHPUnit, que é o framework de teste mais comumente utilizado. Enquanto o PHPUnit utiliza uma estrutura baseada em classes e métodos para escrever testes, o Pest adota uma abordagem mais descritiva, utilizando funções auxiliares como `test`, `it`, `expect`, entre outras. Essa abordagem torna os testes mais legíveis e expressivos, seguindo o conceito de "teste como especificação".

#### Benefícios do Pest

Agora, vamos aos benefícios que me levaram a escolher o Pest como framework de teste para este projeto:

- **Sintaxe expressiva e legível**: A sintaxe fluente e descritiva do Pest facilita a leitura e compreensão dos testes, tornando-os mais claros e intuitivos para mim e para outros membros da equipe.

- **Execução paralela de testes**: O Pest permite a execução de testes em paralelo, o que é especialmente útil em projetos maiores, onde o tempo de execução dos testes pode ser significativo. Com a execução paralela, ganho uma melhoria no desempenho e consigo obter resultados mais rapidamente.

- **Análise de cobertura de código**: O Pest integra-se facilmente com ferramentas de análise de cobertura de código, o que me permite identificar áreas do código que não estão sendo testadas adequadamente. Isso contribui para melhorar a qualidade dos testes e garantir uma cobertura abrangente.

- **Modo de observação (watch mode)**: O Pest possui um recurso de modo de observação que monitora automaticamente as alterações nos arquivos de teste. Isso significa que, durante o desenvolvimento, posso realizar alterações no código e os testes relevantes serão executados automaticamente, proporcionando um fluxo de trabalho mais ágil e eficiente.

- **Testes de arquitetura (ainda não utilizado neste projeto)**: Embora não tenha sido aplicado neste projeto em particular, o Pest oferece recursos para realizar testes de arquitetura, o que é útil para verificar se as dependências e estruturas do projeto estão configuradas corretamente. Essa funcionalidade pode ser explorada em futuros projetos, caso necessário.

#### Sobre a relação com o PHPUnit

É importante mencionar que o Pest é construído em cima do PHPUnit, que é um framework de teste amplamente utilizado e confiável. O Pest utiliza o PHPUnit como base, fornecendo uma camada adicional de abstração e recursos específicos para testes mais descritivos. Portanto, posso aproveitar a robustez e a confiabilidade do PHPUnit, ao mesmo tempo em que utilizo a sintaxe expressiva e os recursos adicionais do Pest.

#### Executando os testes

Para executar os testes utilizando o Pest neste projeto, você pode seguir as seguintes etapas:

1. Inicie o ambiente de desenvolvimento utilizando o Laravel Sail:

```shell
./vendor/bin/sail up -d
```

Certifique-se de ter as dependências do projeto instaladas corretamente antes de executar os testes.

2. Execute os testes utilizando o comando a seguir:

```shell
./vendor/bin/sail test
``` 

Isso irá executar todos os testes definidos no projeto.

Além disso, o Pest oferece recursos avançados que podem ser úteis durante a execução dos testes. Aqui estão alguns exemplos:

- **Execução paralela dos testes**: Para executar os testes em paralelo e acelerar ainda mais o processo, utilize o seguinte comando:

```shell
./vendor/bin/sail test --parallel
```

- **Análise de tempo de execução (Profiling)**: Para identificar os testes mais lentos e otimizar o projeto, você pode executar a análise de tempo de execução. Utilize o seguinte comando:

```shell
./vendor/bin/sail test --profie
```

- **Análise de cobertura de testes**: O Pest também oferece a possibilidade de realizar uma análise de cobertura de testes. Para isso, execute o seguinte comando:

```shell
./vendor/bin/sail test --coverage
```

No projeto atual a cobertura esta por volta de 96%.

Essas são algumas opções que o Pest oferece para auxiliar na execução e análise dos testes. Aproveite esses recursos para garantir a qualidade e confiabilidade do seu código.

### Adição de Links ao Retorno da API (HATEOAS)

Ao projetar uma API, acredito que seja uma prática interessante adicionar links ao retorno das respostas, seguindo o padrão HATEOAS (Hypermedia as the Engine of Application State). Esses links permitem que os clientes interajam de forma mais dinâmica e descubram facilmente outras ações ou recursos relacionados ao objeto retornado. O padrão HATEOAS promove a descoberta e a navegação da API de forma mais autônoma e orientada pelo próprio recurso retornado.

No meu projeto, embora a adoção do padrão HATEOAS não fosse um requisito obrigatório/necessário, optei por utilizá-lo com o objetivo de demonstrar minha capacidade técnica e conhecimento sobre as melhores práticas de desenvolvimento de APIs.

A inclusão dos links da API no retorno dos recursos proporciona uma experiência de API enriquecida, permitindo que os clientes descubram e naveguem pelos recursos disponíveis de maneira flexível e autônoma. Essa abordagem mostra meu compromisso em fornecer uma solução bem projetada e alinhada com os padrões e melhores práticas da indústria.

É importante ressaltar que a adoção do padrão HATEOAS foi uma escolha consciente para demonstrar minha habilidade técnica e oferecer uma API mais robusta e intuitiva para os usuários. Embora não seja uma exigência específica do projeto, considerei importante utilizar esse padrão como uma oportunidade de aplicar conhecimentos avançados e fornecer uma experiência mais completa aos usuários da API.

Espero que a inclusão dos links no retorno da API, seguindo o padrão HATEOAS, proporcione uma interação mais intuitiva e enriqueça a experiência dos usuários ao utilizar minha API.
