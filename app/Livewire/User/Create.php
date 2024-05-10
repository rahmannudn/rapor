<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class Create extends Component
{
    public $name;
    public $password;
    public $email;
    public $role;
    public $jk;
    public $jenis_pegawai;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.user.create');
    }

    public function save()
    {
        $validated =  $this->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', Rules\Password::defaults()],
            'role' => ['required'],
            'jk' => ['required'],
            'jenis_pegawai' => ['required'],
        ]);
        $validated['password'] = Hash::make($validated['password']);

        User::create(
            $validated
        );

        session()->flash('success', 'Data Berhasil Ditambahkan');
        $this->redirectRoute('userIndex');
    }
}
