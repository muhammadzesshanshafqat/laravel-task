<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request) {
        $userId = $request->userId;
        $user = User::find($userId);
        return $user;
    }
}
