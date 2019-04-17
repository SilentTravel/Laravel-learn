<?php

namespace App\Providers;

use App\Validators\KeepWordValidator;
use App\Validators\PasswordValidator;
use App\Validators\UsernameValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * 自定义验证类
     *
     * @var array
     */
    protected $validators = [
        'username'  => UsernameValidator::class , // 用户名正则验证
        'keep_word' => KeepWordValidator::class, // 系统关键字过滤
        'password'  => PasswordValidator::class,  //密码正则验证
    ];

    /**
     * 验证规则
     */
    protected function registerValidators()
    {
        foreach ($this->validators as $rule => $validator) {
            Validator::extend($rule, "{$validator}@validate");
        }
    }

    /**
     * 引导任何应用程序。
     *
     * @return void
     */
    public function boot()
    {
        $this->registerValidators();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }


}
