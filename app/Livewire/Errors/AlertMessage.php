<?php

namespace App\Livewire\Errors;

use Livewire\Component;

class AlertMessage extends Component
{
    public $message;
    public $type;
    public $show = false;

    protected $listeners = ['showAlert'];

    public function showAlert($message, $type = 'success')
    {
        $this->message = $message;
        $this->type = $type;
        $this->show = true;

        // Esconde a mensagem após 3 segundos
        $this->dispatch('hideAlert', ['delay' => 3000]);
    }

    public function render()
    {
        return view('livewire.errors.alert-message');
    }
}
