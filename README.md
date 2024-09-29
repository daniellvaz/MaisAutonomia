# Mais Autonomia

**Mais Autonomia** é um projeto desenvolvido com **PHP**, **Slim Framework**, **PDO**, e utiliza o **Composer** para gerenciamento de dependências. Este projeto oferece uma solução eficiente e flexível para gerenciar a autonomia no desenvolvimento de aplicações.

## Pré-requisitos

Para rodar este projeto, você precisará:

- [XAMPP](https://www.apachefriends.org/index.html) ou outro servidor local que suporte PHP.
- [Composer](https://getcomposer.org/) para gerenciamento de dependências.
- PHP 7.4 ou superior.

## Instalação e Configuração

### 1. Clonar o Repositório

Primeiro, clone o repositório em seu ambiente local:

```bash
  git clone https://github.com/seuusuario/mais-autonomia.git
```
### 2. Configuração do XAMPP
Certifique-se de que o Apache e MySQL estão rodando no XAMPP.
Coloque os arquivos do projeto na pasta htdocs do XAMPP para que fiquem acessíveis no navegador.
O caminho pode ser algo como C:/xampp/htdocs/mais-autonomia.

### 3. Instalar Dependências
Na raiz do projeto, execute o Composer para instalar as dependências:

```bash
composer install
```

###4. Configurar o Arquivo .env

Copie o arquivo .env.example para .env e ajuste as variáveis de ambiente conforme necessário:

```bash
cp .env.example .env
```

Exemplo básico do conteúdo do .env:
```env
APP_ENV=development
APP_DEBUG=true
BASE_PATH=/mais-autonomia

DB_HOST=localhost
DB_NAME=mais_autonomia
DB_USER=root
DB_PASS=
BASE_PATH=/mais-autonomia/public
```

* Certifique-se de ajustar os dados de conexão com o banco de dados, o ambiente de desenvolvimento e o base_path.

### 5. Configurar o Base Path no Slim Framework

Como o projeto está sendo rodado no XAMPP em um subdiretório (ex: localhost/mais-autonomia), é importante configurar o base_path no Slim Framework.

No arquivo de inicialização (geralmente public/index.php), adicione o seguinte código para configurar o base_path:

```php
use Slim\Factory\AppFactory;
  // Após o autoload
  require __DIR__ . '/../vendor/autoload.php';

  $app = AppFactory::create();
  // Garante que no arquivo .env tenho o caminho correto
  $app->setBasePath($_ENV['BASE_PATH']);
```
Isso garante que as rotas sejam corretamente resolvidas ao usar o projeto em um subdiretório.

## 6. Importar o Banco de Dados
Crie um banco de dados chamado mais_autonomia no MySQL usando o phpMyAdmin ou outro gerenciador de banco de dados.

Importe o arquivo SQL de configuração inicial, que pode ser encontrado em database/schema.sql, para criar as tabelas e estrutura básica do banco:

Acesse o phpMyAdmin em http://localhost/phpmyadmin/.

Selecione o banco de dados mais_autonomia.

Vá para a aba "Importar" e selecione o arquivo schema.sql.

Clique em "Executar".

### 7. Iniciar o Projeto
Com o XAMPP rodando e o projeto configurado, você pode acessar o projeto no navegador:

```ruby
  http://localhost/mais-autonomia
```
Se tudo estiver configurado corretamente, o sitema estará rodando e você verá a página inicial do projeto.

### Estrutura do Projeto
```bash
.
├── app/              # Código-fonte da aplicação
│   ├── controllers/   # Controladores da aplicação
│   └── database/      # Arquivos relacionados ao banco de dados (ex: schema.sql)
├── public/           # Raiz pública do projeto
│   └── index.php     # Ponto de entrada da aplicação
├── routes/           # Arquivos de rotas
│   └── web.php       # Definição das rotas da aplicação
├── vendor/           # Dependências instaladas via Composer
├── .env              # Arquivo de variáveis de ambiente
├── composer.json     # Arquivo de configuração do Composer
└── README.md         # Documentação do projeto
```

### Contribuição
Contribuições são bem-vindas! Sinta-se à vontade para enviar um pull request ou abrir uma issue.

### Licença
Este projeto está licenciado sob a MIT License.