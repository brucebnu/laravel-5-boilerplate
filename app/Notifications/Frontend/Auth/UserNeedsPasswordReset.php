<?php

namespace App\Notifications\Frontend\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Class UserNeedsPasswordReset.
 * 支持通过多种频道发送通知，包括邮件、短信（通过 Nexmo）以及 Slack 。
 * 通知还能存到数据库，这样就能在网页界面上显示了。
 * php artisan make:notification InvoicePaid # 创建通知
 * 通知可以通过两种方法发送： Notifiable trait 的 notify 方法或 Notification facade
 * 使用 Notification Facade，主要用在当你给多个可接收通知的实体发送通知的时候，比如给用户集合发通知。
 *
 */
class UserNeedsPasswordReset extends Notification
{
    /**
     * 队列化通知
     * 发送通知可能会花很长时间，尤其是发送频道需要调用外部 API 的时候。
     * 要加速应用响应的话，可以通过添加 ShouldQueue 接口和 Queueable trait 把通知加入队列。
     */

    use Queueable;
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * UserNeedsPasswordReset constructor.
     *
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     * 指定发送频道
     * 开箱即用的通知频道有 mail, database, broadcast, nexmo, 和 slack 。
     *
     * @param mixed $notifiable
     *
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject(app_name().': '.__('strings.emails.auth.password_reset_subject'))
            ->line(__('strings.emails.auth.password_cause_of_email'))
            ->action(__('buttons.emails.auth.reset_password'), route('frontend.auth.password.reset.form', $this->token))
            ->line(__('strings.emails.auth.password_if_not_requested'));
    }
}
