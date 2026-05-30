# GameXchange

Plataforma de compra de jogos digitais, desenvolvida como Projeto Integrador (PI).

---

## Sobre o projeto

O GameXchange nasceu como projeto acadêmico, feito do zero por mim (Ryan) e pelo Matheus Guida. A ideia veio da nossa insatisfação com a interface da Steam — queríamos algo mais limpo e direto.

A programação do projeto continua praticamente a mesma de quando foi desenvolvido. Com o tempo, fui aprendendo mais e percebi que algumas coisas podiam ser feitas de um jeito melhor — credenciais espalhadas por todo o código, senha salva sem hash, header copiado em cada arquivo... Então resolvi organizar tudo sem mudar a funcionalidade.

---

## O que foi arrumado

**Segurança**
- Senhas agora são salvas com `password_hash()` (BCRYPT) e verificadas com `password_verify()` — antes ficavam em texto puro no banco
- Credenciais do banco saíram do código e foram pro `.env` — antes estavam repetidas em mais de 10 arquivos

**Organização**
- Todos os arquivos PHP de página foram para `pages/`
- `login1`, `login2`, `login3` viraram `login`, `cadastro` e `cadastro_dados` — nomes que fazem sentido
- Header e footer viram includes reutilizáveis — antes eram copiados em cada arquivo
- Criadas classes `Usuario` e `Jogo` para separar a lógica do banco do HTML
- `auth_guard.php` e `guest_guard.php` para proteger rotas de forma consistente
- Partials do index (vendidos, lançamentos, escolhas do editor) foram para dentro das classes

---

## Estrutura

```
gameXchange/
├── .env                  ← credenciais (não sobe pro git)
├── .env.example          ← modelo para quem clonar
├── .gitignore
├── index.php             ← página inicial
├── classes/
│   ├── Database.php      ← conexão única com o banco
│   ├── Usuario.php       ← cadastro, login, jogos comprados
│   └── Jogo.php          ← listagem, busca, detalhes
├── includes/
│   ├── header.php        ← header reutilizável
│   ├── footer.php        ← footer reutilizável
│   ├── auth_guard.php    ← redireciona quem não está logado
│   └── guest_guard.php   ← redireciona quem já está logado
├── pages/
│   ├── login.php
│   ├── cadastro.php
│   ├── cadastro_dados.php
│   ├── cadastro_concluido.php
│   ├── logout.php
│   ├── perfil.php
│   ├── jogo.php
│   ├── carrinho.php
│   ├── pesquisa.php
│   ├── finalizar_venda.php
│   ├── sobre.php
│   └── suporte.php
└── assets/
    ├── css/
    ├── js/
    └── img/
```

---

## Como rodar localmente

```bash
# 1. Clone o repositório
git clone https://github.com/Nevek20/gameXchange.git
cd gameXchange

# 2. Copie o .env de exemplo e preencha com suas credenciais
cp .env.example .env

# 3. Suba com um servidor PHP local (ex: XAMPP, Laragon, ou built-in)
php -S localhost:8000
```
