<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class Edit extends Component
{
    public User $user;

    public $name;
    public $email;
    public $password;
    public $role;
    public $jk;
    public $jenis_pegawai;

    public function mount()
    {
        $this->name = $this->user['name'];
        $this->email = $this->user['email'];
        $this->password = '';
        $this->role = $this->user['role'];
        $this->jk = $this->user['jk'];
        $this->jenis_pegawai = $this->user['jenis_pegawai'];
    }

    public function render()
    {
        return view('livewire.user.edit');
    }

    public function update(User $user)
    {
        $validated =  $this->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'role' => ['required'],
            'jk' => ['required'],
            'jenis_pegawai' => ['required'],
        ]);

        // mengecek apakah ada perubahan password
        if ($this->password !== '') {
            $validated += $this->validate([
                'password' => ['required', 'string', Rules\Password::defaults()],
            ]);
            $validated['password'] = Hash::make($validated['password']);
        }
        // membandingkan inputan email dengan data email yg sdh ada
        if ($this->email !== $user->email) {
            $validated += $this->validate(['email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],]);
        }

        $user->update($validated);

        if ($user['email'] == Auth::user()->email) {
            session()->put('nama_user', $user['name']);
            session()->put('email_user', $user['email']);
        }

        session()->flash('success', 'Data Berhasil Diubah');
        $this->redirectRoute('userIndex');
    }
}
