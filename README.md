# Laravel 11 - Setup Base com Autenticação Completa

Este projeto é um setup base para aplicações Laravel 11 com funcionalidades completas de autenticação, recuperação de senha, e gerenciamento de usuários. Ideal para iniciar novos projetos com uma base sólida seguindo boas práticas e padrões como Use Cases, Repositórios, Form Requests e Controllers separados.

## ✅ Recursos Implementados

### 🧑‍💻 Autenticação
- Registro de usuário
- Login com JWT
- Logout
- Refresh de token
- Remember-me (persistência opcional de sessão)
- Middleware de proteção de rotas
- 2FA (planejado)
- Recuperação de senha via email (esqueci minha senha / reset com token)

### 👤 Usuários
- Cadastro de usuário (com validação)
- Listagem de usuários
- Visualização de usuário por ID
- Atualização de dados do usuário
- Exclusão de usuário
- Todas as operações protegidas por autenticação JWT

## 🔐 Rotas de Autenticação

| Método | Rota                        | Descrição                        | Middleware     |
|--------|-----------------------------|----------------------------------|----------------|
| POST   | `/api/auth/register`        | Cadastra um novo usuário         | -              |
| POST   | `/api/auth/login`           | Realiza login e retorna tokens   | -              |
| POST   | `/api/auth/logout`          | Realiza logout                   | auth:api       |
| POST   | `/api/auth/refresh`         | Gera novo token                  | auth:api       |
| POST   | `/api/auth/forgot-password` | Envia email com token de reset   | -              |
| POST   | `/api/auth/reset-password`  | Redefine senha com token enviado | -              |
| POST   | `/api/auth/change-password` | Alterar senha do usuário logado  | auth:api              |
| POST   | `/api/auth/2fa/enabled`     | Ativar 2FA                       | auth:api              |
| POST   | `/api/auth/2fa/disabled`    | Desativar 2FA                    | auth:api              |
| POST   | `/api/auth/2fa/validate`    | Validar 2FA                      | auth:api              |

## 👥 Rotas de Usuários

| Método | Rota                | Descrição                          | Middleware     |
|--------|---------------------|------------------------------------|----------------|
| GET    | `/api/users`        | Lista todos os usuários            | auth:api       |
| GET    | `/api/users/{id}`   | Detalhes de um usuário             | auth:api       |
| POST   | `/api/users`        | Cadastra um novo usuário           | auth:api       |
| PUT    | `/api/users/{id}`   | Atualiza dados do usuário          | auth:api       |
| DELETE | `/api/users/{id}`   | Remove um usuário                  | auth:api       |

## 🔧 Tecnologias & Boas Práticas
- Laravel 11
- JWT para autenticação (`tymon/jwt-auth`)
- SOLID e Clean Architecture
- Form Requests para validação
- Use Cases para separação de regras de negócio
- Repositórios para acesso aos dados
- Tailwind para notificações visuais (se aplicável)
- Pronto para deploy no Render

## 🚀 Como rodar o projeto

1. Clone o repositório:
    ```bash
    git clone https://github.com/edilson99noslide/Setup-Inicial-Laravel-11-Docker.git
    ```
   
2. Instale as dependências
    ```bash
    composer install
    ```
   
3. Copie o `.env`
    ```bash
    cp .env.example .env
    ```
   
4. Gere a chave da aplicação
    ```bash
    php artisan key:generate
    ```

5. Gere a chave JWT
    ```bash
    php artisan jwt:secret
    ```

6. Rode as migrations
    ```bash
    php artisan migrate
    ```

## ✉️ Observações

- O envio de emails está usando `log` como driver por padrão.
- Para produção, configure o .env com seu serviço SMTP.
