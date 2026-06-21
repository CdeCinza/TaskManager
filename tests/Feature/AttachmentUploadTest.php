<?php

namespace Tests\Feature;

use App\Livewire\ShowBoard;
use App\Livewire\Tickets;
use App\Models\Board;
use App\Models\Column;
use App\Models\Task;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AttachmentUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_attachments_to_task(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $board = Board::create(['title' => 'Project Board', 'user_id' => $user->id]);
        $column = Column::create(['title' => 'To Do', 'board_id' => $board->id, 'position' => 0]);
        $task = Task::create(['title' => 'Task with attachment', 'column_id' => $column->id]);

        $this->actingAs($user);

        $file = UploadedFile::fake()->image('screenshot.png');

        Livewire::test(ShowBoard::class, ['board' => $board])
            ->call('openTaskModal', $task->id)
            ->set('newAttachments', [$file])
            ->call('uploadAttachments')
            ->assertCount('selectedTask.attachments', 1);

        $attachment = $task->attachments()->first();
        $this->assertNotNull($attachment);
        $this->assertEquals('screenshot.png', $attachment->name);
        Storage::disk('public')->assertExists($attachment->path);
    }

    public function test_user_can_delete_attachments_from_task(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $board = Board::create(['title' => 'Project Board', 'user_id' => $user->id]);
        $column = Column::create(['title' => 'To Do', 'board_id' => $board->id, 'position' => 0]);
        $task = Task::create(['title' => 'Task with attachment', 'column_id' => $column->id]);

        $this->actingAs($user);

        $file = UploadedFile::fake()->image('screenshot.png');

        Livewire::test(ShowBoard::class, ['board' => $board])
            ->call('openTaskModal', $task->id)
            ->set('newAttachments', [$file])
            ->call('uploadAttachments');

        $attachment = $task->attachments()->first();
        Storage::disk('public')->assertExists($attachment->path);

        Livewire::test(ShowBoard::class, ['board' => $board])
            ->call('openTaskModal', $task->id)
            ->call('deleteAttachment', $attachment->id)
            ->assertCount('selectedTask.attachments', 0);

        $this->assertEquals(0, $task->attachments()->count());
        Storage::disk('public')->assertMissing($attachment->path);
    }

    public function test_user_can_upload_pdf_attachment_to_ticket(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $ticket = Ticket::create([
            'title' => 'Ticket with PDF',
            'user_id' => $user->id,
            'origin' => 'portal',
            'status' => 'open',
            'priority' => 'medium',
        ]);

        $this->actingAs($user);

        $file = UploadedFile::fake()->create('documento.pdf', 100, 'application/pdf');

        Livewire::test(Tickets::class)
            ->call('openTicket', $ticket->id)
            ->set('newAttachments', [$file])
            ->call('uploadAttachments')
            ->assertCount('selectedTicket.attachments', 1);

        $attachment = $ticket->attachments()->first();
        $this->assertNotNull($attachment);
        $this->assertEquals('documento.pdf', $attachment->name);
        $this->assertEquals('application/pdf', $attachment->mime_type);
        Storage::disk('public')->assertExists($attachment->path);
    }
}
