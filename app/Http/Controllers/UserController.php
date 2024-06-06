<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = DB::table('users')
                ->where('username', $request->username)
                ->where('password', $request->password)
                ->get();
        
                if ($users->isEmpty()) {
                    return response()->json([
                        'message' => 'Error',
                       
                    ], 200);
                }else{
                    return response()->json([
                        
                        'message' => 'User authentication success',
                       
                    ], 200);
                }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $id)
    {
        $user = User::where('id', $id)->first();
        $validatedData = $request->validate([
            // 'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'newpassword' => 'required|string|min:8',
        ]);
    
        $user->password=$validatedData['newpassword'];
        $user->save();
        return response()->json([
                        
            'message' => 'Success',
            'user'=>$user
           
        ], 200);
        
            
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
