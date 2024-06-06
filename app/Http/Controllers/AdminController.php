<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

use App\Models\Admin;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

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
        try {
            Admin::create([
                'username' => $request->username,
                'password' => $request->password
            ]);
            return response()->json([
                'message' => "Admin successfully created."
            ], 200);
        } catch (Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!",
                'request' => $request->username,
                'exp' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $users = DB::table('admins')
            ->where('username', $request->username)
            ->where('password', $request->password)
            ->get();

        if ($users->isEmpty()) {
            return response()->json([
                'message' => 'Error',

            ], 200);
        } else {
            return response()->json([

                'message' => 'User authentication success',
                'request' => $request->password

            ], 200);
        }
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
    public function update(Request $request, string $id)
    {
        try {
            $users = Admin::where('username', $request->username)
                ->where('password', $request->password)
                ->first();

            if (!$users) {
                return response()->json([
                    'message' => 'Error',

                ], 200);
            }
            // $users->update([
            //     // 'username' => $request->username,
            //     'password' => $request->newpassword,
            // ]);
            $users->username=$request->username;
            $users->password=$request->newpassword;
            $users->save();
            return response()->json([

                'message' => 'Success',
                'request' => $request->username,
                'pass' => $request->newpassword

            ], 200);
        } catch (Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went terribly wrong!!",
                'request' => $request->username,
                'pass' => $request->newpassword,
                'exp' => $e->getMessage()
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
