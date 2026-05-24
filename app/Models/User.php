<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'nama_lengkap',
        'email',
        'password',
        'role_id',
        'no_telepon',
        'alamat',
        'foto_profil',
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
     * Get the role of the user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Get the mahasiswa profile (if role is Mahasiswa).
     */
    public function mahasiswa(): HasOne
    {
        return $this->hasOne(Mahasiswa::class, 'user_id');
    }

    /**
     * Get the role name in lowercase.
     */
    public function getRoleName(): string
    {
        return strtolower($this->role->nama_role);
    }

    public function isAdmin(): bool
    {
        return $this->getRoleName() === 'admin';
    }

    public function isKeuangan(): bool
    {
        return $this->getRoleName() === 'keuangan';
    }

    public function isAkademik(): bool
    {
        return $this->getRoleName() === 'akademik';
    }

    public function isDirektur(): bool
    {
        return $this->getRoleName() === 'direktur';
    }

    public function isMahasiswa(): bool
    {
        return $this->getRoleName() === 'mahasiswa';
    }

    /**
     * Get the dashboard route for this user based on role.
     */
    public function getDashboardRoute(): string
    {
        return '/dashboard/' . $this->getRoleName();
    }
}
