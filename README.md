# Taskly - Task Management, Kanban and Agenda

Taskly is a personal portfolio project created by **Matheus Marques Fernandes Vieira**.  
It is a task management web application focused on Kanban organization, analytical dashboards, weekly planning and calendar-based due dates.

[GitHub](https://github.com/CdeCinza) · [LinkedIn](https://www.linkedin.com/in/matheus-marques-fernandes-vieiracln/)

---

## Portugues

### Sobre o projeto

O **Taskly** e um gerenciador de tarefas desenvolvido como projeto de portfolio, com foco em demonstrar dominio de Laravel, Livewire, interfaces reativas, organizacao de dados e experiencia de usuario.

A proposta do projeto e simular uma ferramenta moderna de produtividade, combinando:

- Quadro Kanban com drag and drop.
- Dashboard com indicadores, atividades e dados acionaveis.
- Agenda/calendario para acompanhar prazos.
- Fluxo de autenticacao.
- Organizacao por quadros, colunas, tarefas, prioridades, responsaveis e subtarefas.

O objetivo e apresentar um projeto completo, visualmente bem acabado e com funcionalidades proximas de um produto real.

### Funcionalidades

- Autenticacao de usuarios.
- Dashboard com KPIs de quadros, tarefas, conclusoes, atrasos, prioridades e membros.
- Dashboard acionavel com:
  - Minha Semana.
  - Tarefas de hoje.
  - Tarefas de amanha.
  - Tarefas da semana.
  - Tarefas atrasadas.
  - Tarefas sem responsavel.
  - Boards com mais risco.
  - Atividades relevantes.
- Quadro Kanban com colunas e cards.
- Drag and drop de tarefas com persistencia no banco.
- Criacao, edicao, exclusao e restauracao de tarefas.
- Lixeira com soft delete.
- Modal detalhado de tarefa.
- Prioridades: baixa, media e alta.
- Responsavel por tarefa.
- Subtarefas com progresso.
- Data de vencimento.
- Agenda em `/calendar`.
- Visualizacao mensal, semanal e em lista.
- Filtros por prioridade e quadro.
- Interface dark responsiva.
- Identidade visual propria com logo e favicon.
- Suporte visual a PT, EN e ES.

### Stack

- **Backend:** PHP 8.3, Laravel 13, Eloquent ORM.
- **Frontend:** Livewire 4, Alpine.js, Tailwind CSS 4, Vite.
- **UI/UX:** Lucide Icons, SweetAlert2, SortableJS, Chart.js.
- **Banco de dados:** SQLite por padrao, podendo ser adaptado para MySQL/PostgreSQL.

### Como executar localmente

#### Pre-requisitos

- PHP 8.3+
- Composer
- Node.js e NPM
- SQLite ou outro banco configurado no `.env`

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

Desenvolvido por **Matheus Marques Fernandes Vieira**.

- GitHub: [github.com/CdeCinza](https://github.com/CdeCinza)
- LinkedIn: [matheus-marques-fernandes-vieiracln](https://www.linkedin.com/in/matheus-marques-fernandes-vieiracln/)

---

## English

### About the project

**Taskly** is a task management application built as a portfolio project by **Matheus Marques Fernandes Vieira**.  
It was designed to demonstrate practical experience with Laravel, Livewire, reactive interfaces, relational data modeling and product-oriented UI design.

The project simulates a modern productivity tool by combining:

- Kanban boards with drag and drop.
- Analytical and actionable dashboard.
- Calendar and agenda for task deadlines.
- Authentication flow.
- Boards, columns, tasks, priorities, assignees and subtasks.

The goal is to present a complete, polished and realistic web application.

### Features

- User authentication.
- Dashboard with KPIs for boards, tasks, completion, overdue tasks, priorities and members.
- Actionable dashboard with:
  - My Week.
  - Today's tasks.
  - Tomorrow's tasks.
  - This week's tasks.
  - Overdue tasks.
  - Unassigned tasks.
  - Boards with higher risk.
  - Relevant activity feed.
- Kanban board with columns and cards.
- Drag and drop task movement with database persistence.
- Create, edit, delete and restore tasks.
- Trash with soft delete.
- Detailed task modal.
- Priorities: low, medium and high.
- Task assignee.
- Subtasks with progress tracking.
- Due dates.
- Calendar page at `/calendar`.
- Monthly, weekly and list views.
- Filters by priority and board.
- Responsive dark interface.
- Custom visual identity with logo and favicon.
- Visual support for Portuguese, English and Spanish.

### Tech stack

- **Backend:** PHP 8.3, Laravel 13, Eloquent ORM.
- **Frontend:** Livewire 4, Alpine.js, Tailwind CSS 4, Vite.
- **UI/UX:** Lucide Icons, SweetAlert2, SortableJS, Chart.js.
- **Database:** SQLite by default, adaptable to MySQL/PostgreSQL.

### Running locally

#### Requirements

- PHP 8.3+
- Composer
- Node.js and NPM
- SQLite or another database configured in `.env`

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

Developed by **Matheus Marques Fernandes Vieira**.

- GitHub: [github.com/CdeCinza](https://github.com/CdeCinza)
- LinkedIn: [matheus-marques-fernandes-vieiracln](https://www.linkedin.com/in/matheus-marques-fernandes-vieiracln/)

---

## Espanol

### Sobre el proyecto

**Taskly** es una aplicacion de gestion de tareas creada como proyecto de portafolio por **Matheus Marques Fernandes Vieira**.  
Fue desarrollada para demostrar experiencia practica con Laravel, Livewire, interfaces reactivas, modelado de datos relacionales y diseno de interfaces orientadas a producto.

La propuesta del proyecto es simular una herramienta moderna de productividad, combinando:

- Tablero Kanban con drag and drop.
- Dashboard analitico y accionable.
- Agenda/calendario para fechas de vencimiento.
- Flujo de autenticacion.
- Tableros, columnas, tareas, prioridades, responsables y subtareas.

El objetivo es presentar una aplicacion completa, pulida y cercana a un producto real.

### Funcionalidades

- Autenticacion de usuarios.
- Dashboard con KPIs de tableros, tareas, finalizaciones, atrasos, prioridades y miembros.
- Dashboard accionable con:
  - Mi Semana.
  - Tareas de hoy.
  - Tareas de manana.
  - Tareas de esta semana.
  - Tareas atrasadas.
  - Tareas sin responsable.
  - Tableros con mayor riesgo.
  - Actividades relevantes.
- Tablero Kanban con columnas y tarjetas.
- Movimiento de tareas con drag and drop y persistencia en base de datos.
- Crear, editar, eliminar y restaurar tareas.
- Papelera con soft delete.
- Modal detallado de tarea.
- Prioridades: baja, media y alta.
- Responsable por tarea.
- Subtareas con seguimiento de progreso.
- Fechas de vencimiento.
- Pagina de agenda en `/calendar`.
- Vistas mensual, semanal y de lista.
- Filtros por prioridad y tablero.
- Interfaz dark responsiva.
- Identidad visual propia con logo y favicon.
- Soporte visual para portugues, ingles y espanol.

### Stack tecnologico

- **Backend:** PHP 8.3, Laravel 13, Eloquent ORM.
- **Frontend:** Livewire 4, Alpine.js, Tailwind CSS 4, Vite.
- **UI/UX:** Lucide Icons, SweetAlert2, SortableJS, Chart.js.
- **Base de datos:** SQLite por defecto, adaptable a MySQL/PostgreSQL.

### Como ejecutar localmente

#### Requisitos

- PHP 8.3+
- Composer
- Node.js y NPM
- SQLite u otra base de datos configurada en `.env`

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

Desarrollado por **Matheus Marques Fernandes Vieira**.

- GitHub: [github.com/CdeCinza](https://github.com/CdeCinza)
- LinkedIn: [matheus-marques-fernandes-vieiracln](https://www.linkedin.com/in/matheus-marques-fernandes-vieiracln/)

---

## License

This project is licensed under the MIT license.
