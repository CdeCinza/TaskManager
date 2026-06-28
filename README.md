# Taskly - Gerenciador de Tarefas, Kanban, Agenda e Helpdesk

Taskly é um projeto pessoal de portfólio criado por **Matheus Marques** para fins exclusivamente didáticos e de evolução técnica pessoal.  

[GitHub](https://github.com/CdeCinza) | [LinkedIn](https://www.linkedin.com/in/matheus-marques-fernandes-vieiracln/)

> [!IMPORTANT]
> **Aviso de Projeto Educacional Fictício / Disclaimer:**
> * **Português:** Este projeto é 100% fictício, independente e educacional, desenvolvido apenas para fins de estudo e portfólio. As funcionalidades, dados, telas, fluxos e regras de negócio foram criados do zero com base em padrões públicos comuns de mercado de ferramentas de produtividade e Kanban.
> * **English:** This is a 100% fictional, independent, and educational project built solely for self-study and personal portfolio purposes.
> * **Español:** Este proyecto es 100% ficticio, independiente y educativo, desarrollado solo con fines de estudio y portafolio.

---

## Portugues

### Sobre o projeto

O **Taskly** é um projeto pessoal de portfólio desenvolvido para praticar e demonstrar minhas habilidades de desenvolvimento com PHP, Laravel, MySQL e Livewire. O foco do projeto foi o aprendizado prático de modelagem relacional de dados, estruturação de fluxos lógicos e criação de componentes dinâmicos de interface.

A proposta é simular, de forma simplificada e independente, recursos comuns presentes em ferramentas de produtividade de mercado:

- Quadro Kanban com drag and drop (movimentação visual de tarefas).
- Fluxo de chamados (helpdesk fictício) para suporte e registro de atendimento.
- Dashboard com indicadores consolidados e logs de atividades.
- Agenda em formato de calendário para visualização de prazos.
- Relatórios operacionais para acompanhamento de dados.
- Upload de anexos e arquivos simulados nas tarefas.
- Autenticação e isolamento seguro de dados entre diferentes usuários.

O objetivo é apresentar um projeto prático e organizado, demonstrando evolução pessoal em boas práticas de programação e arquitetura de software no ecossistema PHP/Laravel.

### Funcionalidades

- Autenticacao de usuarios.
- Dashboard com KPIs de quadros, tarefas, conclusoes, atrasos, prioridades, membros e resumo de chamados em risco de SLA.
- Dashboard acionavel com:
  - Minha Semana.
  - Tarefas de hoje, amanha e da semana.
  - Tarefas atrasadas e sem responsavel.
  - Quadros com mais risco e atividades recentes relevantes.
  - Chamados proximos do vencimento ou do limite de SLA.
- Quadro Kanban com colunas e cards.
- Drag and drop de tarefas com persistencia no banco.
- Criacao, edicao, exclusao e restauracao de tarefas.
- Lixeira com soft delete.
- Modal detalhado de tarefa.
- Prioridades: baixa, media e alta.
- Responsavel por tarefa.
- Subtarefas com progresso.
- Data de vencimento.
- Anexos em tarefas com suporte a imagens, PDFs e documentos.
- Central de Chamados (`/tickets`):
  - Quadro Kanban de chamados separado por status (Aberto, Em atendimento, Aguardando, Resolvido).
  - Controle de prazos e prazos de SLA (com alerta visual para SLA vencido ou em risco).
  - Vinculo opcional do chamado a um quadro (board) e a um responsavel.
  - Informacoes completas de solicitante (nome, e-mail) e origem do chamado (portal, e-mail, whatsapp, telefone).
  - Checklist operacional interno por chamado com progresso dinâmico (%).
  - Busca de chamados por titulo ou solicitante e filtros por status e prioridade.
  - Upload, listagem, abertura e exclusao de anexos em chamados, incluindo PDFs e documentos.
- Agenda em `/calendar` com visualizacao mensal, semanal e em lista.
- Relatorios em `/reports` com indicadores por periodo, desempenho por membros, graficos e opcao de exportar/imprimir como PDF pelo navegador.
- Filtros por prioridade e quadro.
- Interface dark responsiva.
- Alternancia visual de tema.
- Identidade visual propria com logo e favicon.
- Suporte visual a PT, EN e ES.
- **Arquitetura DRY e Limpeza de Código**: Extração do Sidebar e do seletor de idiomas para componentes Blade reutilizáveis e centralização lógica usando Traits do PHP.
- **Otimização de Transições SPA**: Uso correto do `data-navigate-once` do Livewire para evitar o carregamento/processamento redundante de assets (como Tailwind Play CDN, Chart.js e Lucide) nas mudanças de rota, acelerando as transições de página.
- **Resolução de Concorrência Reativa**: Comunicação orientada a eventos no Alpine.js para fechar dropdowns ativos ao abrir outros, impedindo sobreposições visuais.
- **Interface e Detalhes Polidos**: Checkboxes customizados para login e registro integrados ao estilo visual dark do tema.

### Stack

- **Backend:** PHP 8.3, Laravel 13, Eloquent ORM.
- **Frontend:** Livewire 4, Alpine.js, Tailwind CSS 4, Vite.
- **UI/UX:** Lucide Icons, SweetAlert2, SortableJS, Chart.js.
- **Banco de dados:** MySQL como banco principal em ambiente local, podendo ser adaptado para SQLite/PostgreSQL.

### Como executar localmente

#### Pre-requisitos

- PHP 8.3+
- Composer
- Node.js e NPM
- MySQL ou outro banco configurado no `.env`

#### Passos

```bash
git clone https://github.com/CdeCinza/TaskManager.git
cd TaskManager
```

```bash
composer install
npm install
```

```bash
cp .env.example .env
php artisan key:generate
```

Se for usar SQLite:

```bash
touch database/database.sqlite
```

No Windows PowerShell:

```powershell
New-Item -ItemType File -Path database/database.sqlite -Force
```

Depois execute:

```bash
php artisan migrate --seed
```

Crie tambem o link publico de storage para abrir anexos enviados:

```bash
php artisan storage:link
```

Para iniciar o ambiente de desenvolvimento:

```bash
php artisan serve
npm run dev
```

Ou use o script integrado:

```bash
composer run dev
```

### Usuario de teste

Ao rodar os seeders, o projeto cria um usuario padrao:

```text
E-mail: admin@teste.com
Senha: password
```

### Autor

Desenvolvido por **Matheus Marques**.

- GitHub: [github.com/CdeCinza](https://github.com/CdeCinza)
- LinkedIn: [Matheus Marques](https://www.linkedin.com/in/matheus-marques-fernandes-vieiracln/)

---

## English

### About the project

**Taskly** is a personal, independent portfolio project built by **Matheus Marques** for educational purposes. It was designed to explore and demonstrate practical backend development skills, clean code, database design, and reactive component integration.

The project implements generic features common in productivity tools:

- Kanban board layout with drag and drop capabilities.
- Basic ticketing system layout for support logging.
- Consolidated dashboard with metrics and activity feeds.
- Deadline tracking through a calendar view.
- Operational metrics display ready for report layouts.
- Simulated attachment uploads.
- Secure database isolation separating user workspaces.

The goal is to show personal technical evolution, software organization, and programming best practices using Laravel and Livewire.

### Features

- User authentication.
- Dashboard with KPIs for boards, tasks, completions, overdue items, priority breakdown, and ticket summary (open tickets, SLA risk).
- Actionable dashboard with:
  - My Week view.
  - Tasks due today, tomorrow, and this week.
  - Overdue and unassigned tasks.
  - Higher risk boards and recent activity feed.
  - Tickets due soon or in risk of SLA.
- Kanban board with columns and cards.
- Drag and drop task movement with database persistence.
- Create, edit, delete and restore tasks.
- Trash with soft delete.
- Detailed task modal.
- Priorities: low, medium and high.
- Task assignee.
- Subtasks with progress tracking.
- Due dates.
- Task attachments with support for images, PDFs and documents.
- Helpdesk / Ticket Management (`/tickets`):
  - Support ticket Kanban board categorized by status (Open, In progress, Waiting, Resolved).
  - SLA tracking and deadline warnings (with visual indicators for breached or at-risk SLAs).
  - Optional ticket association with a specific board and assignee.
  - Requester information (name, email) and ticket origin (portal, email, whatsapp, phone).
  - Internal operational checklist per ticket with live progress tracker (%).
  - Ticket search by title or requester, plus filters by status and priority.
  - Upload, list, open and delete ticket attachments, including PDFs and documents.
- Calendar page at `/calendar` with monthly, weekly and list views.
- Reports page at `/reports` with period-based indicators, member performance, charts and browser PDF/print export.
- Filters by priority and board.
- Responsive dark interface.
- Visual theme toggle.
- Custom visual identity with logo and favicon.
- Visual support for Portuguese, English and Spanish.
- **DRY Architecture & Clean Code**: Sidebar and language selectors extracted into reusable Blade components, with logic consolidated into PHP Traits.
- **SPA Transition Performance**: Correct application of Livewire's `data-navigate-once` to prevent redundant reload/compilation of heavy scripts (e.g. Tailwind Play CDN, Chart.js, Lucide), making route transitions instantaneous.
- **Reactive State Coordination**: Event-driven communication in Alpine.js preventing overlay conflicts between card popovers/dropdowns.
- **Polished UI Details**: Customized styled checkboxes for login and registration views integrated with the application's dark theme.

### Tech stack

- **Backend:** PHP 8.3, Laravel 13, Eloquent ORM.
- **Frontend:** Livewire 4, Alpine.js, Tailwind CSS 4, Vite.
- **UI/UX:** Lucide Icons, SweetAlert2, SortableJS, Chart.js.
- **Database:** MySQL as the main local database, adaptable to SQLite/PostgreSQL.

### Running locally

#### Requirements

- PHP 8.3+
- Composer
- Node.js and NPM
- MySQL or another database configured in `.env`

#### Steps

```bash
git clone https://github.com/CdeCinza/TaskManager.git
cd TaskManager
```

```bash
composer install
npm install
```

```bash
cp .env.example .env
php artisan key:generate
```

If using SQLite:

```bash
touch database/database.sqlite
```

On Windows PowerShell:

```powershell
New-Item -ItemType File -Path database/database.sqlite -Force
```

Then run:

```bash
php artisan migrate --seed
```

Create the public storage link so uploaded attachments can be opened:

```bash
php artisan storage:link
```

Start the development servers:

```bash
php artisan serve
npm run dev
```

Or use the integrated script:

```bash
composer run dev
```

### Test user

After running the seeders, the project creates a default user:

```text
Email: admin@teste.com
Password: password
```

### Author

Developed by **Matheus Marques**.

- GitHub: [github.com/CdeCinza](https://github.com/CdeCinza)
- LinkedIn: [Matheus Marques](https://www.linkedin.com/in/matheus-marques-fernandes-vieiracln/)

---

## Espanol

### Sobre el proyecto

**Taskly** es un proyecto personal e independiente de portafolio creado por **Matheus Marques** con fines educativos. Fue desarrollado para practicar y demostrar habilidades técnicas con PHP, Laravel, bases de datos relacionales y componentes reactivos.

La aplicación simula funciones comunes del mercado de productividad y organización:

- Tablero Kanban con drag and drop (movimiento visual de tareas).
- Flujo básico de tickets para soporte y registro.
- Dashboard consolidado con indicadores de estado y actividades.
- Seguimiento de plazos mediante una vista de calendario.
- Módulos de reportes visuales listos para diseño de impresión.
- Carga de archivos adjuntos simulados.
- Aislamiento seguro de datos entre cuentas de usuario.

El objetivo es presentar una estructura de código bien organizada que demuestre la evolución personal y las buenas prácticas de programación en PHP/Laravel.

### Funcionalidades

- Autenticacion de usuarios.
- Dashboard con KPIs de tableros, tareas, finalizaciones, atrasos, prioridades, miembros y resumen de tickets en riesgo de SLA.
- Dashboard accionable con:
  - Vista Mi Semana.
  - Tareas de hoy, manana y esta semana.
  - Tareas atrasadas y sin responsable.
  - Tableros con mayor riesgo y actividades recientes relevantes.
  - Tickets proximos a vencer o en riesgo de SLA.
- Tablero Kanban con columnas y tarjetas.
- Movimiento de tareas con drag and drop y persistencia en base de datos.
- Crear, editar, eliminar y restaurar tareas.
- Papelera con soft delete.
- Modal detallado de tarea.
- Prioridades: baja, media y alta.
- Responsable por tarea.
- Subtareas con seguimiento de progreso.
- Fechas de vencimiento.
- Adjuntos en tareas con soporte para imagenes, PDFs y documentos.
- Gestion de Tickets / Helpdesk (`/tickets`):
  - Tablero Kanban de tickets categorizado por estado (Abierto, En atencion, Esperando, Resuelto).
  - Control de plazos y vencimientos de SLA (con alertas visuales para SLA vencido o en riesgo).
  - Vinculo opcional del ticket a un tablero (board) y a un responsable.
  - Informacion completa del solicitante (nombre, correo) y origen del ticket (portal, correo, whatsapp, telefono).
  - Checklist operacional interno por ticket con progreso dinámico (%).
  - Busqueda de tickets por titulo o solicitante y filtros por estado y prioridad.
  - Carga, listado, apertura y eliminacion de adjuntos en tickets, incluyendo PDFs y documentos.
- Pagina de agenda en `/calendar` con vistas mensual, semanal y de lista.
- Pagina de reportes en `/reports` con indicadores por periodo, desempeno por miembros, graficos y opcion de exportar/imprimir como PDF desde el navegador.
- Filtros por prioridad y tablero.
- Interfaz dark responsiva.
- Alternancia visual de tema.
- Identidade visual propia con logo e favicon.
- Soporte visual para portugues, ingles y espanol.
- **Arquitectura DRY y Código Limpio**: Barra lateral y selectores de idioma extraídos en componentes Blade reutilizables, centralizando la lógica con PHP Traits.
- **Rendimiento de Transición SPA**: Aplicación de `data-navigate-once` de Livewire para evitar la recarga/procesamiento redundante de scripts pesados (como Tailwind Play CDN, Chart.js, Lucide) al cambiar de ruta, acelerando las transiciones de página.
- **Coordinación de Estado Reactivo**: Comunicación orientada a eventos en Alpine.js que evita la superposición indeseada entre los menús desplegables de las tarjetas.
- **Detalles Visuales Pulidos**: Checkboxes personalizados para inicio de sesión y registro integrados con el tema oscuro de la aplicación.

### Stack tecnologico

- **Backend:** PHP 8.3, Laravel 13, Eloquent ORM.
- **Frontend:** Livewire 4, Alpine.js, Tailwind CSS 4, Vite.
- **UI/UX:** Lucide Icons, SweetAlert2, SortableJS, Chart.js.
- **Base de datos:** MySQL como base principal en ambiente local, adaptable a SQLite/PostgreSQL.

### Como ejecutar localmente

#### Requisitos

- PHP 8.3+
- Composer
- Node.js y NPM
- MySQL u otra base de datos configurada en `.env`

#### Pasos

```bash
git clone https://github.com/CdeCinza/TaskManager.git
cd TaskManager
```

```bash
composer install
npm install
```

```bash
cp .env.example .env
php artisan key:generate
```

Si vas a usar SQLite:

```bash
touch database/database.sqlite
```

En Windows PowerShell:

```powershell
New-Item -ItemType File -Path database/database.sqlite -Force
```

Luego ejecuta:

```bash
php artisan migrate --seed
```

Crea tambien el enlace publico de storage para abrir los adjuntos enviados:

```bash
php artisan storage:link
```

Para iniciar el entorno de desarrollo:

```bash
php artisan serve
npm run dev
```

O usa el script integrado:

```bash
composer run dev
```

### Usuario de prueba

Al ejecutar los seeders, el proyecto crea un usuario por defecto:

```text
Email: admin@teste.com
Contrasena: password
```

### Autor

Desarrollado por **Matheus Marques**.

- GitHub: [github.com/CdeCinza](https://github.com/CdeCinza)
- LinkedIn: [Matheus Marques](https://www.linkedin.com/in/matheus-marques-fernandes-vieiracln/)

---

## License

This project is licensed under the MIT license.
