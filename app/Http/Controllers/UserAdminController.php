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
        $this->middleware('auth:api', ['except' => ['']]);
    }

  
    public function createUser(Request $request){
        try {
            // get payload data from python
            $payload = $request->all();
            DB::table('users')->insert($payload);
            return response()->json(['code' => 200, 'message' => 'User created successfully']);

        } catch (QueryException $e) {
            // Handle database-related exceptions
            return response()->json(['code' => 500, 'message' => 'Database error']);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['code' => 500, 'message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function readUser()
    {
        try {
            $data = DB::table('users')->get();
            return response()->json(['code' => 200, 'data' => $data]);
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(['code' => 500, 'message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function readUserById($id)
    {
        try {
            $user = DB::table('users')->find($id);
    
            if (!$user) {
                return response()->json(['code' => 404, 'message' => 'User not found.']);
            }

            return response()->json(['code' => 200, 'data' => $user]);
        } catch (\Exception $e) {
            \Log::error('Error in readUserById: ' . $e->getMessage());
            return response()->json(['code' => 500, 'message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
    

    public function updateUserByID(Request $request, $id){
        try {
            $payload = $request->all();
            $affectedRows = DB::table('users')
                ->where('id', $id)
                ->update($payload);

            if ($affectedRows > 0) {
                return response()->json(['code' => 200, 'message' => 'User updated successfully']);
            } else {
                return response()->json(['code' => 404, 'message' => 'Record not found']);
            }
        } catch (QueryException $e) {
            // Handle database-related exceptions
            return response()->json(['code' => 500, 'message' => 'Database error: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['code' => 500, 'message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function deleteUserById(Request $request, $id)
    {
        try {
            $affectedRows = DB::table('users')
                ->where('id', $id)
                ->delete();

            if ($affectedRows > 0) {
                return response()->json(['code' => 200, 'message' => 'User deleted successfully']);
            } else {
                return response()->json(['code' => 404, 'message' => 'Record not found']);
            }
        } catch (QueryException $e) {
            // Handle database-related exceptions
            return response()->json(['code' => 500, 'message' => 'Database error: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['code' => 500, 'message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }


    public function readCompanyList()
    {
        try {
            $data = DB::table('company_list')->get();
            return response()->json(['code' => 200, 'data' => $data]);
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(['code' => 500, 'message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
 
}
