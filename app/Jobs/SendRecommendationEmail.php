<?php

namespace App\Jobs;

use App\Mail\RecommendationMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Mail;

class SendRecommendationEmail implements ShouldQueue
{
    use Queueable;

    public User $user;
    public string $title;
    public string $body;

    public function __construct(User $user, string $title, string $body)
    {
        $this->user = $user;
        $this->title = $title;
        $this->body = $body;
    }

    public function handle(): void
    {
        Mail::to($this->user->email)->send(new RecommendationMail($this->user, $this->title, $this->body));
    }
}
