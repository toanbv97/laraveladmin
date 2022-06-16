<?php

namespace App\Http\Controllers\Categorypost;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Response;
use Redirect;

class CategorypostController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            \session(['module_active' => 'post', 'active' => 'Bài viết']);
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $this->authorize('viewAnypost', Category::class);
        $limit =  $request->query('limit');
        $keywords =  $request->query('keywords');
        $orderby =  $request->query('orderby');
        $desc_asc = 'ASC';
        if($limit==null){$limit=10;}
        if($keywords==null){$keywords="";}
        if($orderby==null){$orderby="id";}

        if($limit == 10 && $keywords=="" && $orderby== "id"){
            $Category = Category::where('taxonomy', '=', 1)->paginate($limit);}
        else
        {
            $Category = Category::where('taxonomy', '=', 1)
            ->where('name', 'like', '%' . $keywords . '%')->orderby($orderby,$desc_asc)->Paginate($limit);
        //      $html = view('admin.category.search',[
        //         'Category' => $Category,
        //         'title' => 'Danh mục',
        //     ])->render();
        //      return response()->json([

        //     'html' => $html,

        // ]);
        }
        return view('admin.categorypost.index',[
                'Category' => $Category,
                'title' => 'Danh mục bài viết',
            ]);
    }
    public function create()
    {
        $this->authorize('createpost', Category::class);
        $user_id = Auth::user()->id;
        $categorieslv = $this->categorylevel();
        return view('admin.categorypost.create',[
            'categorieslv' => $categorieslv,
            'title' => 'Thêm danh mục',
            'user_id' => $user_id,
        ]);
    }

    public function store(Request $request)
    {
        $name = $request->name;
        $slug = Str::slug($request->slug, '-');
        // Validator::extend('uniqueslug', function($attribute, $value, $parameters)
        // {   $slug = Str::slug($value, '-');
        //     $checkslug = DB::table('categories')->where('slug', '=', $slug)->get()->count();
        //     if($checkslug == 0)
        //     return true;
        //     else return false;
        // });
        $request->validate([
                'name' => 'required|max:255|unique:categories,name,'.$name,
                'slug' => 'required|max:255|unique:categories,slug,'.$slug,
            ],
            [
                'name.required' => 'Tên danh mục không được phép bỏ trống',
                'name.max' => 'Tên danh mục không được phép vượt quá 255 ký tự',
                'name.unique' => 'Tên danh mục đã tồn tại',
                'slug.unique' => 'Tên slug đã tồn tại',
                // 'slug.uniqueslug' => 'Tên slug đã tồn tại',
                'slug.max' => 'Tên slug không được phép vượt quá 255 ký tự',
                'slug.required' => 'Tên slug không được phép bỏ trống',
            ]);
        if (empty($request->slug)) {$request->slug = '';}
        if (empty($request->parent_id)) {$request->parent_id = 0;}
        if (empty($request->user_id)) {$request->user_id = 0;}

        $Category = [
            'name' => $request->name,
            'slug' => $slug,
            'taxonomy' => 1,
            'parent_id' => $request->parent_id,
            'user_id' => $request->user_id,
            'status' => $request->has('status'),
        ];
        try {
            DB::beginTransaction();
            Category::create($Category);
            DB::commit();
            return redirect()->route('categorypost.index')->with('success','Thêm danh mục mới thành công.');
            }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->route('categorypost.index')->with('error','Đã có lỗi xảy ra. Vui lòng thử lại!');
        }
    }

    public function categorylevel()
    {
        $data = Category::where('taxonomy', '=', 1)->get();
        $listcategory = [];
        Category::recursive($data, $parents = 0, $level = 1, $listcategory);
        return $listcategory;
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('update', Category::class);
        $edit = Category::find($id);
        if ($edit !== null) {
            $categorieslv = $this->categorylevel();
            return view('admin.categorypost.edit',[
            'categorieslv' => $categorieslv,
            'title' => 'Sửa danh mục',
            'edit' => $edit,
        ]);
        } else {
            \abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->slug = Str::slug($request->slug, '-');
        $request->validate([
                'name' => 'required|max:255|unique:categories,name,'.$id.',id',
                'slug' => 'required|max:255|unique:categories,slug,'.$id.',id',
            ],
            [
                'name.required' => 'Tên danh mục không được phép bỏ trống',
                'name.max' => 'Tên danh mục không được phép vượt quá 255 ký tự',
                'name.unique' => 'Tên danh mục đã tồn tại',
                'slug.required' => 'Tên slug không được phép bỏ trống',
                'slug.max' => 'Tên slug không được phép vượt quá 255 ký tự',
                'slug.unique' => 'Tên slug đã tồn tại',
            ]);
        $slug = $request->slug;
        if (empty($request->slug)) {$request->slug = '';}
        if (empty($request->parent_id)) {$request->parent_id = 0;}
        if (empty($request->user_id)) {$request->user_id = 0;}

        $Categorys = Category::find($id);
        $Category = [
            'name' => $request->name,
            'slug' => $slug,
            'taxonomy' => 1,
            'parent_id' => $request->parent_id,
            'user_id' => $request->user_id,
            'status' => $request->has('status'),
        ];

        try {
            DB::beginTransaction();
            $Categorys->update($Category);
            DB::commit();
            return redirect()->route('categorypost.index')->with('success','Cập nhật danh mục thành công.');
            }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->route('categorypost.index')->with('error','Đã có lỗi xảy ra. Vui lòng thử lại!');
        }
    }
    public function destroy(Request $request)
    {
        $this->authorize('deletepost',Category::class);
        $Category = Category::find($request->id);
        if (!is_null($Category)){
         $Category->delete();
         return \json_encode(array('success'=>true));
        }
        return \json_encode(array('success'=>false));
    }
}
