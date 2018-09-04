<?php

namespace App\Observers\User;

use App\Models\Auth\User;

/**
 * Class UserObserver.
 * 模型时间观察器
 *
 * https://laravel-china.org/docs/laravel/5.5/eloquent/1332#observers
 *
 * 如果要给某个模型监听很多事件，则可以使用观察器将所有监听器分组到一个类中。
 * 观察器类里的方法名应该对应 Eloquent 中你想监听的事件。
 * 每种方法接收 model 作为其唯一的参数。
 * Laravel 没有为观察器设置默认的目录，所以你可以创建任何你喜欢你的目录来存放
 *
 */
class UserObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  \App\Models\Auth\User  $user
     * @return void
     */
    public function created(User $user) : void
    {
        $this->logPasswordHistory($user);
    }

    /**
     * Listen to the User updated event.
     *
     * @param  \App\Models\Auth\User  $user
     * @return void
     */
    public function updated(User $user) : void
    {
        // Only log password history on update if the password actually changed
        if ($user->isDirty('password')) {
            $this->logPasswordHistory($user);
        }
    }

    /**
     * @param User $user
     */
    private function logPasswordHistory(User $user) : void
    {
        if (config('access.users.password_history')) {
            $user->passwordHistories()->create([
                'password' => $user->password, // Password already hashed & saved so just take from model
            ]);
        }
    }
}
