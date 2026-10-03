<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use App\Traits\WebRedirect;

abstract class Controller
{
    use WebRedirect, ApiResponse;
}
