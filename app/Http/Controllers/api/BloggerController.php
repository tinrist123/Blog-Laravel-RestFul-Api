<?php

namespace App\Http\Controllers\api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Blogger;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Carbon;

class BloggerController extends Controller
{
    public $successStatus = 200;

    public function getTotalPostsById($idBlogger)
    {
        $totalPosts = \App\Blogger::findOrFail($idBlogger)->post->count();

        return $totalPosts;
    }



    public function getPostsById($idBlogger, $page)
    {
        $posts = \App\Blogger::findOrFail($idBlogger)->post->skip(($page - 1) * 5)->take(5)->toArray();

        return $posts;
    }
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $name = $user->name;
            return response()->json(['success' => $success, 'name' => $name, 'id' => $user->id], $this->successStatus);
        } else {
            return response()->json(['message' => 'Unauthorised'], 203);
        }
    }
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
    }
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request)
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bloggers = \App\Blogger::all();
        return $bloggers;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = Blogger::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success' => $success], $this->successStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $blogger = \App\Blogger::findOrFail($id);

        return $blogger;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idBlogger)
    {
        //
        $validator = Validator::make($request->all(), [
            'Uname' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'status' => '401'], 401);
        }

        $userName = $request->Uname;
        $pass = $request->Pass;
        $cPass = $request->cPass;

        if ($pass && $cPass) {
            if ($pass === $cPass) {
                $editedBlogger = \App\Blogger::find($idBlogger);
                if ($editedBlogger) {
                    $editedBlogger->password = bcrypt($pass);
                    $editedBlogger->name = $userName;
                    $editedBlogger->updated_at = Carbon::now();
                    $editedBlogger->save();
                    return response()->json(['success' => 'Update Successfully', 'status' => '200'], 200);
                } else {
                    return response()->json(['error' => 'Something wrong !,please try to login again', 'status' => '401'], 401);
                }
            }
            return response()->json(['error' => 'Password and confirm password are not the same!', 'status' => '401'], 401);
        } else if (!$pass && !$cPass) {
            $editedBlogger = \App\Blogger::find($idBlogger);
            if ($editedBlogger) {
                $editedBlogger->name = $userName;
                $editedBlogger->updated_at = Carbon::now();
                $editedBlogger->save();
                return response()->json(['success' => 'Update Successfully', 'status' => '200'], 200);
            } else {
                return response()->json(['error' => 'Something wrong !,please try to login again', 'status' => '401'], 401);
            }
        } else {
            return response()->json(['error' => 'Have error with your password', 'status' => '401'], 401);
        }
        return $pass;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getOwnPost($idBlogger, $page)
    {
        $blogger = Blogger::find($idBlogger);

        if ($blogger) {
            return $blogger->post->skip(($page - 1) * 5)->take(5)->toArray();
        } else {
            return response()->json(['message' => 'Token have expired, try to login again', 'status' => '401'], 401);
        }
    }

    public function getTotalOwnPost($idBlogger)
    {
        $blogger = Blogger::find($idBlogger);
        if ($blogger) {
            return $blogger->post->count();
        } else {
            return response()->json(['message' => 'Token have expired, try to login again', 'status' => '401'], 401);
        }
    }

    public function getComment($id)
    {
        // $user = User::findOrFail($id);

        // return $user->comment;
    }
}
