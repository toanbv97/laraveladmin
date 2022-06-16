<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryRelationship;
use App\Models\Post;
use App\Models\Vote;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Image;
use Yajra\DataTables\DataTables;
use App\Helpers\CommonHelper;
use function Psr\Log\error;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            \session(['module_active' => 'post',  'active' => 'Bài viết']);
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view',Post::class);
        $search = $request->search;
        $limit = 10;
        if (!is_null($request->limit))
            $limit = $request->limit;
        $posts = DB::table('posts')
            ->select('posts.*','users.name as user_name')
            ->leftJoin('users','posts.user_id','=','users.id')
            ->when($search, function ($query, $search){
                return $query->where('posts.title','like',"%$search%");
            })
            ->whereNull('posts.deleted_at')
            ->paginate($limit);
        if($request->ajax()){
            return view('admin.post.data-table',['posts'=>$posts]);
        }
        return view('admin.post.index',[
            'title' => 'Danh sách bài viết',
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',Post::class);
        $arrCate = DB::table('categories')->where('taxonomy',Category::BAI_VIET)->pluck('name','id');
        return view('admin.post.create',[
            'arrCate' => $arrCate,
            'title' => 'Tạo bài viết'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create',Post::class);
        $request->validate(
            [
                'title' => 'required|max:300|unique:posts',
                'thumb' =>'image|mimes:jpeg,jpg,png|mimetypes:image/jpeg,image/png,image/jpg|max:5048'
            ],
            [
                'title.required' => 'Tiêu đề không được để trống.',
                'title.max' => 'Tiêu đề có độ dài tối đa :max ký tự.',
                'title.unique' => 'Tiêu đề đã tồn tại trong hệ thống',
                'thumb.image' => 'Ảnh đại diện không đúng định dạng! (jpg, jpeg, png)',
            ]
        );

        $status = Post::ACTIVE;
        $nameFile = Post::IMAGE;
        if ($request->status == null)
            $status = Post::DISABLE;
        if ($request->thumb != null){
            $nameFile = CommonHelper::convertTitleToSlug($request->title,'-').'-'.time().'.'.$request->thumb->extension();
        }
        $input = [
            'title'=> $request->title,
            'slug'=> CommonHelper::convertTitleToSlug($request->title,'-'),
            'excerpt'=> $request->excerpt,
            'content'=> $request->content,
            'thumb'=> $nameFile,
            'status'=> $status,
            'user_id'=> Auth::id(),
        ];

        try {
            DB::beginTransaction();
            $post = Post::create($input);
            if ($request->categories != null){
                foreach ($request->categories as $category){
                    /** Lưu category_relationships */
                    $data = [
                        'cat_id'=> $category,
                        'post_id'=> $post->id
                    ];
                    CategoryRelationship::create($data);
                }
            }
            DB::commit();
            /** Lưu ảnh vào folder*/
            if ($request->thumb != null){
                $folder_large = 'upload/images/post/large/';
                $folder_medium = 'upload/images/post/medium/';
                $folder_thumb = 'upload/images/post/thumb/';
                CommonHelper::cropImage2($request->thumb,$nameFile,600,600,$folder_large);
                CommonHelper::cropImage2($request->thumb,$nameFile,300,300,$folder_medium);
                CommonHelper::cropImage2($request->thumb,$nameFile,150,150,$folder_thumb);
                $folder = 'upload/images/post/';
                CommonHelper::uploadImage($request->thumb,$nameFile,$folder);
            }
            return redirect()->route('post.index')->with('success','Tạo bài viết mới thành công.');
        }catch (\Exception $exception){
            DB::rollBack();
//            throw new \Exception($exception->getMessage());
            return redirect()->route('post.index')->with('error','Đã có lỗi xảy ra. Vui lòng thử lại!');
        }
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
        $this->authorize('update',Post::class);
        $post = Post::find($id);
        if (is_null($post)){
            \abort(404);
        }else{
            $arrCate = DB::table('categories')->where('taxonomy',Category::BAI_VIET)->pluck('name','id');
            $arrCateRela = [];
            $arr = CategoryRelationship::where('post_id',$id)->get();
            foreach ($arr as $item){
                $arrCateRela[] = $item->cat_id;
            }
            return view('admin.post.edit',[
                'arrCate' => $arrCate,
                'arrCateRela' =>$arrCateRela,
                'post' => $post,
                'title' => 'Sửa bài viết'
            ]);
        }
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
        $this->authorize('update',Post::class);

        $request->validate(
            [
                'title' => 'required|max:300|unique:posts,title,'.$id,
                'thumb' =>'image|mimes:jpeg,jpg,png|mimetypes:image/jpeg,image/png,image/jpg|max:5048'
            ],
            [
                'title.required' => 'Tiêu đề không được để trống.',
                'title.max' => 'Tiêu đề có độ dài tối đa :max ký tự.',
                'title.unique' => 'Tiêu đề đã tồn tại trong hệ thống',
                'thumb.image' => 'Ảnh đại diện không đúng định dạng! (jpg, jpeg, png)',
            ]
        );

        $post = Post::find($id);
        if (!is_null($post)){
            $status = Post::ACTIVE;
            $nameFileOld = $post->thumb;
            if ($request->status == null)
                $status = Post::DISABLE;

            if ($request->thumb != null){
                $nameFile = CommonHelper::convertTitleToSlug($request->title,'-').'-'.time().'.'.$request->thumb->extension();
            }else
                $nameFile = $nameFileOld;
            /** Update bản ghi  */
            $input = [
                'title'=> $request->title,
                'slug'=> CommonHelper::convertTitleToSlug($request->title,'-'),
                'excerpt'=> $request->excerpt,
                'content'=> $request->content,
                'thumb'=> $nameFile,
                'status'=> $status,
                'user_id'=> Auth::id(),
            ];

            try {
                DB::beginTransaction();
                $post->update($input);
                CategoryRelationship::where('post_id',$post->id)->delete();
                if ($request->categories != null){
                    foreach ($request->categories as $category){
                        // Lưu category_relationships
                        $data = [
                            'cat_id'=> $category,
                            'post_id'=> $post->id
                        ];
                        CategoryRelationship::create($data);
                    }
                }
                DB::commit();

                if ($request->thumb != null){
                    /** Lưu ảnh mới vào folder */
                    $folder_large = 'upload/images/post/large/';
                    $folder_medium = 'upload/images/post/medium/';
                    $folder_thumb = 'upload/images/post/thumb/';
                    CommonHelper::cropImage2($request->thumb,$nameFile,600,600,$folder_large);
                    CommonHelper::cropImage2($request->thumb,$nameFile,300,300,$folder_medium);
                    CommonHelper::cropImage2($request->thumb,$nameFile,150,150,$folder_thumb);

                    $folder = 'upload/images/post/';
                    CommonHelper::uploadImage($request->thumb,$nameFile,$folder);

                    /** Xoá ảnh cũ khi có upload ảnh mới */
                    if ($nameFileOld != Post::IMAGE){
                        CommonHelper::deleteImage($nameFileOld,$folder_large);
                        CommonHelper::deleteImage($nameFileOld,$folder_medium);
                        CommonHelper::deleteImage($nameFileOld,$folder_thumb);
                        CommonHelper::deleteImage($nameFileOld,$folder);
                    }
                }
                return redirect()->route('post.index')->with('success','Sửa bài viết thành công.');
            }catch (\Exception $exception){
                DB::rollBack();
                return redirect()->route('post.index')->with('error','Đã có lỗi xảy ra. Vui lòng thử lại!');
            }
        }
        return redirect()->route('post.index')->with('error','Đã có lỗi xảy ra. Vui lòng thử lại!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete',Post::class);
        $post = Post::find($request->id);
        if (!is_null($post)){
            $post->delete();
            Vote::where('post_id',$request->id)->delete();
            return \json_encode(array('success'=>true));
        }
        return \json_encode(array('success'=>false));
    }

    public function deleteImg(Request $request){
        $this->authorize('update',Post::class);
        if (!empty($request->id)){
            $post = Post::find($request->id);
            if (!is_null($post)){
                if ($post->thumb != Post::IMAGE){
                    $folder_thumb = 'upload/images/post/thumb/';
                    $folder = 'upload/images/post/';
                    CommonHelper::deleteImage($post->thumb,$folder_thumb);
                    CommonHelper::deleteImage($post->thumb,$folder);
                    $post->update(['thumb'=>Post::IMAGE]);
                }
                return \json_encode(array('success'=>true));
            }
        }
        return \json_encode(array('success'=>false));
    }
}
