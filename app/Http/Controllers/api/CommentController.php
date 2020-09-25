<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validation = Validator::make($request->all(), [
            'idPost' => 'required|integer',
            'name' => 'required|string',
            'email' => 'required|string|email',
            'comment' => 'required|string',
            'idUser' => 'required|integer'
        ]);

        if ($validation->fails()) {
            return response()->json(
                ['error' => $validation->errors()],
                401
            );
        }

        $name = $request->name;
        $email = $request->email;
        $comment = $request->comment;
        $idPost = $request->idPost;
        $idUser = $request->idUser;

        $newIdUser = \App\User::updateOrCreate(
            ['Email' => $email],
            ['Name' => $name],
        );

        $newComment = \App\Comment::create([
            'Comment' => $comment,
            'user_id' => $newIdUser->id,
            'reply_id' => ($idUser === -1) ? 0 : $idUser,
            'post_id' => $idPost,
        ]);

        if ($newComment) {
            return array(
                'status' => 'success',
                'code' => '200'
            );
        } else {
            return response()->json(['error' => 'Server Error'], 401);
        }
    }



    public function getReply($idPost, $idUser)
    {
        $user = \App\Comment::where('post_id', $idPost)->where('reply_id', $idUser)->get();

        foreach ($user as $value) {
            $value['Name'] = $value->user->Name;
        }

        return $user;
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        $validation = Validator::make($request->all(), [
            'idBlogger' => 'required|integer|exists:blogger,id'
        ]);


        if ($validation->fails()) {
            return response()->json(
                ['error' => $validation->errors()],
                401
            );
        }

        $idBlogger = $request->idBlogger;

        $deletedCmt = \App\Comment::find($id);

        if ($deletedCmt) {
            $postOwnBlogger = $deletedCmt->post()->where('blogger_id', $idBlogger)->first();
            if (!$postOwnBlogger) {
                return response()->json(['message' => 'You must own this blogger to delete'], 202);
            } else {
                if ($deletedCmt->delete()) {
                    return response()->json(['success' => 'Delete successfully', 'status' => '200'], 200);
                } else {
                    return response()->json(['error' => 'Server Error', 'status' => '401'], 401);
                }
            }
        } else {
            return response()->json(['message' => 'Please Refresh this page'], 401);
        }
    }
}
