# Backend Laravel CRUD

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


Este projeto é uma API desenvolvida em Laravel para gerenciamento de **Projetos** de energia solar, com funcionalidades
CRUD (Create, Read, Update, Delete). Ele segue uma arquitetura baseada em **Service**, **Repository** e **Interface**,
garantindo uma separação clara das responsabilidades e um código mais organizado.

## Requisitos

- PHP 8.3+
- Composer
- MySQL
- Docker
- Postman (para testar as rotas da API)

## Instalação

1. Clone o repositório:

```bash
git clone https://github.com/Jwfelinto/Backend-Laravel-CRUD.git
```

2. Instale as dependências:

```bash
composer install
```

3. Configure o arquivo `.env` com as informações do banco de dados:

```bash
cp .env.example .env
php artisan key:generate
```

4. Use o seguinte comando para iniciar o ambiente de desenvolvimento usando o Docker:

```bash
 docker-compose up --build -d
```

5. Acesse o container:

```bash
 docker compose exec app bash
 ```

6. Execute as migrations e seeders para configurar o banco de dados:

```bash
php artisan migrate --seed
```

## Estrutura do Projeto

- **App/Services**: Contém as regras de negócio e lógica de aplicação.
- **App/Repositories**: Responsável pela comunicação com o banco de dados, utilizando o padrão Repository.
- **App/Interfaces**: Define contratos para os repositórios.
- **App/Http/Controllers**: Controladores responsáveis por manipular as requisições e respostas da API.
- **App/Models**: Definição das entidades e relacionamentos do banco de dados.

## Testes

### Testes Unitários

O projeto possui testes unitários que podem ser executados com o PHPUnit. Para rodar os testes:

```bash
php artisan test
```

Atualmente, há testes para as models `Client`, `Project`, `Location`, `InstallationType`, `Tool` e `User`.

## Licença

Este projeto está licenciado sob a licença MIT.
