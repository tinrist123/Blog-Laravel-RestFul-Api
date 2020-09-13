<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Response;

class TagController extends Controller
{
    /**
     * @OA\Get(
     *      path="api/v1/tags/post/{id}/page={page}",
     *      operationId="getPostByIdTagAndPage11",
     *      tags={"Tag"},
     *      summary="Get post by id tag and show on per page",
     *      description="Returns post related with id tag",
     *      @OA\Parameter(
     *          name="id",
     *          description="tag id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *          @OA\Parameter(
     *          name="page",
     *          description="page  number ",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "oauth2_security_example": {"write:projects", "read:projects"}
     *         }
     *     },
     * )
     */
    public function getPostsPerPage($id, $page)
    {
        $tag = \App\Tag::findOrFail($id)->post->skip(((int)$page - 1) * 5)->take(5)->toArray();
        $data = [];
        foreach ($tag as $value) {
            array_push($data, $value);
        }
        return $data;
    }
    /**
     * @OA\Get(
     *      path="api/v1/tags/post/total/{id}",
     *      operationId="getTotalPostByIdTag11",
     *      tags={"Tag"},
     *      summary="Get total post by id tag ",
     *      description="Returns total post related with id tag",
     *      @OA\Parameter(
     *          name="id",
     *          description="tag id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "oauth2_security_example": {"write:projects", "read:projects"}
     *         }
     *     },
     * )
     */
    public function getTotalPostsOnTag($id)
    {
        $totalTag = \App\Tag::findOrFail($id)->post->count();

        return $totalTag;
    }
    /**
     * @OA\Get(
     *      path="api/v1/tags/post/{id}",
     *      operationId="getPostByIdTag1",
     *      tags={"Tag"},
     *      summary="Get  post by id tag ",
     *      description="Returns  post related with id tag",
     *      @OA\Parameter(
     *          name="id",
     *          description="tag id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "oauth2_security_example": {"write:projects", "read:projects"}
     *         }
     *     },
     * )
     */
    public function getPost($id)
    {
        $tag = \App\Tag::findOrFail($id);

        return $tag->post;
    }
    /**
     * @OA\Get(
     *      path="api/v1/tag",
     *      operationId="getAllTag",
     *      tags={"Tag"},
     *      summary="Get list of tag",
     *      description="Returns list of tag",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public function index()
    {
        //
        $tags = \App\Tag::all();

        return $tags;
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
            'tags' => 'required|array',
            'tags.*' => 'required|string|distinct|unique:tags,TagName'
        ]);

        if ($validation->fails()) {
            return response()->json(
                ['error' => $validation->errors()],
                401
            );
        }
        $data = $request['tags'];
        for ($i = 0; $i < count($data); $i++) {
            $newTag = new \App\Tag;
            $newTag->TagName = $data[$i];

            if (!$newTag->save()) {
                return response()->json([
                    'error' => 'Cannot Insert Data' . $data[$i],
                    'code' => 401,
                ]);
            }
        }

        return response()->json([
            'message' => 'Successful!!',
            200,
        ]);
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
