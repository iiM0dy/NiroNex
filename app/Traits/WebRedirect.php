<?php
/*
 * Assist Traits
 */

namespace App\Traits;

trait WebRedirect
{
    public static function assistWebRedirect(bool $success = true, ?string $message = null, ?string $route = null): \Illuminate\Http\RedirectResponse
    {
        if ($route != null) {
            return redirect()->route($route)->with(['success' => $success, 'message' => $message]);
        } else {
            return back()->with([
                'success' => $success,
                'message' => $message
            ]);
        }
    }


    public static function assistWebRedirectPath(bool $success = true, ?string $message = null, ?string $routePath = null, ?array $params = null): \Illuminate\Http\RedirectResponse
    {
        if ($routePath != null) {
            return redirect($routePath)->with(['success' => $success, 'message' => $message]);
        } else {
            return redirect()->back()->with(['success' => $success, 'message' => $message]);
        }
    }
}
