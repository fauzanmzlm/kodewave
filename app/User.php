<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public const ROLE_ADMIN = 1;
    public const ROLE_USER = 2;

    public const STATUS_COMPLETE = 1;
    public const STATUS_DRAFT = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Return list of status codes and labels

     * @return array
     */
    public static function roles()
    {
        return [
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_USER => 'User',
        ];
    }

    /**
     * Return list of status codes and labels

     * @return array
     */
    public static function statuses()
    {
        return [
            self::STATUS_COMPLETE => 'Completed',
            self::STATUS_DRAFT => 'Draft',
        ];
    }

    public function todo_lists()
    {
        return $this->hasMany(TodoList::class);
    }

    public function scopeTotalAdmin($query)
    {
        return $query->where('role', self::ROLE_ADMIN)->count();
    }

    public function scopeTotalUser($query)
    {
        return $query->where('role', self::ROLE_USER)->count();
    }
}
