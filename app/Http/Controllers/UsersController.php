<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function ajaxSearchUsers(Request $request)
    {
        $searchTerm = $request->input('search');

        $users = User::where('name', 'LIKE', '%' . $searchTerm . '%')->get();

        return response()->json($users);
    }
}
