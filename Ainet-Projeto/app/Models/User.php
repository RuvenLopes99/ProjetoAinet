<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'blocked',
        'gender',
        'photo',
        'nif',
        'default_delivery_address',
        'default_payment_type',
        'default_payment_reference',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function firstLastInitial(): string
    {
        $allNames = Str::of($this->name)
            ->explode(' ');
        $firstName = $allNames->first();
        $lastName = $allNames->count() > 1 ? $allNames->last() : '';
        return Str::of($firstName)->substr(0, 1)
            ->append(' ')
            ->append(Str::of($lastName)->substr(0, 1));
    }

    public function firstLastName(): string
    {
        $allNames = Str::of($this->name)
            ->explode(' ');
        $firstName = $allNames->first();
        $lastName = $allNames->count() > 1 ? $allNames->last() : '';
        return Str::of($firstName)
            ->append(' ')
            ->append(Str::of($lastName));
    }

}
