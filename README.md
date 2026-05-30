<h1 align="center">
  <img src="./assets/img/Logo.png" alt="GameXchange" width="200"/>
  <br/>
  GameXchange
</h1>

<p align="center">
  Marketplace para compra, venda e troca de jogos digitais
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white"/>
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white"/>
  <img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white"/>
  <img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white"/>
  <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black"/>
  <img src="https://img.shields.io/badge/C%23-239120?style=for-the-badge&logo=csharp&logoColor=white"/>
</p>

---

## Sobre o Projeto

O **GameXchange** é uma plataforma web de marketplace voltada para jogos digitais, onde usuários podem comprar, vender e trocar jogos. O projeto conta também com um painel administrativo desktop desenvolvido em C# para gerenciamento completo da plataforma.

Desenvolvido como Projeto Integrador do curso de **Técnico de Informática no Senac**, feito do zero por mim (Ryan) e pelo Matheus Guida. A ideia veio da nossa insatisfação com a interface da Steam — queríamos algo mais limpo e direto.

> **Nota:** A programação do projeto continua praticamente a mesma de quando foi desenvolvido originalmente. Com o tempo, fui aprendendo mais e percebi que algumas coisas podiam ser feitas de um jeito melhor — credenciais espalhadas por todo o código, senha salva sem hash, header copiado em cada arquivo. Então resolvi organizar tudo sem mudar a funcionalidade.

## Antes e Depois

| Antes | Depois |
|-------|--------|
| ![Código antes](./assets/img/antes.png) | ![Código depois](./assets/img/depois.png) |

---

## Funcionalidades

**Plataforma Web (PHP)**
- 🔐 Autenticação de usuários com sessões seguras (PDO + bcrypt)
- 🛒 Carrinho de compras com geração de chave de ativação
- 🔎 Busca e filtragem de jogos
- 🎟️ Sistema de cupons promocionais com desconto dinâmico
- 👤 Página de perfil com histórico de compras e chaves
- 🆘 Sistema de suporte com formulário de chamados

**Painel Administrativo (C#)**
- 👥 Gerenciamento de usuários
- 🎮 Gerenciamento de jogos (CRUD completo)
- 🏷️ Gerenciamento de cupons
- 🛍️ Gerenciamento de compras
- 📋 Visualização de chamados de suporte

---

## Tecnologias

| Camada | Tecnologia |
|--------|-----------|
| Backend | PHP 8 + PDO |
| Banco de Dados | MySQL |
| Frontend | HTML5, CSS3, JavaScript |
| Desktop Admin | C# (.NET / Windows Forms) |

---

## O que foi reorganizado

Depois de um tempo, voltei ao projeto e resolvi arrumar as partes ruins sem mudar o que funcionava:

**Segurança**
- Senhas agora são salvas com `password_hash()` (BCRYPT) e verificadas com `password_verify()` — antes ficavam em texto puro no banco
- Credenciais do banco foram para o `.env` — antes estavam repetidas em mais de 10 arquivos

**Organização**
- Todas as páginas PHP foram para `pages/` — antes ficavam todas soltas na raiz
- `login1`, `login2`, `login3` viraram `login`, `cadastro` e `cadastro_dados` — nomes que fazem sentido
- Header e footer viraram includes reutilizáveis — antes eram copiados em cada arquivo
- Criadas classes `Usuario` e `Jogo` para separar a lógica do banco do HTML
- `auth_guard.php` e `guest_guard.php` para proteger rotas de forma consistente

---

## Como Rodar o Projeto

### Pré-requisitos
- PHP 8+
- MySQL
- Servidor local (XAMPP, WAMP, Laragon ou similar)

### Passo a passo

```bash
# 1. Clone o repositório
git clone https://github.com/Nevek20/gameXchange.git
cd gameXchange

# 2. Copie o .env de exemplo e preencha com suas credenciais
cp .env.example .env

# 3. Importe o banco de dados
# Acesse o phpMyAdmin e importe o arquivo SQL do banco

# 4. Mova a pasta para o diretório do servidor
# Ex: C:/xampp/htdocs/gameXchange

# 5. Acesse no navegador
# http://localhost/gameXchange
```

### Painel Administrativo (C#)
Abra o projeto `.sln` no Visual Studio, configure a string de conexão com seu banco e execute.

---

## Estrutura do Projeto

```
gameXchange/
├── .env                  ← credenciais do banco (não sobe pro git)
├── .env.example          ← modelo para quem clonar
├── .gitignore
├── index.php             ← página inicial
├── classes/
│   ├── Database.php      ← conexão única com o banco (Singleton)
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
    ├── css/              ← folhas de estilo
    ├── js/               ← scripts
    └── img/              ← imagens e logo
```

---

## 🤝 Colaboradores

<p align="center">
  <img src="./assets/img/guida.png" alt="Matheus Guida" width="100" style="border-radius: 50%"/>
  &nbsp;&nbsp;&nbsp;&nbsp;
  <img src="./assets/img/ryan.png" alt="Ryan Germano" width="100" style="border-radius: 50%"/>
</p>

<p align="center">
  <strong>Matheus Guida</strong> &nbsp;&nbsp;&nbsp;&nbsp; <strong>Ryan Germano</strong>
</p>

<p align="center">
  <a href="https://github.com/nevek20">@nevek20</a>
</p>
