<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
//因Auth\User裡面其實有extends model, 所以這個檔案其實也有extends model, 只是還有多其他auth的功能
use Illuminate\Notifications\Notifiable;
use App\Notifications\AdminResetPasswordNotification;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // fillable(白名單)：只有陣列裡的欄位可以mass assignable, 陣列外的皆不行
        // guarded(黑名單)：只有陣列裡的欄位不可以被mass assignable, 陣列外的皆行
        'name', 'email', 'password', 'job_title'
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

    /*
    |----------------------------------------------------------------
    | Override Illuminate\Auth\Passwords\CanResetPassword function
    |----------------------------------------------------------------
    */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }

}
