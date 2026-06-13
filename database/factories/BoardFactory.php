<?php

namespace Database\Factories;

use App\Models\Board;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Board>
 */
class BoardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $projects = [
            'Website Institucional',
            'Aplicativo Mobile de Vendas',
            'Painel Administrativo',
            'Redesign da Landing Page',
            'Plataforma E-commerce',
            'Portal de Clientes',
            'Sistema de Agendamentos',
            'API de Integração de Pagamento',
        ];

        return [
            'title' => fake()->unique()->randomElement($projects),
        ];
    }
}
