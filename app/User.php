<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    // use SoftDeletes;
    use HasApiTokens;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    protected $dates = [
        'deleted_at'
    ];

    protected $attributes = [
        'menuroles' => 'user',
    ];

    // public function messages()
    // {
    //     return $this->morphMany('App\Message', 'relatedModels');
    // }

    public function secrets()
    {
        return $this->hasMany('App\Secret');
    }
    
    public function generateAccountNumber()
    {
        // return 'ACC-' . date('Ymd') . str_pad($this->id, 4, "0", STR_PAD_LEFT);
        return date('Ymd') . str_pad($this->id, 4, "0", STR_PAD_LEFT);
    }

    public function bank()
    {
        return $this->hasOne('App\BankAccount');
    }

    public function requests()
    {
        return $this->morphMany('App\NumberChangeRequest', 'user');
    }

    public function logs()
    {
        return $this->morphMany('App\Log', 'user');
    }

    public function notifications()
    {
        return $this->morphMany('App\UserNotification', 'user');
    }
}
