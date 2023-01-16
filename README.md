## Sobre o Projeto

Projeto simples que implementa um CRUD de Livros.

## Como executar

- Clone o projeto: https://github.com/ronannc/library.git
- Dentro do diretório **library** executa o comando: ```docker-compose build app```
- Ainda dentro do diretorio execute: ```docker-compose up -d```
- E tambem: ```docker-compose exec app composer install```
- E logo em seguida: ```docker-compose exec app php artisan key:generate```
- Para migrar o banco: ```docker-compose exec app php artisan migrate```

Pronto, agora a API CRUD de livros já está disponível para uso.

Para facilitar, você pode importar o arquivo ```Book Store.postman_collection.json``` no [Postman](https://postman.com/) para interagir com a aplicação.

## Teste

Para executar os teste automatizados basta rodar o comando ```docker-compose exec app composer test```

## License

The [Laravel framework](https://laravel.com/) is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
