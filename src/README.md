## Requisitos

Certifique-se de ter o Node.js e o npm instalados em sua máquina.

- [Node.js](https://nodejs.org/)
- [npm](https://www.npmjs.com/)
- [Nodemon](https://nodemon.io/)

## Instalação

Para iniciar o projeto em modo de desenvolvimento, é interessante instalar o Nodemon globalmente em sua máquina. Você pode fazer isso executando o seguinte comando:

```bash
npm install -g nodemon
```

Caso queira iniciar como produção, pode desconsiderar a instalação do nodemoon.

Certifique-se de ter o Node.js instalado antes de executar este comando.

## Configuração

1. Baixe os arquivos brutos e posicione-os na pasta WWW do Wampserver ou servidor análogo.

2. Já com a pasta aberta no IDE de sua escolha, navegue até a pasta `ws` no terminal de comando:

```bash
cd ws
```

3. Instale as dependências do projeto:

```bash
npm install
```

## Uso

Após a instalação das dependências, você pode iniciar o webservice utilizando o seguinte comando:

Iniciar em modo de desenvolvimento

```bash
nodemon server.js
```

Iniciar em modo de produção

```bash
node server.js
```

Certifique-se de que os arquivos `.env` estejam com as variáveis de ambiente devidamente preenchidas. É possível ver um exemplo de como ela deverá estar em `.env.exemple`.

## Finalização

Seguindo os passos acima, o seu front-end deve conseguir listar tudo o que o WebService está servindo.
