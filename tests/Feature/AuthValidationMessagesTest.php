<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AuthValidationMessagesTest extends TestCase
{
    public function test_validation_messages_use_friendly_copy_instead_of_translation_keys(): void
    {
        $this->app->setLocale('pt_BR');

        $duplicateEmailMessage = trans('validation.custom.email.unique');

        $this->assertSame(
            'Este e-mail já está cadastrado. Tente entrar ou use outro e-mail.',
            $duplicateEmailMessage
        );
        $this->assertFalse(str_starts_with($duplicateEmailMessage, 'validation.'));

        $validator = Validator::make(['email' => null], ['email' => ['required']]);
        $validator->fails();

        $messages = $validator->errors()->all();

        $this->assertContains('O campo e-mail é obrigatório.', $messages);
        $this->assertFalse(collect($messages)->contains(
            fn (string $message) => str_starts_with($message, 'validation.')
        ));
    }
}
