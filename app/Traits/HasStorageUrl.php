<?php

namespace App\Traits;

trait HasStorageUrl
{
    public function getStorageUrl($attribute)
    {
        if (!$attribute)
            return null;

        $path = ltrim($attribute, '/');

        if (
            str_starts_with($path, 'identity_documents/')
            || str_starts_with($path, 'selfies/')
            || str_starts_with($path, 'payment_proofs/')
        ) {
            return route('admin.files.show', ['path' => $path]);
        }

        if (str_starts_with($attribute, 'storage/')) {
            return asset($attribute);
        }

        return asset('storage/' . $path);
    }
}
