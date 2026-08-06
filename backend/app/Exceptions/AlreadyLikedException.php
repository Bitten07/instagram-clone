<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class AlreadyLikedException extends Exception
{
    public function render(Request $request)
    {
        return response()->json(["message" => "You are already liked this post."], 409);
    }
}
