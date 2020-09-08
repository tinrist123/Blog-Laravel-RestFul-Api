<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;

class PostController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/post/tags/{id}",
     *      operationId="getProjectById33",
     *      tags={"Post"},
     *      summary="Get tags have foreign key with post ",
     *      description="Returns Tags By id Post",
     *      @OA\Parameter(
     *          name="id",
     *          description="Post id",
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
    public function tagsPost($id)
    {
        $post = \App\Post::findOrFail($id);

        return $post->tag;
    }
    /**
     * @OA\Get(
     *      path="/api/v1/post/total",
     *      operationId="getTotalPost",
     *      tags={"Post"},
     *      summary="Get total of post",
     *      description="Return total of post",
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
    public function countAllPosts()
    {
        $countPost = \App\Post::get()->count();
        return $countPost;
    }
    /**
     * @OA\Get(
     *      path="/api/v1/post/category/image/{idCate}",
     *      operationId="getPost-Related-Category",
     *      tags={"Post"},
     *      summary="Get post have id category which is foreign key with Post ",
     *      description="Returns post By id Category foreign key Post",
     *      @OA\Parameter(
     *          name="idCate",
     *          description="Category id",
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
    public function catePosts($id)
    {
        $cate_by_id = \App\Category::findOrFail($id);

        return $cate_by_id->post->take(3);
    }
    /**
     * @OA\Get(
     *      path="/api/v1/post/related/{id}",
     *      operationId="getPost-Related-Post-By-Post-Id",
     *      tags={"Post"},
     *      summary="Get related post have id category which is foreign key with Post ",
     *      description="Returns related post By id Category foreign key Post",
     *      @OA\Parameter(
     *          name="id",
     *          description="Category id",
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
    public function relatedPosts($id)
    {
        $related_cate_id = \App\Post::findOrFail($id)->cate_id;
        $relatedPosts = \App\Post::where('cate_id', '=', $related_cate_id)->where('id', '<>', $id)->get()->take(3);
        return $relatedPosts;
    }
    /**
     * @OA\Get(
     *      path="/api/v1/post/new/page/{page}",
     *      operationId="getnewPost-show-per-page",
     *      tags={"Post"},
     *      summary="Get new post per page",
     *      description="Returns post per page",
     *      @OA\Parameter(
     *          name="page",
     *          description="page number",
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
    public function getNewPosts($page)
    {
        $posts = \App\Post::offset((((int)$page - 1) * 5))->take(5)->get();

        foreach ($posts as $value) {
            $value['CateName'] = $value->category->CateName;
        }
        return $posts;
    }
    public function index()
    {
        //
        $posts = \App\Post::all();
        return $posts;
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
        //     'tags' => 'required|array',
        //     'tags.*' => 'required|string|distinct|unique:tags,TagName'
        // ]);

        // if ($validation->fails()) {
        //     return response()->json(
        //         ['error' => $validation->errors()],
        //         401
        //     );
        // }
        return $request;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/post/{id}",
     *      operationId="getPostById",
     *      tags={"Post"},
     *      summary="Get Post By Id",
     *      description="Returns Post",
     *      @OA\Parameter(
     *          name="id",
     *          description="Project id",
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
    public function show($id)
    {
        //
        $post = \App\Post::findOrFail($id);

        return $post;
    }
    /**
     * @OA\Get(
     *      path="/api/v1/post/user/{id}",
     *      operationId="getUserByIdPost",
     *      tags={"Post"},
     *      summary="Get user by id Post ",
     *      description="Returns User",
     *      @OA\Parameter(
     *          name="id",
     *          description="Post id",
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
    public function showUser($id)
    {
        //
        $post = \App\Post::findOrFail($id);

        return $post->user;
    }
    /**
     * @OA\Get(
     *      path="/api/v1/post/comment/{id}",
     *      operationId="getCommentgoryByIdPost",
     *      tags={"Post"},
     *      summary="Get comment by id Post ",
     *      description="Returns comment",
     *      @OA\Parameter(
     *          name="id",
     *          description="Post id",
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
    public function showComment($id)
    {
        //
        $post = \App\Post::findOrFail($id);

        $post['avatar'] = $post->user->Avatar;
        foreach ($post->comment as $value) {
            $value['Avatar'] = $value->user->Avatar;
        }
        return $post->comment;
    }
    /**
     * @OA\Get(
     *      path="/api/v1/post/category/{id}",
     *      operationId="getCategoryByIdPost",
     *      tags={"Post"},
     *      summary="Get category by id Post ",
     *      description="Returns category",
     *      @OA\Parameter(
     *          name="id",
     *          description="Post id",
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
    public function showCate($id)
    {
        $post = \App\Post::findOrFail($id);

        return $post->category;
    }
    /**
     * @OA\Get(
     *      path="/api/v1/post/tag/{id}",
     *      operationId="getTagByIdPost",
     *      tags={"Post"},
     *      summary="Get tag by id Post ",
     *      description="Returns tag",
     *      @OA\Parameter(
     *          name="id",
     *          description="Post id",
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
    public function showTag($id)
    {
        //
        $post = \App\Post::findOrFail($id);

        return $post->tag;
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
