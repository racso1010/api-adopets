<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'profile_photo',
        'role',
        'email',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function pets()
    {
        return $this->hasMany(Pets::class);
    }

    // Check if user is admin
    public static function isAdmin(int $userId)
    {
        return  self::where([
            ['id', $userId],
            ['role', 'admin']
        ])->withTrashed()->exists();
    }

    // Check if user is staff
    public static function isStaff(int $userId)
    {
        return  self::where([
            ['id', $userId],
            ['role', 'staff']
        ])->withTrashed()->exists();
    }

    // Check if user is member
    public static function isMember(int $userId)
    {
        return  self::where([
            ['id', $userId],
            ['role', 'member']
        ])->withTrashed()->exists();
    }
}