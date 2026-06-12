# 📋 Taskly — Kanban Board Premium

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-3.x-FB70A9?logo=livewire&logoColor=white)](https://livewire.laravel.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-77C1D2?logo=alpine.js&logoColor=black)](https://alpinejs.dev)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38BDF8?logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Software License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

O **Taskly** é um gerenciador de tarefas premium estilo Kanban (inspirado no Trello), desenvolvido com foco em alta performance, interatividade fluida e reatividade em tempo real. Este projeto foi estruturado com as tecnologias mais modernas do ecossistema Laravel, sendo ideal para demonstrar controle de estado complexo, otimização de consultas e reatividade avançada sem a sobrecarga de frameworks SPA pesados.

---

## ✨ Funcionalidades Principais

*   **⚡ Quadro Kanban Interativo (Drag-and-Drop):** Arraste e solte tarefas entre as colunas instantaneamente. A ordenação e a movimentação são salvas de forma assíncrona no banco de dados via **SortableJS** integrado ao Livewire.
*   **🔍 Filtros Reativos Instantâneos:** Barra de busca avançada e filtros por prioridade (**Baixa, Média, Alta**) ou por responsável. Graças ao `wire:model.live`, a tela reage em tempo real conforme você digita ou clica, sem recarregar a página.
*   **📝 Modal Detalhado de Tarefas:** Clique em qualquer card para abrir um modal premium com as informações completas da tarefa.
*   **✅ Checklist de Subtarefas:** Crie, exclua e marque subtarefas no estilo To-Do diretamente no modal. O progresso é calculado dinamicamente e exibido em uma barra de progresso animada.
*   **💾 Descrição com Auto-save:** A descrição da tarefa é salva no banco de dados automaticamente quando o campo perde o foco (`wire:change`), melhorando a experiência do usuário.
*   **✏️ Renomeação Inline de Quadros:** Altere o título do seu quadro diretamente no cabeçalho com validações em tempo real.
*   **👤 Atribuição de Responsáveis Dinâmica:** Popovers integrados no card e no modal para associar qualquer tarefa aos membros da equipe em apenas dois cliques.
*   **🔒 Segurança e Autorização:** Proteção completa no backend (Policies/Gates). Usuários só podem acessar, editar e excluir informações dos seus próprios quadros.
*   **🎨 UI Premium Dark Mode:** Interface construída com efeitos de *glassmorphism* (vidro fosco), cores harmoniosas da paleta Slate/Indigo, tipografia moderna (*Google Font Outfit*) e micro-interações para evitar *layout shifts* (Flickering/FOUC).

---

## 🛠️ Stack Tecnológica

*   **Backend:** Laravel (PHP 8.x), Eloquent ORM (relacionamentos de 1º e 2º nível).
*   **Frontend:** Livewire 3 (Reatividade no servidor), Alpine.js (Gestão de estado leve no cliente), Tailwind CSS (Estilização responsiva).
*   **Integrações JS:** SortableJS (Drag-and-drop), SweetAlert2 (Mensagens e modais de confirmação premium), Lucide Icons (Ícones vetoriais modernos).

---

## ⚙️ Instalação e Configuração Local

Siga o passo a passo abaixo para rodar o projeto em sua máquina de desenvolvimento.

### Pré-requisitos
*   **PHP** >= 8.2
*   **Composer**
*   **Node.js** & **NPM**
*   **SQLite** (ou outro banco de dados de sua preferência)

### Passo a Passo

1.  **Clonar o repositório:**
    ```bash
    git clone https://github.com/SEU_USUARIO/TaskManager.git
    cd TaskManager
    ```

2.  **Instalar as dependências do PHP:**
    ```bash
    composer install
    ```

3.  **Instalar as dependências do Frontend:**
    ```bash
    npm install
    ```

4.  **Configurar o arquivo de ambiente:**
    Copie o arquivo de exemplo e altere as configurações de banco de dados se necessário (por padrão, o Laravel está configurado para usar SQLite):
    ```bash
    cp .env.example .env
    ```

5.  **Gerar a chave da aplicação:**
    ```bash
    php artisan key:generate
    ```

6.  **Criar o banco de dados SQLite (Caso use a configuração padrão):**
    ```bash
    # No Windows (PowerShell):
    New-Item -ItemType File -Path database/database.sqlite -Force

    # No Linux/macOS:
    touch database/database.sqlite
    ```

7.  **Rodar as Migrations e Seeders:**
    Isso criará a estrutura das tabelas e alimentará o banco de dados com usuários, quadros, colunas e tarefas de exemplo para teste rápido:
    ```bash
    php artisan migrate --seed
    ```

8.  **Iniciar a Aplicação:**
    Em terminais separados, execute os servidores de desenvolvimento:
    ```bash
    # Servidor PHP Laravel
    php artisan serve

    # Compilação de assets frontend (caso use Vite)
    npm run dev
    ```

---

## 🔑 Credenciais de Teste (Seeder)

Ao rodar as migrations com o comando `--seed`, o sistema cria um usuário administrativo padrão para testes:

*   **E-mail:** `admin@teste.com`
*   **Senha:** `password`

---

## 📈 Boas Práticas Adotadas

Este projeto foi desenvolvido seguindo padrões profissionais de engenharia de software para destaque em portfólio:

*   **Conventional Commits:** Histórico de commits padronizado utilizando prefixos semânticos (`feat:`, `fix:`, `style:`, `refactor:`).
*   **Arquitetura Limpa:** Regras de negócio centralizadas no Eloquent ORM e lógica de interface reativa encapsulada em componentes do Livewire.
*   **Performance:** Redução de requisições desnecessárias usando técnicas de escuta e atualização otimizada de relacionamentos.

---

## 📄 Licença

Este projeto está licenciado sob a licença MIT. Consulte o arquivo [LICENSE](LICENSE) para obter mais informações.
