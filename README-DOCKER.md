# Guia de Uso do Docker para Laravel

## Pré-requisitos
- Docker instalado
- Docker Compose instalado (v2 ou superior)

## Configuração Inicial

1. **A aplicação já está rodando!** Se não estiver, execute:
```bash
docker compose up -d --build
```

2. **Instalar dependências (se necessário):**
```bash
docker compose exec app composer install
```

3. **Gerar chave da aplicação (se necessário):**
```bash
docker compose exec app php artisan key:generate
```

4. **Executar migrations:**
```bash
docker compose exec app php artisan migrate
```

5. **Executar seeders (opcional):**
```bash
docker compose exec app php artisan db:seed
```

## Comandos Úteis

### Gerenciar Containers
```bash
# Iniciar containers
docker compose up -d

# Parar containers
docker compose down

# Ver logs
docker compose logs -f

# Ver logs de um serviço específico
docker compose logs -f app
```

### Executar Comandos Artisan
```bash
docker compose exec app php artisan <comando>
```

### Executar Comandos Composer
```bash
docker compose exec app composer <comando>
```

### Acessar o Container
```bash
docker compose exec app bash
```

### Resetar o Banco de Dados
```bash
docker compose exec app php artisan migrate:fresh --seed
```

## Acessos

- **Aplicação Laravel:** http://localhost:8000
- **phpMyAdmin:** http://localhost:8080
  - Usuário: `jdsmart_user`
  - Senha: `livia!lourenzo@valentim#`

## Serviços

- **app:** Aplicação Laravel (PHP 8.2)
- **db:** Banco de dados MariaDB 10.11
- **phpmyadmin:** Interface web para gerenciar o banco de dados

## Troubleshooting

### Permissões
Se encontrar problemas de permissão:
```bash
docker compose exec app chown -R laravel:www-data /var/www/storage /var/www/bootstrap/cache
docker compose exec app chmod -R 775 /var/www/storage /var/www/bootstrap/cache
```

### Limpar Cache
```bash
docker compose exec app php artisan cache:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan view:clear
```

### Recriar Containers
```bash
docker compose down -v
docker compose up -d --build
```

## Nota sobre docker-compose vs docker compose
Este projeto usa a sintaxe `docker compose` (Docker Compose v2). Se você tiver apenas `docker-compose` instalado, substitua todos os comandos `docker compose` por `docker-compose`.
