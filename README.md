# Teste 123 Milhas

Está Api faz parte de um teste proposto pela empresa [123 Milhas](https://123milhas.com/);

## Rodar o projeto local

##### Passo 1

```
$ git clone https://github.com/renemartins/123milhas
```

##### Passo 2

Adicione o .env do projeto utilizando o comando abaixo.

```
$ cp .env.example .env
```

##### Passo 3
OBS: Para execução do comando abaixo, você precisa ter na sua maquina o PHP e o Composer Instalado.

```
$ cd 123milhas/src/
$ composer install
```

## Sem Docker

##### Passo 4
```
$ php artisan serve
```

## Com Docker


##### Passo 4
```
$ docker-compose up -d
```

## Rotas

Docker
```
GET http://localhost:8080/api/flights
```

Sem Docker
```
GET http://localhost:8000/api/flights
```

## Docs

Docker
```
GET http://localhost:8080/api/documentation
```

Sem Docker
```
GET http://localhost:8000/api/documentation
```