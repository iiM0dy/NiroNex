<?php

namespace App\Jobs;

use App\Enums\MessageType;
use App\Enums\UserStatus;
use App\Models\Message;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class BroadcastMessageToPlanUsers implements ShouldQueue
{
    use Queueable;

    protected array $planIds;
    protected string $title;
    protected string $body;
    protected int $senderId;

    public function __construct(array $planIds, string $title, string $body, int $senderId = 1)
    {
        $this->planIds = $planIds;
        $this->title = $title;
        $this->body = $body;
        $this->senderId = $senderId;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::realUsers()
            ->whereIn('plan_id', $this->planIds)
            ->where('status', UserStatus::Active)
            ->get();

        $now = now();
        $messages = [];

        foreach ($users as $user) {
            $messages[] = [
                'sender_id' => $this->senderId,
                'receiver_id' => $user->id,
                'type' => MessageType::multi,
                'title' => $this->title,
                'body' => $this->body,
                'is_read' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            // SendRecommendationEmail::dispatch($user, $this->title, $this->body);
        }
        Message::insert($messages);
    }
}
