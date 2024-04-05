## Requisitos

Certifique-se de ter o Node.js e o npm instalados em sua máquina.

- [Node.js](https://nodejs.org/)
- [npm](https://www.npmjs.com/)
- [Nodemon](https://nodemon.io/)

## Instalação

Para iniciar o projeto, é necessário instalar o Nodemon globalmente em sua máquina. Você pode fazer isso executando o seguinte comando:

```bash
npm install -g nodemon
```

Certifique-se de ter o Node.js instalado antes de executar este comando.

## Configuração

1. Baixe os arquivos brutos e posicione-os na pasta WWW do Wampserver.

2. Já com a pasta aberta no IDE de sua escolha, navegue até a pasta `ws`:

```bash
cd ws
```

3. Instale as dependências do projeto:

```bash
npm install
```

## Uso

Após a instalação das dependências, você pode iniciar o webservice utilizando o seguinte comando:

```bash
node server.js
```

Certifique-se de que os arquivos `.env` estejam com as variáveis de ambiente devidamente preenchidas.

## Finalização

Seguindo os passos acima, o seu front-end deve conseguir listar tudo o que o WebService irá te servir.
