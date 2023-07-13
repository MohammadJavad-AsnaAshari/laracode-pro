<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveCode extends Model
{
    use HasFactory;

//    protected $table = "active_code";

    public $timestamps = false;
    protected $fillable = [
        "user_id", "code", "expired_at"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeGenerateCode($query, $user)
    {
//        if ($code = $this->getAliveCodeForUser($user)) {
//            $code = $code->code;
//        } else {
//            do {
//                $code = mt_rand(100000, 999999);
//            } while ($this->checkCodeIsUnique($user, $code));
//            $user->activeCodes()->create([
//                "code" => $code,
//                "expired_at" => now()->addMinute(10)
//            ]);
//        }
        $user->activeCodes()->delete();

        do {
            $code = mt_rand(100000, 999999);
        } while ($this->checkCodeIsUnique($user, $code));
        $user->activeCodes()->create([
            "code" => $code,
            "expired_at" => now()->addMinute(10)
        ]);

        return $code;
    }

    private function checkCodeIsUnique($user, int $code)
    {
//        return !! $user->activeCodes()->where("code", $code)->first();
        return !!$user->activeCodes()->whereCode($code)->first();
    }

    private function getAliveCodeForUser($user)
    {
        return $user->activeCodes()->where("expired_at", ">", now())->first();
    }

    public function scopeVerifyCode($query, $code, $user)
    {
        return !! $user->activeCodes()->whereCode($code)->where("expired_at", ">", now())->first();
    }
}
