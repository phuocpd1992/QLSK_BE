<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException; 

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;


class DataController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['create']]);
    }

 
    public function create(Request $request){
        try {
            // get payload data from python
            $payload = $request->all();
            DB::table('data')->insert($payload);
            return response()->json(['message' => 'Data created successfully'], 200);
        } catch (QueryException $e) {
            // Handle database-related exceptions
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function read()
    {
        try {
            $data = DB::table('data')->get();
            return response()->json(['data' => $data], 200);
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id){
        try {
            $payload = $request->all();
            $affectedRows = DB::table('data')
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

    public function delete(Request $request, $id)
    {
        try {
            $affectedRows = DB::table('data')
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
