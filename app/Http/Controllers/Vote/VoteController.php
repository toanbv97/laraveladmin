<?php

namespace App\Http\Controllers\Vote;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    public function __construct()
    {
//        $this->middleware(function ($request, $next) {
//            \session(['module_active' => 'vote']);
//            return $next($request);
//        });
    }

    /** Vote Post */
    public function indexVotePost(Request $request){
        \session(['module_active' => 'post',  'active' => 'Bài viết']);
        $this->authorize('viewPost',Vote::class);
        $search = $request->search;
        $limit = 10;
        if (!is_null($request->limit))
            $limit = $request->limit;
        $votes = DB::table('votes')
            ->select('votes.*','posts.title as post_title')
            ->leftJoin('posts','votes.post_id','=','posts.id')
            ->when($search, function ($query, $search){
                return $query->where('posts.title','like',"%$search%");
            })
            ->whereNull(['votes.deleted_at','votes.product_id'])
            ->paginate($limit);
        if($request->ajax()){
            return view('admin.vote.post.data-table',['votes'=>$votes]);
        }
        return view('admin.vote.post.index',[
            'title' => 'Danh sách đánh giá',
            'votes' =>$votes,
        ]);
    }

    public function createVotePost()
    {
        \session(['module_active' => 'post',  'active' => 'Bài viết']);
        $this->authorize('createPost',Vote::class);
        $arrPost = DB::table('posts')->pluck('title','id');
        return view('admin.vote.post.create',[
            'arrPost' => $arrPost,
            'title' => 'Tạo đánh giá'
        ]);
    }

    public function storeVotePost(Request $request)
    {
        $this->authorize('createPost',Vote::class);
        $request->validate(
            [
                'comment' => 'required|min:10',
                'name_user' => 'required|max:300',
            ],
            [
                'comment.required' => 'Bình luận không được để trống.',
                'comment.min' => 'Bình luận có độ dài tối thiểu :min ký tự.',
                'name_user.required' => 'Người đánh giá không được để trống.',
                'name_user.max' => 'Người đánh giá có độ dài tối đa :max ký tự.',
            ]
        );
        $input = [
            'level' => $request->level == null ? 0 : $request->level,
            'comment' => $request->comment,
            'post_id'=> $request->post,
            'product_id'=> null,
            'name_user' => $request->name_user,
            'user_id'=> Auth::id(),
        ];
        try {
            DB::beginTransaction();
            Vote::create($input);
            DB::commit();
            return redirect()->route('vote.indexPost')->with('success','Tạo đánh giá bài viết mới thành công.');
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->route('vote.indexPost')->with('error','Đã có lỗi xảy ra. Vui lòng thử lại!');
        }
    }

    public function editVotePost($id)
    {
        \session(['module_active' => 'post',  'active' => 'Bài viết']);
        $this->authorize('updatePost',Vote::class);
        $vote = Vote::find($id);
        if (is_null($vote) || $vote->product_id != null){
            \abort(404);
        }else{
            $arrPost = DB::table('posts')->pluck('title','id');
            return view('admin.vote.post.edit',[
                'arrPost' => $arrPost,
                'vote' => $vote,
                'title' => 'Sửa đánh giá'
            ]);
        }
    }

    public function updateVotePost(Request $request, $id)
    {
        $this->authorize('updatePost',Vote::class);
        $request->validate(
            [
                'comment' => 'required|min:10',
                'name_user' => 'required|max:300',
            ],
            [
                'comment.required' => 'Bình luận không được để trống.',
                'comment.min' => 'Bình luận có độ dài tối thiểu :min ký tự.',
                'name_user.required' => 'Người đánh giá không được để trống.',
                'name_user.max' => 'Người đánh giá có độ dài tối đa :max ký tự.',
            ]
        );

        $vote = Vote::find($id);
        if (!is_null($vote) && is_null($vote->product_id)){
            $input = [
                'level' => $request->level == null ? 0 : $request->level,
                'comment' => $request->comment,
                'post_id'=> $request->post,
                'name_user' => $request->name_user,
                'user_id'=> Auth::id(),
            ];
            try {
                DB::beginTransaction();
                $vote->update($input);
                DB::commit();
                return redirect()->route('vote.indexPost')->with('success','Sửa đánh giá thành công.');
            }catch (\Exception $exception){
                DB::rollBack();
            }
        }
        return redirect()->route('vote.indexPost')->with('error','Đã có lỗi xảy ra. Vui lòng thử lại!');
    }

    public function destroyVotePost(Request $request)
    {
        $this->authorize('deletePost',Vote::class);
        $vote = Vote::find($request->id);
        if (!is_null($vote) && is_null($vote->product_id)){
            $vote->delete();
            return \json_encode(array('success'=>true));
        }
        return \json_encode(array('success'=>false));
    }

    /** Vote Product */
    public function indexVoteProduct(Request $request)
    {
        \session(['module_active' => 'products', 'active' => 'Sản phẩm']);
        $this->authorize('viewProduct',Vote::class);
        $search = $request->search;
        $limit = 10;
        if (!is_null($request->limit))
            $limit = $request->limit;
        $votes = DB::table('votes')
            ->select('votes.*','products.name as product_name')
            ->leftJoin('products','votes.product_id','=','products.id')
            ->when($search, function ($query, $search){
                return $query->where('products.name','like',"%$search%");
            })
            ->whereNull(['votes.deleted_at','votes.post_id'])
            ->paginate($limit);
        if($request->ajax()){
            return view('admin.vote.product.data-table',['votes'=>$votes]);
        }
        return view('admin.vote.product.index',[
            'title' => 'Danh sách đánh giá',
            'votes' =>$votes
        ]);
    }

    public function createVoteProduct()
    {
        \session(['module_active' => 'products', 'active' => 'Sản phẩm']);
        $this->authorize('createProduct',Vote::class);
        $arrProduct = DB::table('products')->pluck('name','id');
        return view('admin.vote.product.create',[
            'arrProduct' => $arrProduct,
            'title' => 'Tạo đánh giá'
        ]);
    }

    public function storeVoteProduct(Request $request)
    {
        $this->authorize('createProduct',Vote::class);
        $request->validate(
            [
                'comment' => 'required|min:10',
                'name_user' => 'required|max:300',
            ],
            [
                'comment.required' => 'Bình luận không được để trống.',
                'comment.min' => 'Bình luận có độ dài tối thiểu :min ký tự.',
                'name_user.required' => 'Người đánh giá không được để trống.',
                'name_user.max' => 'Người đánh giá có độ dài tối đa :max ký tự.',
            ]
        );
        $input = [
            'level' => $request->level == null ? 0 : $request->level,
            'comment' => $request->comment,
            'post_id'=> null,
            'product_id'=> $request->product,
            'name_user' => $request->name_user,
            'user_id'=> Auth::id(),
        ];
        try {
            DB::beginTransaction();
            Vote::create($input);
            DB::commit();
            return redirect()->route('vote.indexProduct')->with('success','Tạo đánh giá sản phẩm mới thành công.');
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->route('vote.indexProduct')->with('error','Đã có lỗi xảy ra. Vui lòng thử lại!');
        }
    }

    public function editVoteProduct($id)
    {
        \session(['module_active' => 'products', 'active' => 'Sản phẩm']);
        $this->authorize('updateProduct',Vote::class);
        $vote = Vote::find($id);
        if (is_null($vote) || $vote->post_id != null){
            \abort(404);
        }else{
            $arrProduct = DB::table('products')->pluck('name','id');
            return view('admin.vote.product.edit',[
                'arrProduct' => $arrProduct,
                'vote' => $vote,
                'title' => 'Sửa đánh giá'
            ]);
        }
    }

    public function updateVoteProduct(Request $request, $id)
    {
        $this->authorize('updateProduct',Vote::class);

        $request->validate(
            [
                'comment' => 'required|min:10',
                'name_user' => 'required|max:300',
            ],
            [
                'comment.required' => 'Bình luận không được để trống.',
                'comment.min' => 'Bình luận có độ dài tối thiểu :min ký tự.',
                'name_user.required' => 'Người đánh giá không được để trống.',
                'name_user.max' => 'Người đánh giá có độ dài tối đa :max ký tự.',
            ]
        );

        $vote = Vote::find($id);
        if (!is_null($vote) && is_null($vote->post_id)){
            $input = [
                'level' => $request->level == null ? 0 : $request->level,
                'comment' => $request->comment,
                'product_id'=> $request->product,
                'name_user' => $request->name_user,
                'user_id'=> Auth::id(),
            ];
            try {
                DB::beginTransaction();
                $vote->update($input);
                DB::commit();
                return redirect()->route('vote.indexProduct')->with('success','Sửa đánh giá sản phẩm thành công.');
            }catch (\Exception $exception){
                DB::rollBack();
            }
        }
        return redirect()->route('vote.indexProduct')->with('error','Đã có lỗi xảy ra. Vui lòng thử lại!');
    }

    public function destroyVoteProduct(Request $request)
    {
        $this->authorize('deleteProduct',Vote::class);
        $vote = Vote::find($request->id);
        if (!is_null($vote) && is_null($vote->post_id)){
            $vote->delete();
            return \json_encode(array('success'=>true));
        }
        return \json_encode(array('success'=>false));
    }
}
