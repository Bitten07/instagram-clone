<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $term = $request->input('q');

        if ($request->filled('q')){
            $response = User::where('name', 'like', "%{$term}%")->orWhere('username', 'like', "%{$term}%")->paginate(10);

            return response()->json($response, 200);
        } else {
            $response = User::paginate(10);
            return response()->json($response, 200);
        }
    }
}
