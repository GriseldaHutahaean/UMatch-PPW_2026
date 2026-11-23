<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'nama', 'email', 'password', 'google_id', 'foto_profil', 'no_hp', 'status_akun', 'username_admin',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id')
            ->withPivot('tanggal_aktif');
    }

    public function customerProfile(): HasOne
    {
        return $this->hasOne(CustomerProfile::class, 'user_id', 'user_id');
    }

    public function umkmProfile(): HasOne
    {
        return $this->hasOne(UmkmProfile::class, 'user_id', 'user_id');
    }

    public function investorProfile(): HasOne
    {
        return $this->hasOne(InvestorProfile::class, 'user_id', 'user_id');
    }

    public function hasRole(string $role): bool
    {
        return $this->roles()->where('nama_role', $role)->exists();
    }

    public function getPrimaryRole(): ?string
    {
        return $this->roles()->orderBy('roles.role_id')->value('nama_role');
    }

    /**
     * Return the administrator's display name derived from their username_admin.
     * Falls back to the user's nama field if no username_admin is set.
     */
    public function getAdminDisplayName(): string
    {
        if ($this->username_admin !== null) {
            return ucfirst($this->username_admin);
        }

        return $this->nama;
    }

    protected function casts(): array
    {
        return ['password' => 'hashed'];
    }
}
