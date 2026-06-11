<?php

namespace Database\Seeders;

use App\Models\User;
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
        // User::factory(10)->create();

        // 1. Cria o SEU usuário de teste
        $user = User::factory()->create([
            'name' => 'Admin TaskManager',
            'email' => 'admin@teste.com',
            'password' => bcrypt('password'), // A senha será 'password'
        ]);

        // 2. Cria 2 quadros para este usuário
        \App\Models\Board::factory(2)->for($user)->create()->each(function ($board) {
            
            // 3. Define as colunas iniciais de cada quadro
            $titulosColunas = ['A Fazer', 'Em Progresso', 'Revisão', 'Concluído'];
            
            foreach ($titulosColunas as $index => $titulo) {
                $column = \App\Models\Column::create([
                    'board_id' => $board->id,
                    'title' => $titulo,
                    'position' => $index, // 0, 1, 2, 3...
                ]);

                // 4. Cria de 2 a 5 tarefas aleatórias dentro de cada coluna
                $quantidadeTarefas = rand(2, 5);
                for ($i = 0; $i < $quantidadeTarefas; $i++) {
                    \App\Models\Task::factory()->create([
                        'column_id' => $column->id,
                        'position' => $i, // Mantém a ordem sequencial das tasks
                    ]);
                }
            }
        });
    }
}
