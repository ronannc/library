## Sobre o Projeto

Projeto simples que implementa um CRUD de Livros. Foi feito usando Laravel Sail, uma interface de linha de comando leve para interagir com o ambiente de
desenvolvimento Docker padrão e Laravel Sanctum para autenticação.

## Como executar

- Clone o projeto: https://github.com/ronannc/library.git
- Dentro do diretório **library** executa o comando: ```./vendor/bin/sail up -d```

Pronto, agora a API CRUD de livros já está disponível para uso.

Para facilitar, você pode importar o arquivo ```Book Store.postman_collection.json``` no [Postman](https://postman.com/) para interagir com a aplicação.

## Teste

Para executar os teste automatizados basta rodar o comando ```./vendor/bin/sail composer test```

## License

The [Laravel framework](https://laravel.com/) is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
