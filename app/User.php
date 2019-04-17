<?php

namespace App;

use App\Exceptions\UserException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    /**
     * 敏感字段
     */
    const UPDATE_SENSITIVE_FIELDS = [
        'last_active_at', 'banned_at',
    ];

    /**
     * 可以被批量赋值的属性。
     * create 方法来保存新模型
     * 需要先在模型上指定 fillable 或 guarded
     * 因为所有的 Eloquent 模型在默认情况下都不能进行批量赋值
     * 时间会自动添加
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'energy', 'email', 'password', 'avatar', 'realname', 'phone',
        'bio', 'extends', 'settings', 'cache', 'gender',
        'last_active_at', 'banned_at', 'activated_at',
    ];


    /**
     * 当模型第一次被保存时， creating 和 created 事件会被触发。
     * 若数据库中已存在此模型，并调用 save 方法，updating / updated 事件会被触发。
     * 这两种情况下，saving / saved 事件都会被触发。
     */
    public static function boot()
    {
        parent::boot();

        // 用户创建时
        static::creating(function ($user) {
            $user->name = $user->name ?? $user->username;

            if (self::isUsernameExists($user->username)) {
                throw new UserException(['httpCode' => 400,
                    'msg' => '用户名已经存在', 'errorCode' => 2001]);
            }
            if (self::isEmailExists($user->email)) {
                throw new UserException(['httpCode' => 400,
                    'msg' => '用户邮箱已经存在', 'errorCode' => 2002]);
            }

        });

        static::saving(function ($user) {
            if (Hash::needsRehash($user->password)) {
                $user->password = bcrypt($user->password);
            }

            // 有些数据库字段的值不应该让用户直接传递(禁言时间,积分等)
            // 可以使用guarded属性,后期考虑增加到里面
            if (array_has($user->getDirty(), self::UPDATE_SENSITIVE_FIELDS)) {
                throw new UserException(['httpCode' => 400,
                    'msg' => '非法请求', 'errorCode' => 2003]);
            }
            // 如果被修改的字段有时间,那么就添加上
            foreach ($user->getDirty() as $field => $value) {
                if (\ends_with($field, '_at')) {
                    $user->$field = $value ? now() : null;
                }
            }
        });
    }


    /**
     * 检测用户名是否被占用
     * @param string $username
     * @return mixed
     */
    public static function isUsernameExists(string $username)
    {
        return self::whereRaw(\sprintf('lower(username) = "%s" ',
            \strtolower($username)))->exists();
    }

    /**
     * 检测邮箱是否被占用
     * @param string $email
     * @return mixed
     */
    public static function isEmailExists(string $email)
    {
        return self::where('email', '=', $email)->exists();
    }
}
