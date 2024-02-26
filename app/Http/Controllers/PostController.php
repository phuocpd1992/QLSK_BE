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

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['']]);
    }

  
    public function createPost(Request $request){
        try {
            $payload = $request->all();
            DB::table('posts')->insert($payload);
            return response()->json(['code' => 200, 'message' => 'Post created successfully']);

        } catch (QueryException $e) {
            // Handle database-related exceptions
            return response()->json(['code' => 500, 'message' => 'Database error']);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['code' => 500, 'message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }


    public function readPost()
    {
        try {
            $data = DB::table('posts')->get();
            return response()->json(['code' => 200, 'data' => $data]);
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(['code' => 500, 'message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }


    public function readPostById($id)
    {
        try {
            $user = DB::table('posts')->find($id);
    
            if (!$user) {
                return response()->json(['code' => 404, 'message' => 'Post not found.']);
            }

            return response()->json(['code' => 200, 'data' => $user]);
        } catch (\Exception $e) {
            \Log::error('Error in readPostById: ' . $e->getMessage());
            return response()->json(['code' => 500, 'message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }



    public function updatePostById(Request $request, $id){
        try {
            $payload = $request->all();
            $affectedRows = DB::table('posts')
                ->where('id', $id)
                ->update($payload);

            if ($affectedRows > 0) {
                return response()->json(['code' => 200, 'message' => 'Posts updated successfully']);
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


    public function deletePostById(Request $request, $id)
    {
        try {
            $affectedRows = DB::table('posts')
                ->where('id', $id)
                ->delete();

            if ($affectedRows > 0) {
                return response()->json(['code' => 200, 'message' => 'Post deleted successfully']);
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

}
