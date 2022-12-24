<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function users()
    {
        return view('admin.users', [
            'result'=>User::when(request()->id, function($query){
                $query->where('id', request()->id);
            })
            ->when(request()->search, function($query){
                $query->where('name->firstname', request()->search)->orWhere('name->lastname', request()->search);
            })
            ->orderBy('created_at', 'desc')->paginate(20)
        ]);
    }
}
