<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('真实姓名');
            $table->string('username')->uniqnue()->comment('昵称');
            $table->string('email')->unique()->comment('邮箱');
            $table->string('phone')->nullable()->unique()->comment('手机');
            $table->string('password')->nullable()->comment('密码');
            $table->string('avatar')->nullable()->comment('头像');
            $table->string('realname')->nullable()->comment('真实姓名');

            // 拓展资料
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->string('bio')->nullable();
            $table->json('extends')->nullable();
            $table->json('settings')->nullable();

            // 状态
            $table->integer('level')->default(0);
            $table->boolean('is_admin')->default(false);

            // 数据缓存
            $table->json('cache')->nullable();

            // 账户
            $table->timestamp('last_active_at')->nullable();
            $table->timestamp('banned_at')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
