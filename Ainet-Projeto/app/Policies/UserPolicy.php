<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny($user)
    {
        return $user->type === 'admin';
    }

    public function view($user, $model)
    {
        return $user->type === 'admin' || $user->id === $model->id;
    }

    public function create($user)
    {
        return $user->type === 'admin';
    }

    public function update($user, $model)
    {
        return $user->type === 'admin' || $user->id === $model->id;
    }

    public function delete($user, $model)
    {
        return $user->type === 'admin' && $user->id !== $model->id;
    }
}
