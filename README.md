# Tutorial para configurar e rodar a aplicação com Docker

## 1. Pré-requisitos

* Docker instalado (Docker Desktop no Windows/macOS ou Docker Engine no Linux)
* Docker Compose instalado (normalmente já vem com Docker Desktop)
* Editor de código (VSCode recomendado)
* Conta com configurações no mailtrap (recomendado)

---

## 2. Clonar o projeto

```bash
git clone https://github.com/felipe-rodolfo/montinkchallange.git
cd montinkchallange
```

---

## 3. Configurar arquivo `.env`

* Copie o `.env.example` para `.env`

```bash
cp .env.example .env
```

* Ajuste as variáveis principais, principalmente:

```dotenv
APP_NAME=montink
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=montink
DB_PASSWORD=password

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=seu_mailtrap_username
MAIL_PASSWORD=seu_mailtrap_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=from@example.com
MAIL_FROM_NAME="${APP_NAME}"

QUEUE_CONNECTION=database
```

> **Importante:** Para Mail, recomendamos usar o [Mailtrap](https://mailtrap.io/) em ambiente dev/teste.

---

## 4. Build e subir os containers Docker

```bash
docker-compose up -d --build
```

Isso vai criar e subir os containers da aplicação, banco de dados, e fila (se configurada).

---

## 5. Executar comandos Artisan dentro do container

Como a aplicação está dentro do container, para rodar comandos Laravel use:

```bash
docker-compose exec montink_app php artisan migrate
```

Ou para outras tarefas:

```bash
docker-compose exec montink_app php artisan <comando>
```

---

## 6. Acessar o app no navegador

Abra seu navegador e acesse:

```
http://localhost:8000
```

(dependendo da porta configurada no `docker-compose.yml`)

---

## 7. Rodar o worker da fila (para envio de e-mail via queue)

Para processar os jobs da fila, execute:

```bash
docker-compose exec app php artisan queue:work
```

Deixe esse comando rodando em uma aba do terminal enquanto estiver testando o envio assíncrono.

---

## 8. Testar a aplicação

* Cadastre produtos com variações e estoque
* Compre produtos (adicionar ao carrinho)
* Finalize pedidos
* Confira o envio de e-mail no Mailtrap ([https://mailtrap.io/](https://mailtrap.io/))
* Teste webhook enviando POST para `/webhook/order-status` com JSON

---

## 9. Dica útil

* Para rodar Tinker:

```bash
docker-compose exec app php artisan tinker
```

* Alterações no código fonte são refletidas automaticamente pelo bind mount no Docker (se configurado no `docker-compose.yml`).

---

## 10. Parar containers

Quando quiser parar tudo:

```bash
docker-compose down
```
