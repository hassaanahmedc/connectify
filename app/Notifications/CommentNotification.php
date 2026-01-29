<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentNotification extends Notification
{
    use Queueable;

    public User $commentor;
    public Post $post;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $commentor, Post $post)
    {
        $this->commentor = $commentor;
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'post_id' => $this->post->id,
            'user_id' => $this->commentor->id,
            'user_name' => $this->commentor->fname . ' ' . $this->commentor->lname,
            'message' => 'commented on your post.',
            'user_avatar' => $this->commentor->avatar,
            'link' => route('post.view', $this->post->id)
        ];
    }
}
