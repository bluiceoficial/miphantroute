# MiPhantRoute

**MiPhantRoute** é uma biblioteca **leve, minimalista e funcional em PHP** para **roteamento baseado em URL com suporte nativo a Expressões Regulares (Regex)**.

Ela foi criada para quem deseja **controle total**, **zero dependências** e **nenhuma abstração excessiva**, sendo ideal para todo tipo de projeto.

---

## ✨ Características

* Roteamento por URL com **Regex**
* Captura de parâmetros diretamente via regex
* Paradigma **funcional** (callbacks)
* Suporte a **PHP 8.4+**
* Compatível com servidor embutido (`php -S`)
* Extração de partes da URL
* Tratamento simples de **404**
* Zero dependências
* Código pequeno, legível e previsível

---

## 📦 Instalação

### Via Composer

```bash
composer require bluice/miphantroute
```

### Manual

Copie o arquivo `MiPhantRoute.php` para seu projeto e faça a inclusão via autoloader ou `require`.

---

## 🚀 Uso básico

```php
use MiPhantRoute\MiPhantRoute;

$route = new MiPhantRoute();

$route->getPart('/', function () {
    echo 'Página inicial';
});

$route->getPart('/contato', function () {
    echo 'Página de contato';
});

$route->getError(function () {
    http_response_code(404);
    echo '404 - Página não encontrada';
});
```

---

## 🌐 Funcionamento da URL

Para uma URL como:

```
/blog/post/123
```

A biblioteca gera internamente:

```php
[
  '/blog/post/123',
  ['blog', 'post', '123']
]
```

---

## 🧠 Roteamento com Regex

O método `getPart()` aceita **expressões regulares completas**, permitindo capturar parâmetros da URL automaticamente.

### Exemplo simples

```php
$route->getPart('/blog', function () {
    echo 'Página do blog';
});
```

---

### 📌 Captura de parâmetros

```php
$route->getPart('/blog/post/([0-9]+)', function ($id) {
    echo "Post ID: {$id}";
});
```

URL acessada:

```
/blog/post/42
```

Resultado:

```
Post ID: 42
```

---

### 📌 Múltiplos parâmetros

```php
$route->getPart('/user/([a-z]+)/([0-9]+)', function ($username, $id) {
    echo "Usuário: {$username} | ID: {$id}";
});
```

URL:

```
/user/joao/10
```

---

## 📖 Métodos auxiliares

### `getArrayURLs(): array`

```php
$route->getArrayURLs();
// ['blog', 'post', '123']
```

---

### `getFullURL(): string`

```php
$route->getFullURL();
// blog/post/123
```

---

### `getURL(int $index): string`

```php
$route->getURL(0); // blog
$route->getURL(1); // post
$route->getURL(2); // 123
```

---

### `getFirstURL(): string`

```php
$route->getFirstURL(); // blog
```

---

### `getPenultimateURL(): string`

```php
$route->getPenultimateURL(); // post
```

---

### `getLastURL(): string`

```php
$route->getLastURL(); // 123
```

---

## ❌ Tratamento de erro 404

Se nenhuma rota corresponder, o callback definido em `getError()` será executado:

```php
$route->getError(function () {
    http_response_code(404);
    echo 'Página não encontrada';
});
```

---

## 👤 Autor

**Murilo Gomes Julio**

🔗 [https://www.bluice.com.br](https://www.bluice.com.br)

📺 [https://youtube.com/@bluiceoficial](https://youtube.com/@bluiceoficial)

---

## 📜 License

Copyright (c) 2025-2026 Murilo Gomes Julio

Licensed under the [MIT](https://github.com/bluiceoficial/miphantroute/blob/main/LICENSE).

All contributions to the MiPhantRoute are subject to this license.
