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
            'email' => 'required|string|email|unique:users,Email',
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

        $newIdUser = \App\User::create([
            'Name' => $name,
            'Email' => $email,
        ]);

        $newComment = \App\Comment::create([
            'Comment' => $comment,
            'user_id' => $newIdUser->id,
            'reply_id' => ($idUser === -1) ? 0 : $idUser,
            'post_id' => $idPost,
        ]);

        return array(
            'status' => 'success',
            'code' => '200'
        );
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
    public function destroy($id)
    {
        //
    }
}
