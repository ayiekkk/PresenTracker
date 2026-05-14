<?php

namespace App\Policies;

use App\Models\Kelas;
use App\Models\User;

class KelasPolicy
{
    public function view(User $user, Kelas $kelas): bool
    {
        return $kelas->admin_id === $user->id;
    }

    public function update(User $user, Kelas $kelas): bool
    {
        return $kelas->admin_id === $user->id;
    }

    public function delete(User $user, Kelas $kelas): bool
    {
        return $kelas->admin_id === $user->id;
    }
}