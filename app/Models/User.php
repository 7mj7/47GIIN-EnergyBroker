<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Panel;


class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;
    use Notifiable; // para notificaciones

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',    // Usuario Activado/Desactivado
        'phone1',       // Telefono Principal
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
            'is_active' => 'boolean', // Usuario Activado/Desactivado
        ];
    }

    protected static function booted()
    {
        static::updating(function ($user) {
            if ($user->id === 1 && $user->isDirty('is_active') && $user->is_active === false) {
                $user->is_active = true; // Revertir el cambio
                //throw new \Exception('No puedes desactivar al usuario administrador principal.');
                // Opcional: Registrar un log o tomar otra acción silenciosa
            }
        });
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;//str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
    }
}
