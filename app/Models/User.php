<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'nama', 'email', 'password', 'google_id', 'foto_profil', 'no_hp', 'status_akun',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id')
            ->withPivot('tanggal_aktif');
    }

    public function hasRole(string $role): bool
    {
        return $this->roles()->where('nama_role', $role)->exists();
    }

    public function getPrimaryRole(): ?string
    {
        return $this->roles()->orderBy('role_id')->value('nama_role');
    }

    protected function casts(): array
    {
        return ['password' => 'hashed'];
    }
}
