# Backend Laravel CRUD
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


Este projeto é uma API desenvolvida em Laravel para gerenciamento de **Projetos** com funcionalidades de CRUD (Create, Read, Update, Delete). Ele segue uma arquitetura baseada em **Service**, **Repository** e **Interface**, garantindo uma separação clara das responsabilidades e um código mais organizado.

## Requisitos

- PHP 8.0+
- Composer
- MySQL
- Docker (opcional)
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


## Documentação da API

A documentação da API foi gerada utilizando o pacote **Swagger**. Para acessar a documentação, siga os passos abaixo:

1. Execute o comando para publicar a configuração do Swagger:

```bash
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

2. Gere a documentação Swagger:

```bash
php artisan l5-swagger:generate
```

3. Acesse a documentação no navegador através do caminho:

```
http://localhost:9000/api/documentation
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

Atualmente, há testes para a model `Project`, `Client` e `InstallationType`. Pretendo finalizar os testes assim que estiver com um tempinho disponível.

<!--## Contribuição

Contribuições são bem-vindas! Se você encontrar algum problema ou tiver sugestões, sinta-se à vontade para abrir uma issue ou enviar um pull request.-->

## Licença

Este projeto está licenciado sob a licença MIT.
