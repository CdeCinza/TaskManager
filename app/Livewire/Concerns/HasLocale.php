<?php

namespace App\Livewire\Concerns;

trait HasLocale
{
    public $userBoards = [];

    public function mountHasLocale(): void
    {
        $this->userBoards = auth()->user() ? auth()->user()->boards : collect();
    }

    public function setLocale(string $locale)
    {
        $validLocales = ['en', 'pt_BR', 'es'];

        if (in_array($locale, $validLocales, true)) {
            session()->put('locale', $locale);
            app()->setLocale($locale);

            return $this->redirect(request()->header('Referer', url()->current()), navigate: true);
        }
    }
}
