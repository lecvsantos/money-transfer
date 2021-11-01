## Sobre

API RESTful desenvolvida com [Laravel 8](https://laravel.com/docs/8.x) com a finalidade de simular transferências monetárias entre dois usuários

## Instalação

#### Pré requisitos 

1. Docker instalado
2. Docker compose instalado

#### Executando a aplicação

Faça um clone do respositório no diretório desejado

```bash
git clone https://github.com/lecvsantos/money-transfer.git
```

Entre no diretório criado

```bash
cd money-transfer
```

Suba o container docker

**obs:** Caso tenha nginx/apache instalado com a porta 8080 em uso, desativar ou alterar a porta de uso no arquivo docker-compose.yml

```bash
docker-compose up -d
```

Vamos renomear o arquivo `.env.example` para apenas `.env`, e adicionar as informações de banco de dados

```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel_money_transfer
DB_USERNAME=root
DB_PASSWORD=root
```

Voltando para o terminal execute o seguinte comando para gerar o `APP_KEY` da aplicação

```bash
php artisan key:generate
```

Agora vamos rodar nossas migrations para criar de fato nosso banco de dados

```bash
docker exec -it money_transfer_app /bin/sh
php artisan migrate
```

Feito isso podemos executar nosso app acessando http://localhost:8080

### Exemplos de uso

Para utilizar a API leia a documentação feita com **POSTMAN**. Ela conta com vários exemplos de uso

- [Documentação API RESTful](https://documenter.getpostman.com/view/2905290/UVByKWAB)