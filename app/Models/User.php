<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        "two_factor_type",
        "phone_number",
        "is_superuser",
        "is_staff",
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

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function hasTwoFactor($key)
    {
        return $this->two_factor_type == $key ? "selected" : "";
    }

    public function activeCodes()
    {
        return $this->hasMany(ActiveCode::class);
    }

    public function hasTwoFactorAuthenicatedEnabled()
    {
        return $this->two_factor_type !== "off";
    }

    public function hasSmsTwoFactorAuthenticationEnabled()
    {
        return $this->two_factor_type == "sms";
    }

    public function isSuperUser()
    {
        return $this->is_superuser;
    }

    public function isStaff()
    {
        return $this->is_staff;
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($roles)
    {
        return !!$roles->intersect($this->roles)->all();
    }

    public function hasPermission($permission)
    {
//        dd($this->permissions->contains("name", $permission->name) );
        return ($this->permissions->contains("name", $permission->name) || $this->hasRole($permission->roles));
//        return $this->permissions;
    }
}
