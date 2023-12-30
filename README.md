
<p align="center">
  <img src="https://i.ibb.co/0JM4TmV/logolaranja.png" alt="App Screenshot">
</p>

# API GymPro 

GymPro é a mais nova API para gerenciamento adequado de treinos de alunos e exercícios em academias de musculação, No GymPRO os usuários podem visualizar alunos, controlar treinos, cadastrar novos exercícios e respectivos treinos. Além de poder exportar a agenda de treinos da semana de cada aluno.

## 🔧 Tecnologias utilizadas

Este projeto foi desenvolvido utilizando a arquitetura **MVC** com a linguagem PHP e o framework Laravel v.10 com banco de dados PostgreSQL. 

![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white)![Postgres](https://img.shields.io/badge/postgres-%23316192.svg?style=for-the-badge&logo=postgresql&logoColor=white)![Trello](https://img.shields.io/badge/Trello-%23026AA7.svg?style=for-the-badge&logo=Trello&logoColor=white)

Seguem abaixo as dependências externas utilizadas:


| Tecnologia | Uso |
| ------ | ------ |
| PHP | Linguagem adotada| 
| Laravel | Framework utilizado|
| Docker | Criação do banco PostgreSQL|
| Dbeaver | Manipulação do banco de dados|
| DomPdf | Preparação e retorno de arquivo pdf |
| MailTrap | Enviar e capturar emails |

## 🚀 Como executar o projeto

-Clonar o repositório https://github.com/0Duarte/projeto-academia_api

-Criar uma base de dados no PostgreSQL

-Criar um arquivo .env na raiz do projeto e preencher os seguintes parâmetros:
```
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

-Recomenda-se utilizar o Mailtrap para testar os emails
 
MAIL_MAILER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
```

-No prompt de comando executar :
```sh
composer install 
```
-Execute a seed para popular o banco de dados:
```sh
php artisan db:seed PopulatePlans
```
-Executar em seguida:
```sh
php artisan serve
```



## 💪📗 Documentação da API

### Endpoints -
#### S01 - Cadastro de Usuário

```http
  POST /api/users 
```
    Rota pública

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id`      | `int` | **Autoincremental**. Chave primaria |
| `name` | `string` | **Obrigatório**. Nome do usuário|
| `email` | `string` | **Obrigatório**. Email do usuário|
| `date_birth` | `date` | **Obrigatório**. Data de nascimento do usuário|
| `cpf` | `string` | **Obrigatório**. CPF do usuário, único e válido sem ponto|
| `password` | `string` | **Obrigatório**. Senha, min 8 máx 32 caracteres|
| `plan_id` | `int` | **Obrigatório**. Id do plano escolhido, 1 Bronze, 2 Prata, 3 Ouro|

| Plano   | Quantidade de estudantes       |
| :---------- | :--------- |  
Bronze | 10 usuários
Prata | 20 usuário
Ouro | Ilimitado



Request JSON exemplo
```http
  {
  "name": "João Silva",
  "cpf": "12345678909",
  "date_birth": "1990-05-15",
  "password": "SenhaSegura123",
  "email": "joao.silva@email.com",
  "plan_id": 2
}
```
Response JSON exemplo
```http
  {
  "name": "João Silva",
  "cpf": "12345678909",
  "date_birth": "1990-05-15",
  "password": "SenhaSegura123",
  "email": "joao.silva@email.com",
  "plan_id": 2,
  "updated_at": "2023-12-24T01:30:43.000000Z",
  "created_at": "2023-12-24T01:30:43.000000Z",
  "id": 25
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `201` | sucesso|
|  `400` | dados inválidos|

#### Exemplo de e-mail enviado para o usuário

![App Screenshot](https://i.ibb.co/GpY4VKd/emailscreenshot.png)
##

#### S02 - Login

```http
  POST /api/login
```
    Rota pública

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `email` | `string` | **Obrigatório**. Email do usuário|
| `password` | `string` | **Obrigatório**. Senha cadastrada|



Request JSON exemplo

```http
  {
	"email": "joao.silva@email.com",
    "password": "SenhaSegura123"
}
```
Response JSON

```http
  {
    "token": "17|0QjtXv10r5GLFnCc9Fm2MZ4uErDzI1WwcuIS0wbq7b846f76",
    "name": "João Silva"
}
```
    Token com expiração de 24hrs

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|
|  `400` | dados inválidos|
|  `401` | não autorizado|

##
#### S03 - Dashboard

```http
  GET /api/dashboard
```
    Rota privada, utilize o token recebido no login
| Parâmetro   | Descrição                           |
| :---------- | :---------------------------------- |
| `registered_students:` | Quantidade de estudantes cadastrados pelo usuário|
| `registered_exercises:`| Quantidade de exercícios cadastrados pelo usuário|
| `current_user_plan:`   | Plano atual do usuário|
| `remaining_students:` | Quantidade de cadastros restantes de estudantes|


Response JSON Exemplo

```http
  {
    "registered_students": 9,
    "registered_exercises": 2,
    "current_user_plan": "Plano Bronze",
    "remaining_students": 1
  }

```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | Sucesso|


##
#### S04 - Cadastro de exercícios

```http
  POST /api/exercises
```
    Rota privada, utilize o token retornado no login

Exemplo:

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `description` | `string` | Obrigatório e máximo de 255 caracteres|

Request JSON Exemplo

```http
  {
    "description": Supino
  }
```
Exemplo de resposta:

```http

	{
    "description": "Supino",
    "id": 1
    }

```

| Response Status| Descrição                           |
|  :---------    | :---------------------------------- |
|  `201` | Sucesso|
|  `400` | Erro: Dados inválidos|
|  `409` | Erro: Exercício já cadastrado para o mesmo usuário|





##
#### S05 - Listagem de exercícios

```http
  GET /api/exercises
```
    Rota privada, utilize o token retornado no login

Response exemplo:

```http
    {
        "id": 1,
        "description": "Supino"
    },
    {
        "id": 2,
        "description": "Voador"
     }
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | Sucesso|
|  `404` | Erro: Não encontrado|

##
#### S06 - Exclusão de exercício

```http
  DELETE /api/exercises/:id
```
    Rota privada, utilize o token retornado no login

Request exemplo:
`/api/exercises/1`
| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id` | `int` | **Obrigatório** número inteiro chave primaria|

Não há response no body em caso de sucesso


| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `204` | sucesso|
|  `403` | Erro: Exercício pertence a outro usuário|
|  `404` | Erro: Exercício não encontrado|
|  `409` | Erro: Exercício com treinos vinculados

---
#### S07 - Cadastro de estudante

```http
  POST /api/students
```
    Rota privada, utilize o token retornado no login

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id`      | `int` | **Autoincremental**. Chave primaria |
| `name`    | `string` | **Obrigatório**. uma string com máximo 255 caracteres|
| `email`   | `string` | **Obrigatório**. uma string com máximo de 255 caracteres, e única|
| `date_birth` | `date` | **Obrigatório** uma data no formato (yyyy-mm-dd)|
| `cpf` | `string` | **Obrigatório**. uma string com máximo de 14 caracteres, e única|
| `contact` | `string` | **Obrigatório**. telefone máximo de 20 caracteres|
| `user_id` | `int` | **Adicionado internamente**. id do usuário que cadastrou o estudante|
| `city` | `string` | cidade com máximo de 50 caracteres|
| `neighborhood` | `string` | bairro com máximo de 50 caracteres|
| `number` | `string` | número máximo de 30 caracteres|
| `street` | `string` |  rua com máximo de 30 caracteres'|
| `province` | `string` | estado com máximo de 2 caracteres'|
| `cep` | `string` | cep com máximo de 20 caracteres'|



Request JSON exemplo
```http
{   
    "name": "Usuário Teste",
    "email": "usuario@teste.com",
    "date_birth": "1985-05-10",
    "cpf": "12345678901",
    "contact": "55 11 9876-5432",
    "city": "Cidade",
    "neighborhood": "Bairro",
    "number": "123",
    "street": "Rua Principal",
    "province": "SP",
    "cep": "01234-567",
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `201` | sucesso|
|  `400` | Erro: dados inválidos|
|  `403` | Erro: Limite de estudantes atingido|


##

#### S08 - Listagem de estudantes

```http
  GET /api/students
    
Query params -> nome, cpf e email

```
    Rota privada, utilize o token retornado no login


Response JSON exemplo


```http
  {
    "id": 8,
    "name": "Usuário Teste",
    "email": "usuario@teste.com",
    "date_birth": "1990-01-01",
    "cpf": "12345678930",
    "contact": "55 11 1234-5678",
    "city": "São Paulo",
    "neighborhood": "Bela Vista",
    "number": "123",
    "street": "Rua ABC",
    "province": "SP",
    "cep": "01234-567"
  },
  {
    "id": 12,
    "name": "usuario1@teste.com",
    "email": "usuario@teste.com",
    "date_birth": "1990-01-01",
    "cpf": "12345678906",
    "contact": "55 11 1234-5678",
    "city": "São Paulo",
    "neighborhood": "Bela Vista",
    "number": "123",
    "street": "Rua ABC",
    "province": "SP",
    "cep": "01234-567"
  },
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|

##
#### S09 - Exclusão de estudante

```http
  DELETE /api/students/:id
```
    Rota privada, utilize o token retornado no login

Request exemplo
```http
/api/students/1
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `204` | sucesso|
|  `403` | Erro: estudante não pertence ao usuário|
|  `404` | Erro: estudante não encontrado|


##
#### S10 - Atualização de estudante

```http
  PUT /api/students/:id
```
    Rota privada, utilize o token retornado no login


| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id`      | `int` | **Autoincremental**. Chave primaria |
| `name`    | `string` | **Obrigatório**. uma string com máximo 255 caracteres|
| `email`   | `string` | **Obrigatório**. uma string com máximo de 255 caracteres, e única|
| `date_birth` | `date` | **Obrigatório** uma data no formato (yyyy-mm-dd)|
| `cpf` | `string` | **Obrigatório**. uma string com máximo de 14 caracteres, e única|
| `contact` | `string` | **Obrigatório**. telefone máximo de 20 caracteres|
| `user_id` | `int` | **Adicionado internamente**. id do usuário que cadastrou o estudante|
| `city` | `string` | cidade com máximo de 50 caracteres|
| `neighborhood` | `string` | bairro com máximo de 50 caracteres|
| `number` | `string` | número máximo de 30 caracteres|
| `street` | `string` |  rua com máximo de 30 caracteres'|
| `province` | `string` | estado com máximo de 2 caracteres'|
| `cep` | `string` | cep com máximo de 20 caracteres'|


Dados a serem atualizados são opcionais e seguem mesmas regras de validação do cadastro.

Exemplo de request:

```http
{
	{
    "name": "Usuário Teste",
    "email": "usuario@teste.com",
    "date_birth": "1990-01-01",
    "cpf": "12345678930",
    "contact": "55 11 1234-5678",
    "city": "São Paulo",
    "neighborhood": "Bela Vista",
  }
}
```

Exemplo de response:

```http
{
	{
    "id": "1"
    "name": "Usuário Teste",
    "email": "usuario@teste.com",
    "date_birth": "1990-01-01",
    "cpf": "12345678930",
    "contact": "55 11 1234-5678",
    "city": "São Paulo",
    "neighborhood": "Bela Vista",
  }
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|

##
#### S11 - Cadastro de treinos

```http
  POST /api/workouts
```
    Rota privada, utilize o token retornado no login

| Parâmetro     | Tipo       | Descrição                           |
| :----------   | :--------- | :---------------------------------- |
| `id`          | `int`      | **Obrigatório** número inteiro chave primaria|
| `student_id`  | `int`      | **Obrigatório** id do aluno associado|
| `exercise_id` | `int`      | **Obrigatório** id do exercício|
| `repetitions` | `int`      | **Obrigatório** número de repetições|
| `weight`      | `float`    | **Obrigatório** número decimal de peso|
| `break_time`  | `int`      | **Obrigatório** número de tempo de descanso|
| `day`         | `enum`     | **Obrigatório** valores: SEGUNDA,TERÇA, QUARTA, QUINTA, SEXTA, SÁBADO, DOMINGO|
| `observations`| `int`      | texto de observações|
| `time`        | `int`      | **Obrigatório** tempo de exercício|

:
Request exemplo
```http

	{
        "student_id": 1,
        "exercise_id": 2,
        "repetitions": 10,
        "weight": 50.5,
        "break_time": 60,
        "day": "QUARTA",
        "observations": "Alguma observação sobre o exercício.",
        "time": 120
    }

```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|
|  `400` | Erro: dados inválidos|
|  `409` | Erro: já existe um treino com esse exercício cadastrado nesse  dia|

##
#### S12 - Listagem de treinos por estudante

```http
  GET /api/students/:id/workouts
```
    Rota privada, utilize o token retornado no login

Request exemplo:
`/api/students/1/workouts`


Response exemplo
```http
	
{
    "student_id": 1,
    "student_name": "Usuário Teste",
    "workouts": {
        "SEGUNDA": [],
        "TERÇA": [
            {
            "student_id": 7,
            "exercise_id": 8,
            "break_time": 3,
            "repetitions": 10,
            "weight": "50.5",
            "time": 10,
            "observations": "Alguma observação sobre o exercício.",
            "day": "TERÇA"
            }
      ],
        "QUARTA": [],
        "QUINTA": [],
        "SEXTA": [],
        "SÁBADO": [],
        "DOMINGO": []
        }
    }

```


| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `204` | sucesso|


---
#### S13 - Listagem de um estudante

```http
  GET /api/students/:id
```
    Rota privada, utilize o token retornado no login

Request exemplo

```http
 /api/students/7
```

Response exemplo
```http
  {
   {
    "id": 7,
    "name": "Usuário Teste",
    "date_birth": "1990-01-01",
    "cpf": "42345678900",
    "contact": "55 11 1234-5678",
    "address": {
        "cep": "01234-567",
        "street": "Rua pato no tucupi",
        "province": "SC",
        "neighborhood": "Bela Vista",
        "city": "São Paulo",
        "complement": null,
        "number": "123"
    }
  }
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|


##

#### S14 - Exportação de PDF

```http
  GET /api/students/export
```
    Rota privada, utilize o token retornado no login

Request JSON exemplo
```http
/api/students/export?id=1
```

Response PDF

![App Screenshot](https://i.ibb.co/txZRBB6/pdf-screenshot.png)

 

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|


## 📋 Organização do projeto com Kanban

<img src="https://i.ibb.co/tCh7ZJF/trelloscreenshot.png" alt="Trello Screenshot">



## 🔨 Possíveis melhorias 

- Rota de login para estudante
- Adição de seed com exercícios padrões mais utilizados
- Rota para marcar treinos concluídos

## Considerações

- Este projeto foi desenvolvido como parte do curso **DevInHouse 2023**
- A api foi desenvolvida individualmente com base nos requisitos entregues através de um documento
- [Documentação de requisitos](https://docs.google.com/document/d/19rW97oM-mkPXb0iOcNEbAhKjDkqaC7MSK7okjguV1D0/edit?usp=sharing)



