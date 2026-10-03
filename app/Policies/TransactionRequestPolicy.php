<?php

namespace App\Policies;

use App\Enums\TransactionStatus;
use App\Models\TransactionRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TransactionRequestPolicy
{
    public function view(User $user, TransactionRequest $request): bool
    {
        return $user->id === $request->user_id;
    }

    public function delete(User $user, TransactionRequest $request): bool
    {
        return $user->id === $request->user_id && $request->status == TransactionStatus::Pending;
    }
}
