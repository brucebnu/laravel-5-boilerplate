<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider.
 * Laravel的Event事件系统提供了一个简单的观察者模式实现，能够订阅和监听应用中发生的各种事件.
 * 在PHP的标准库(SPL)里甚至提供了三个接口SplSubject, SplObserver, SplObjectStorage
 * 来让开发者更容易地实现观察者模式
 *
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     * 包含所有的事件（键）以及事件对应的监听器（值）来注册所有的事件监听器，
     * 可以灵活地根据需求来添加事件。
     *
     * php artisan event:generate #查看所有监听事件
     *
     * @var array
     */
    protected $listen = [
        //
    ];

    /**
     * Class event subscribers.
     *
     * @var array
     */
    protected $subscribe = [
        /*
         * Frontend Subscribers
         */

        /*
         * Auth Subscribers
         */
        \App\Listeners\Frontend\Auth\UserEventListener::class,

        /*
         * Backend Subscribers
         */

        /*
         * Auth Subscribers
         */
        \App\Listeners\Backend\Auth\User\UserEventListener::class,
        \App\Listeners\Backend\Auth\Role\RoleEventListener::class,
    ];

    /**
     * Register any events for your application.
     *
     * 手动在boot方法中注册基于事件的闭包。
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
