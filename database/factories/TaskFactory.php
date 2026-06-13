<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tasks = [
            'Corrigir bug no botão de login' => 'O botão de login está inativo em dispositivos móveis e não responde ao toque.',
            'Ajustar espaçamento do menu' => 'Aumentar o padding lateral do menu lateral de navegação no layout desktop.',
            'Integrar gateway de pagamento' => 'Configurar o webhook e a rota de checkout para receber confirmações de pagamento.',
            'Refatorar models de autenticação' => 'Limpar o model User removendo métodos duplicados e organizando escopos.',
            'Escrever testes unitários' => 'Criar casos de teste para validar o comportamento de cálculo do carrinho de compras.',
            'Configurar deploy automático' => 'Criar o workflow do GitHub Actions para realizar o deploy automático na VPS.',
            'Otimizar consultas do banco' => 'Adicionar índices nas tabelas columns e tasks para melhorar a performance das buscas.',
            'Traduzir mensagens de erro' => 'Substituir os textos em inglês nas validações de formulário por mensagens em português.',
            'Criar documentação da API' => 'Escrever o arquivo OpenAPI/Swagger documentando as rotas da nova API externa.',
            'Ajustar cores do modo escuro' => 'Corrigir o contraste de cor do texto secundário nos cards do quadro kanban.',
            'Criar modal de configurações' => 'Permitir que o usuário edite o seu perfil e troque a imagem de avatar.',
            'Implementar sistema de busca' => 'Permitir busca textual reativa por títulos e descrições no painel principal.',
            'Adicionar prazos nas tarefas' => 'Criar campo de data limite e alertas visuais para tarefas com prazos vencidos.',
            'Exportar dados para planilha' => 'Adicionar botão de exportação para baixar o quadro de tarefas em formato CSV.',
            'Auditoria de atividades' => 'Salvar logs detalhados quando tarefas forem movidas, editadas ou concluídas.',
        ];

        $title = fake()->randomElement(array_keys($tasks));
        $description = $tasks[$title];

        return [
            'title' => $title,
            'description' => $description,
            // column_id e position controlados pelo Seeder
        ];
    }
}
