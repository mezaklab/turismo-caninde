# 🌵 Conexão Cânions - Portal Turístico e Gastronômico

> **Plataforma regional privada focada na Região dos Cânions do Xingó (Canindé de São Francisco - SE & Piranhas - AL).**

[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-Proprietary-orange?style=for-the-badge)](#)

---

## 📌 Sobre o Projeto

O **Conexão Cânions** é um portal guia regional privado e marketplace B2B/SaaS desenvolvido para conectar viajantes aos melhores estabelecimentos da **Região dos Cânions do São Francisco**, abrangendo as cidades irmãs de **Canindé de São Francisco (SE)** e **Piranhas (AL)**.

A plataforma combina uma experiência visual imersiva em **Dark Mode (Design System Sertão Premium)** com facilidade de navegação para o turista explorar:
- 🍲 **Gastronomia Típica**: Peixes do Velho Chico, carne de sol sertaneja e culinária regional.
- 🏨 **Hospedagem & Pousadas**: Acomodações de qualidade nas duas cidades.
- 🚤 **Passeios & Ecoturismo**: Catamarãs nos Cânions do Xingó, Rota do Cangaço (Grota do Angico), Usina do Xingó e Mirantes.
- 💼 **Modelo Comercial B2B**: Anúncio e gestão de estabelecimentos parceiros com botão direto de contato e conversão via WhatsApp.

---

## 🛠️ Tecnologias Utilizadas (Tech Stack)

| Camada | Tecnologia | Descrição |
|---|---|---|
| **Backend** | **PHP 8.x** | Arquitetura modular e segura para renderização server-side |
| **Banco de Dados** | **MySQL** | Modelagem relacional para estabelecimentos, cidades e administração |
| **Frontend & UI** | **Tailwind CSS** | Design System Sertão Premium (`#0F172A`, `#18181B`, `#EA580C`, `#F59E0B`) |
| **Interatividade** | **JavaScript & Alpine.js** | Filtros instantâneos, controle de modais e reatividade sem reload |
| **Animações** | **CSS Keyframes + FontAwesome 6** | Page Loader cultural rítmico e ícones vetorizados |

---

## ✨ Funcionalidades Principais

- [x] **Guia Regional Integrado (SE/AL)**: Cobertura completa de Canindé de São Francisco (SE) e Piranhas (AL).
- [x] **Filtros Dinâmicos**: Busca em tempo real e filtragem instantânea por cidade e categoria gastronômica via Alpine.js.
- [x] **Página Individual do Estabelecimento (`restaurante.php`)**: Foto principal, prato destaque, horário de funcionamento, mapa e botão de ação direta para o WhatsApp do proprietário.
- [x] **Page Loader Cultural (Trio de Forró)**: Overlay rítmico com animação CSS da Sanfona, Zabumba e Triângulo e notas musicais flutuantes.
- [x] **Painel Administrativo (`/admin`)**: Sistema de autenticação e moderação de cadastros com status (`pendente`/`aprovado`).
- [x] **Formulário do Anunciante**: Cadastro público de estabelecimentos com análise prévia da equipe.

---

## 🚀 Como Rodar o Projeto Localmente

### Pré-requisitos
- Servidor Web local com suporte a PHP 8.x e MySQL (ex: **Laragon**, **XAMPP** ou **Docker**).

### Passo a Passo

1. **Clonar o Repositório**:
   ```bash
   git clone https://github.com/mezaklab/turismo-caninde.git
   cd turismo-caninde
   ```

2. **Configurar o Banco de Dados**:
   - Crie um banco de dados MySQL chamado `turismo_caninde` (ou altere o nome em `conexao.php`).
   - Importe o arquivo **`setup_database.sql`** localizado na raiz do projeto.

3. **Configurar a Conexão**:
   - Verifique o arquivo `conexao.php` e ajuste os dados se necessário:
     ```php
     $host = 'localhost';
     $db   = 'turismo_caninde';
     $user = 'root';
     $pass = '';
     ```

4. **Acessar a Aplicação**:
   - **Portal Público**: `http://localhost/turismo-caninde/`
   - **Painel Administrativo**: `http://localhost/turismo-caninde/admin/login.php`
   - **Credenciais de Teste ADM**:
     - **E-mail**: `admin@conexaocanions.com.br`
     - **Senha**: `admin123`

---

## 📁 Estrutura de Arquivos

```text
turismo-caninde/
├── README.md                  # Documentação oficial do repositório
├── .gitignore                 # Regras de exclusão do Git
├── conexao.php                # Conexão PDO com MySQL
├── index.php                  # Landing Page / Portal Principal
├── restaurantes.php           # Guia Gastronômico com filtros dinâmicos
├── restaurante.php            # Página Detalhada do Estabelecimento
├── setup_database.sql         # Script SQL de criação e povoamento da base
├── admin/                     # Painel de Controle Administrativo
│   ├── auth.php               # Proteção de sessão de usuário
│   ├── index.php              # Dashboard de métricas
│   ├── login.php              # Login seguro
│   └── restaurantes.php       # Gestão/Aprovação de estabelecimentos
├── assets/                    # Recursos visuais e imagens
│   └── images/                # Favicons, logos e imagens de atrativos
├── data/                      # Dados de backup e seed JSON
└── includes/                  # Componentes reutilizáveis (Page Loader)
    └── loader.php
```

---

## 📜 Licença

Desenvolvido para o ecossistema **Conexão Cânions**. Todos os direitos reservados aos idealizadores do projeto.
