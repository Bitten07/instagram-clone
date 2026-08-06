<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class FollowYourselfException extends Exception
{
    public function render(Request $request)
    {
        return response()->json(["message" => "You cannot follow yourself."], 422);
    }
}
