<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// Tambahkan import untuk Relasi
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
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
        'employee_id',
        'username',
        'password',
        'phone',
        'address',
        'role',
        'status',
        'sim_number',
        'sim_class',
        'sim_issued_at',
        'sim_expires_at',
        'photo_path',
        'sim_photo_path',
        'joined_at',
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
            'sim_issued_at' => 'date',
            'sim_expires_at' => 'date',
            'joined_at' => 'date',
            'password' => 'hashed',
            // Hapus 'email_verified_at' jika kolom tersebut tidak ada di $fillable atau tabel Anda
        ];
    }

    /**
     * Relasi ke kendaraan (many-to-many)
     */
    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class, 'driver_vehicle');
    }

    /**
     * Relasi ke check sheet
     */
    public function checkSheets(): HasMany
    {
        return $this->hasMany(CheckSheet::class);
    }
}