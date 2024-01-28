<?php

namespace App\Http\Controllers;
use App\Http\Controllers\UserAdminController;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException; 

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;



class UserAdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['create']]);
    }

  
    public function createUser(Request $request){
        try {
            // get payload data from python
            $payload = $request->all();
            DB::table('users')->insert($payload);
            return response()->json(['message' => 'User created successfully'], 200);
        } catch (QueryException $e) {
            // Handle database-related exceptions
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function readUser()
    {
        try {
            $data = DB::table('users')->get();
            return response()->json(['data' => $data], 200);
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function readUserById($id)
    {
        try {
            $user = DB::table('users')->find($id);
    
            if (!$user) {
                return response()->json(['message' => 'User not found.'], 404);
            }
    
            return response()->json(['data' => $user], 200);
        } catch (\Exception $e) {
            \Log::error('Error in readUserById: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }
    

    public function updateUserByID(Request $request, $id){
        try {
            $payload = $request->all();
            $affectedRows = DB::table('users')
                ->where('id', $id)
                ->update($payload);

            if ($affectedRows > 0) {
                return response()->json(['message' => 'Data updated successfully'], 200);
            } else {
                return response()->json(['error' => 'Record not found'], 404);
            }
        } catch (QueryException $e) {
            // Handle database-related exceptions
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function deleteUserById(Request $request, $id)
    {
        try {
            $affectedRows = DB::table('users')
                ->where('id', $id)
                ->delete();

            if ($affectedRows > 0) {
                return response()->json(['message' => 'Data deleted successfully'], 200);
            } else {
                return response()->json(['error' => 'Record not found'], 404);
            }
        } catch (QueryException $e) {
            // Handle database-related exceptions
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
 
}
