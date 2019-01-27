# Sistema gerador de relatórios a partir de arquivos .dat

## Dependências

Sistema desenvolvido utilizando o Laravel Framework na versão 5.7 seguindo os requisitos descritos [aqui](assets/prova_tecnica.pdf)

Suas dependências podem ser conferidas [aqui](https://laravel.com/docs/5.7#server-requirements)

## Configuração

Após clonar o projeto, com o terminal aberto na pasta do projeto, execute o comando:

```composer install --no-scripts```

Copie e renomeie o arquivo:

```.env.example```

para

```.env```

Crie uma nova chave para a aplicação com o comando:

```php artisan key:generate```

Pronto! Agora, para executar o sistema, utilize o comando:

```php artisan serve```

No navegador pode acessar o sistema através do endereço:

```http://127.0.0.1:8000```

ou então:

```localhost:8000```
