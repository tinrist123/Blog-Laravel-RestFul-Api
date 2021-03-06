<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Validator;

class PostController extends Controller
{
    /**
     * @OA\Get(
     *      path="api/v1/post/tags/{id}",
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
     *      path="api/v1/post/total",
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
     *      path="api/v1/post/category/image/{idCate}",
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
     *      path="api/v1/post/related/{id}",
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
     *      path="api/v1/post/new/page/{page}",
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
        $posts = \App\Post::offset((((int)$page - 1) * 5))->orderBy('created_at', 'DESC')->take(5)->get();

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

        $validation = Validator::make($request->all(), [
            'category' => "required",
            'tags' => 'required',
            'tags.oldTag' => "array",
            'tags.newTag' => 'array',
            'tags.newTag.*' => 'distinct|unique:tags,TagName',
            'title' => 'required|string',
            'content' => 'required|string',
            'imgUrl' => 'required|url',
            'idBlogger' => "required|integer|exists:blogger,id"
        ]);

        if ($validation->fails()) {
            return response()->json(
                ['error' => $validation->errors()],
                401
            );
        }

        $category = $request->category;

        $tags = $request->tags;
        $newTag = $tags['newTag'];
        $oldTag = $tags['oldTag'];

        $title = $request->title;
        $short_description = $request->Short_Description;
        $content = $request->content;
        $imgUrl = $request->imgUrl;
        $idBlogger = $request->idBlogger;

        if (is_int($request->category)) {
            $idUpdateCate = $request->category;
        } else {
            $idUpdateCate = \App\Category::firstOrCreate(
                [
                    'CateName' => $category,
                ],
                ['Alias' => convert_vi_to_en($category)],
            )->id;
        }


        $newPostId = \App\Post::create([
            'Title' => $title,
            'Alias' => convert_vi_to_en($title),
            'Short_Description' => $short_description,
            'Content' => $content,
            'Image' => $imgUrl,
            'blogger_id' => $idBlogger,
            'cate_id' => $idUpdateCate,
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);

        foreach ($newTag as $value) {
            $tagId = \App\Tag::create([
                'TagName' => $value,
            ]);
            $post_have_tag = \App\PostAndTag::create([
                'post_id' => $newPostId->id,
                'tag_id' => $tagId->id,
            ]);
        }

        foreach ($oldTag as $value) {
            $post_have_tag = \App\PostAndTag::create([
                'post_id' => $newPostId->id,
                'tag_id' => $value,
            ]);
        }

        return [
            'status' => 'success',
            'code' => 200,
        ];
    }

    /**
     * @OA\Get(
     *      path="api/v1/post/{id}",
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

        $post['blogger'] = $post->blogger;

        return $post;
    }
    /**
     * @OA\Get(
     *      path="api/v1/post/user/{id}",
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
    public function showBlogger($id)
    {
        //
        $post = \App\Post::findOrFail($id);

        return $post->blogger;
    }
    /**
     * @OA\Get(
     *      path="api/v1/post/comment/{id}",
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
        $post = \App\Post::find($id);

        if ($post === null) return [];
        foreach ($post->comment->where('reply_id', 0) as $value) {
            $value['name'] = $value->user->Name;
        }

        return $post->comment->where('reply_id', 0);
    }
    /**
     * @OA\Get(
     *      path="api/v1/post/category/{id}",
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
     *      path="api/v1/post/tag/{id}",
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
    public function update(Request $request, $idBlog)
    {
        //
        $validation = Validator::make($request->all(), [
            'category' => "required",
            'tags' => 'required',
            'tags.oldTag' => "array",
            'tags.newTag' => 'array',
            'tags.newTag.*' => 'required|distinct',
            'title' => 'required|string',
            'content' => 'required|string',
            'imgUrl' => 'required|url',
            'idBlogger' => 'required|integer|exists:blogger,id',
        ]);

        $category = $request->category;

        $tags = $request->tags;
        $newTag = $tags['newTag'];
        $oldTag = $tags['oldTag'];

        $idBlogger = $request->idBlogger;
        $title = $request->title;
        $short_description = $request->Short_Description;
        $content = $request->content;
        $imgUrl = $request->imgUrl;
        if ($validation->fails()) {
            return response()->json(
                ['error' => $validation->errors()],
                401
            );
        }

        if (is_int($request->category)) {
            $idUpdateCate = $request->category;
        } else {
            $idUpdateCate = \App\Category::firstOrCreate(
                [
                    'CateName' => $category,
                ],
                ['Alias' => convert_vi_to_en($category)],
            )->id;
        }

        if (!$idUpdateCate) {
            return 'error';
        }

        $UpdatedPost = \App\Post::find($idBlog)->update([
            'Title' => $title,
            'Alias' => convert_vi_to_en($title),
            'Short_Description' => $short_description,
            'Content' => $content,
            'Image' => $imgUrl,
            'blogger_id' => $idBlogger,
            'cate_id' => $idUpdateCate,
        ]);
        if (!$UpdatedPost) {
            return 'error';
        }
        foreach ($newTag as $value) {
            $tagId = \App\Tag::updateOrCreate([
                'TagName' => $value,
            ]);
            if ($tagId) {
                $post_have_tag = \App\PostAndTag::create([
                    'post_id' => $idBlog,
                    'tag_id' => $tagId->id,
                ]);
            } else {
                return 'error';
            }
        }

        foreach ($oldTag as $value) {
            $post_have_tag = \App\PostAndTag::updateOrCreate([
                'post_id' => $idBlog,
                'tag_id' => $value,
            ]);

            if (!$post_have_tag) {
                return 'error';
            }
        }

        return [
            'status' => 'success',
            'code' => 200,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $idBlog)
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

        $deletedPost = \App\Post::find($idBlog);
        if ($deletedPost) {
            $postOwnBlogger = $deletedPost->where('blogger_id', $idBlogger)->first();
            if (!$postOwnBlogger) {
                return response()->json(['message' => 'You must own this blogger to delete'], 202);
            } else {
                if ($deletedPost->delete()) {
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
