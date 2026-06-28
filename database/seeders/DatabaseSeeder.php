<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Board;
use App\Models\Column;
use App\Models\Subtask;
use App\Models\Task;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Team Members
        $admin = User::factory()->create([
            'name' => 'Admin TaskManager',
            'email' => 'admin@teste.com',
            'password' => bcrypt('password'),
        ]);

        $juliana = User::factory()->create([
            'name' => 'Juliana Silva',
            'email' => 'juliana@teste.com',
            'password' => bcrypt('password'),
        ]);

        $carlos = User::factory()->create([
            'name' => 'Carlos Souza',
            'email' => 'carlos@teste.com',
            'password' => bcrypt('password'),
        ]);

        $mariana = User::factory()->create([
            'name' => 'Mariana Costa',
            'email' => 'mariana@teste.com',
            'password' => bcrypt('password'),
        ]);

        // 2. Create Board 1: Software Project
        $board1 = Board::create([
            'user_id' => $admin->id,
            'title' => '🚀 Desenvolvimento do App',
        ]);

        $col1Todo = Column::create(['board_id' => $board1->id, 'title' => 'A Fazer', 'position' => 0]);
        $col1Progress = Column::create(['board_id' => $board1->id, 'title' => 'Em Progresso', 'position' => 1]);
        $col1Review = Column::create(['board_id' => $board1->id, 'title' => 'Revisão', 'position' => 2]);
        $col1Done = Column::create(['board_id' => $board1->id, 'title' => 'Concluído', 'position' => 3]);

        // Tasks for Board 1
        $t1 = Task::create([
            'column_id' => $col1Todo->id,
            'title' => 'Configurar Servidor de Homologação',
            'description' => 'Configurar instância EC2 na AWS, instalar Nginx e configurar deploy automático com GitHub Actions.',
            'position' => 0,
            'priority' => 'high',
            'user_id' => $carlos->id,
            'due_date' => Carbon::tomorrow(),
        ]);
        Subtask::create(['task_id' => $t1->id, 'title' => 'Provisionar instância EC2', 'is_completed' => true]);
        Subtask::create(['task_id' => $t1->id, 'title' => 'Configurar Nginx e SSL', 'is_completed' => false]);
        Subtask::create(['task_id' => $t1->id, 'title' => 'Configurar Runner do GitHub', 'is_completed' => false]);

        $t2 = Task::create([
            'column_id' => $col1Todo->id,
            'title' => 'Refatorar Mapeamento de Rotas',
            'description' => 'Agrupar rotas duplicadas no arquivo web.php, extrair lógicas para controllers dedicados e aplicar middleware de throttling.',
            'position' => 1,
            'priority' => 'low',
            'user_id' => $admin->id,
            'due_date' => Carbon::now()->addDays(7),
        ]);

        $t3 = Task::create([
            'column_id' => $col1Progress->id,
            'title' => 'Implementar Checkout Stripe',
            'description' => 'Integrar a SDK oficial do Stripe, cadastrar webhooks no webhook dashboard e criar testes de pagamento simulado.',
            'position' => 0,
            'priority' => 'high',
            'user_id' => $admin->id,
            'due_date' => Carbon::today(),
        ]);
        Subtask::create(['task_id' => $t3->id, 'title' => 'Instalar SDK Stripe via Composer', 'is_completed' => true]);
        Subtask::create(['task_id' => $t3->id, 'title' => 'Criar endpoint de webhook', 'is_completed' => true]);
        Subtask::create(['task_id' => $t3->id, 'title' => 'Validar eventos de pagamento com Stripe CLI', 'is_completed' => false]);

        $t4 = Task::create([
            'column_id' => $col1Progress->id,
            'title' => 'Ajuste de Responsividade da Dashboard',
            'description' => 'Corrigir desalinhamento de grids e comportamento de tabelas em resoluções mobile e tablet.',
            'position' => 1,
            'priority' => 'medium',
            'user_id' => $juliana->id,
            'due_date' => Carbon::today(),
        ]);
        Subtask::create(['task_id' => $t4->id, 'title' => 'Revisar breakpoints do Tailwind', 'is_completed' => true]);
        Subtask::create(['task_id' => $t4->id, 'title' => 'Implementar menu mobile colapsável', 'is_completed' => false]);

        $t5 = Task::create([
            'column_id' => $col1Review->id,
            'title' => 'Bug no Upload de Anexos',
            'description' => 'O upload de múltiplos arquivos PDF falha intermitentemente devido ao tamanho máximo de requisição no PHP.',
            'position' => 0,
            'priority' => 'high',
            'user_id' => $mariana->id,
            'due_date' => Carbon::yesterday(),
        ]);
        Subtask::create(['task_id' => $t5->id, 'title' => 'Alterar upload_max_filesize no php.ini', 'is_completed' => true]);
        Subtask::create(['task_id' => $t5->id, 'title' => 'Adicionar tratamento de exceção no Livewire', 'is_completed' => true]);

        $t6 = Task::create([
            'column_id' => $col1Done->id,
            'title' => 'Setup Inicial do Framework e Git',
            'description' => 'Instalação inicial do Laravel, configuração do repositório no GitHub, commits iniciais e setup do Docker/Sail.',
            'position' => 0,
            'priority' => 'medium',
            'user_id' => $admin->id,
            'due_date' => Carbon::now()->subDays(5),
        ]);
        Subtask::create(['task_id' => $t6->id, 'title' => 'Instalação do Laravel', 'is_completed' => true]);
        Subtask::create(['task_id' => $t6->id, 'title' => 'Configuração do Docker', 'is_completed' => true]);

        // 3. Create Board 2: Marketing & Growth
        $board2 = Board::create([
            'user_id' => $admin->id,
            'title' => '📈 Marketing & Growth',
        ]);

        $col2Todo = Column::create(['board_id' => $board2->id, 'title' => 'A Fazer', 'position' => 0]);
        $col2Progress = Column::create(['board_id' => $board2->id, 'title' => 'Em Progresso', 'position' => 1]);
        $col2Review = Column::create(['board_id' => $board2->id, 'title' => 'Revisão', 'position' => 2]);
        $col2Done = Column::create(['board_id' => $board2->id, 'title' => 'Concluído', 'position' => 3]);

        // Tasks for Board 2
        Task::create([
            'column_id' => $col2Todo->id,
            'title' => 'SEO Checklist do Blog',
            'description' => 'Pesquisar palavras-chave com maior volume e aplicar tags meta nas publicações principais.',
            'position' => 0,
            'priority' => 'medium',
            'user_id' => $juliana->id,
            'due_date' => Carbon::now()->addDays(5),
        ]);

        Task::create([
            'column_id' => $col2Todo->id,
            'title' => 'Disparo de Newsletter Semanal',
            'description' => 'Redigir conteúdo de novidades da semana e agendar disparo no Mailchimp para sexta-feira.',
            'position' => 1,
            'priority' => 'low',
            'user_id' => $carlos->id,
            'due_date' => Carbon::tomorrow(),
        ]);

        Task::create([
            'column_id' => $col2Progress->id,
            'title' => 'Campanha Reels do Instagram',
            'description' => 'Gravar e editar 3 vídeos de demonstração rápida das novas features do App.',
            'position' => 0,
            'priority' => 'high',
            'user_id' => $mariana->id,
            'due_date' => Carbon::today(),
        ]);

        Task::create([
            'column_id' => $col2Done->id,
            'title' => 'Definição de Paleta de Cores da Marca',
            'description' => 'Definir paleta de cores primárias, secundárias e tipografias para o guia de estilo visual.',
            'position' => 0,
            'priority' => 'low',
            'user_id' => $admin->id,
            'due_date' => Carbon::now()->subDays(10),
        ]);

        // 4. Create Tickets
        $ticket1 = Ticket::create([
            'user_id' => $admin->id,
            'assignee_id' => $mariana->id,
            'board_id' => $board1->id,
            'title' => 'Instabilidade no formulário de contato',
            'description' => 'Alguns clientes estão relatando que o formulário de contato falha intermitentemente no carregamento.',
            'requester_name' => 'Roberto Almeida',
            'requester_email' => 'roberto@cliente.com',
            'origin' => 'portal',
            'status' => 'open',
            'priority' => 'high',
            'due_date' => Carbon::today(),
            'sla_due_at' => Carbon::now()->addHours(2),
        ]);
        $ticket1->checklistItems()->create(['title' => 'Triagem inicial', 'is_completed' => true, 'completed_at' => Carbon::now()->subHour(), 'completed_by' => $admin->id]);
        $ticket1->checklistItems()->create(['title' => 'Diagnóstico documentado', 'is_completed' => false]);
        $ticket1->checklistItems()->create(['title' => 'Solução validada com solicitante', 'is_completed' => false]);

        $ticket2 = Ticket::create([
            'user_id' => $admin->id,
            'assignee_id' => $admin->id,
            'board_id' => $board1->id,
            'title' => 'Erro 500 ao salvar anexo de chamado',
            'description' => 'Recebemos alertas de erro 500 na rota de upload de tickets. Ocorre apenas com PDFs maiores que 5MB.',
            'requester_name' => 'Ana Clara',
            'requester_email' => 'ana@cliente.com',
            'origin' => 'email',
            'status' => 'progress',
            'priority' => 'high',
            'due_date' => Carbon::today(),
            'sla_due_at' => Carbon::now()->subHour(), // Expired SLA!
        ]);
        $ticket2->checklistItems()->create(['title' => 'Triagem inicial', 'is_completed' => true, 'completed_at' => Carbon::now()->subHours(2), 'completed_by' => $admin->id]);
        $ticket2->checklistItems()->create(['title' => 'Diagnóstico documentado', 'is_completed' => true, 'completed_at' => Carbon::now()->subHour(), 'completed_by' => $admin->id]);
        $ticket2->checklistItems()->create(['title' => 'Solução validada com solicitante', 'is_completed' => false]);

        $ticket3 = Ticket::create([
            'user_id' => $admin->id,
            'assignee_id' => $carlos->id,
            'board_id' => $board2->id,
            'title' => 'Solicitação de exportação completa de dados',
            'description' => 'O cliente solicitou a exportação completa de seu histórico em formato CSV para fins de compliance.',
            'requester_name' => 'Felipe Guedes',
            'requester_email' => 'felipe@cliente.com',
            'origin' => 'whatsapp',
            'status' => 'waiting',
            'priority' => 'medium',
            'due_date' => Carbon::tomorrow(),
            'sla_due_at' => Carbon::tomorrow(),
        ]);
        $ticket3->checklistItems()->create(['title' => 'Triagem inicial', 'is_completed' => true, 'completed_at' => Carbon::now()->subHours(3), 'completed_by' => $admin->id]);
        $ticket3->checklistItems()->create(['title' => 'Diagnóstico documentado', 'is_completed' => false]);
        $ticket3->checklistItems()->create(['title' => 'Solução validada com solicitante', 'is_completed' => false]);

        $ticket4 = Ticket::create([
            'user_id' => $admin->id,
            'assignee_id' => $admin->id,
            'title' => 'Dúvida sobre planos de assinatura corporativa',
            'description' => 'Cliente gostaria de saber se há desconto para contratação anual corporativa de 10 licenças.',
            'requester_name' => 'Marcos Vinicius',
            'requester_email' => 'marcos@empresa.com',
            'origin' => 'phone',
            'status' => 'resolved',
            'priority' => 'low',
            'due_date' => Carbon::now()->subDays(3),
            'sla_due_at' => Carbon::now()->subDays(3),
            'resolved_at' => Carbon::now()->subDays(3),
        ]);
        $ticket4->checklistItems()->create(['title' => 'Triagem inicial', 'is_completed' => true, 'completed_at' => Carbon::now()->subDays(3), 'completed_by' => $admin->id]);
        $ticket4->checklistItems()->create(['title' => 'Diagnóstico documentado', 'is_completed' => true, 'completed_at' => Carbon::now()->subDays(3), 'completed_by' => $admin->id]);
        $ticket4->checklistItems()->create(['title' => 'Solução validada com solicitante', 'is_completed' => true, 'completed_at' => Carbon::now()->subDays(3), 'completed_by' => $admin->id]);

        // 5. Create Activities
        Activity::create([
            'task_id' => $t1->id,
            'user_id' => $admin->id,
            'description' => json_encode(['key' => 'activity_created']),
            'created_at' => Carbon::now()->subHours(5),
        ]);
        Activity::create([
            'task_id' => $t1->id,
            'user_id' => $admin->id,
            'description' => json_encode(['key' => 'activity_assigned', 'params' => ['new' => $carlos->name]]),
            'created_at' => Carbon::now()->subHours(4),
        ]);
        Activity::create([
            'task_id' => $t3->id,
            'user_id' => $admin->id,
            'description' => json_encode(['key' => 'activity_created']),
            'created_at' => Carbon::now()->subHours(3),
        ]);
        Activity::create([
            'task_id' => $t3->id,
            'user_id' => $admin->id,
            'description' => json_encode(['key' => 'activity_moved', 'params' => ['old' => 'A Fazer', 'new' => 'Em Progresso']]),
            'created_at' => Carbon::now()->subHours(2),
        ]);
        Activity::create([
            'task_id' => $t5->id,
            'user_id' => $admin->id,
            'description' => json_encode(['key' => 'activity_created']),
            'created_at' => Carbon::now()->subDays(2),
        ]);
        Activity::create([
            'task_id' => $t5->id,
            'user_id' => $admin->id,
            'description' => json_encode(['key' => 'activity_moved', 'params' => ['old' => 'Em Progresso', 'new' => 'Revisão']]),
            'created_at' => Carbon::now()->subHours(1),
        ]);
    }
}
