<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *      path="api/v1/category/new",
     *      operationId="getNewCate",
     *      tags={"Category"},
     *      summary="Get list of projects",
     *      description="Returns  the newest Category",
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
    public function newCate()
    {
        $cates = \App\Category::orderBy('created_at', 'DESC')->get()->take(3);

        return $cates;
    }
    /**
     * @OA\Get(
     *      path="api/v1/category/post/{id}",
     *      operationId="getPostOnCateById",
     *      tags={"Category"},
     *      summary="Get Post On Category By Id",
     *      description="Return Posts",
     *      @OA\Parameter(
     *          name="id",
     *          description="Category Id",
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
    public function getPostsonCate($id)
    {
        $post = \App\Category::findOrFail($id)->post->take(5);

        return $post;
    }
    /**
     * @OA\Get(
     *      path="api/v1/category/post/total/{id}",
     *      operationId="getTotalPostById",
     *      tags={"Category"},
     *      summary="Get Total Post By Category",
     *      description="Returns project number of Post",
     *      @OA\Parameter(
     *          name="id",
     *          description="Category Id",
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
     *             "oauth2_security_example": {"write:true", "read:true"}
     *         }
     *     },
     * )
     */
    public function getTotalPostsonCate($id)
    {
        $totalPost = \App\Category::findOrFail($id)->post->count();

        return $totalPost;
    }
    /**
     * @OA\Get(
     *      path="api/v1/category/post/{id}/page={page}",
     *      operationId="getProjectByIdAndPage",
     *      tags={"Category"},
     *      summary="Get Post On Category By Id Per Page",
     *      description="Return Posts Per Page",
     *      @OA\Parameter(
     *          name="id",
     *          description="Category Id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *          @OA\Parameter(
     *          name="page",
     *          description="Page number",
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
    public function getPostsonPage($id, $page)
    {
        $post = \App\Category::findOrFail($id)->post->skip(($page - 1) * 5)->take(5)->toArray();
        $data = [];
        foreach ($post as $value) {
            array_push($data, $value);
        }
        return $data;
    }
    /**
     * @OA\Get(
     *      path="api/v1/category/all",
     *      operationId="getAllCate",
     *      tags={"Category"},
     *      summary="Get list of projects",
     *      description="Returns list of Category",
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
    public function allCate()
    {
        $cate = \App\Category::all();
        return $cate;
    }
    /**
     * @OA\Get(
     *      path="api/v1/category",
     *      operationId="getProjectsList",
     *      tags={"Category"},
     *      summary="Get list of Category",
     *      description="Returns list of Category",
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
        $cate = \App\Category::orderBy('created_at', 'desc')->get()->take(5);
        return $cate;
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
        // $validation = Validator::make($request->all(), [
        //     'CateName' => 'required|string|unique:category,CateName',
        // ]);

        // if ($validation->fails()) {
        //     return response()->json(
        //         ['error' => $validation->errors()],
        //         401
        //     );
        // }
        // $newCate = new \App\Category;

        // $newCate->CateName = $request->CateName;
        // $newCate->Alias = convert_vi_to_en($newCate->CateName);

        // if (!$newCate->save())
        //     return array(
        //         'code'      =>  400,
        //         'message'   =>  'Error!'
        //     );

        // return array(
        //     'code' => 200,
        //     'message' => 'Insert Success'
        // );
        // $post = \App\Post::find(1);

        return $request;
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
