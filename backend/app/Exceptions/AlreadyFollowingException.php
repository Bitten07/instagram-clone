<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class AlreadyFollowingException extends Exception
{
    public function render(Request $request)
    {
        return response()->json(["message" => "You already following this user."], 409);
    }
}
