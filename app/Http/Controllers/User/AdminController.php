<?php

namespace App\Http\Controllers\User;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            \session(['module_active' => 'user', 'active' => 'Nhân viên']);
            return $next($request);
        });
    }

    public function getCountStatus(){
        $count_total = User::all()->count();
        $count_admin = User::where('is_admin', 1)->count();
        $count_user = User::whereNull('is_admin')->count();
        $count_trash = User::onlyTrashed()->count();
        return [
            'count_total' => $count_total,
            'count_admin' => $count_admin,
            'count_user' => $count_user,
            'count_trash' => $count_trash
        ];
    }

    public function index(Request $request)
    {
        $this->authorize('view', User::class);
        $status = $request->input('status');
        if ($status == 'admin') {
            $users = User::where('is_admin', 1)->paginate(20);
            $users->withPath('?status=admin');
        } elseif ($status == 'user') {
            $users = User::whereNull('is_admin')->paginate(20);
            $users->withPath('?status=user');
        } elseif ($status == 'trash') {
            $users = User::onlyTrashed()->paginate(20);
            $users->withPath('?status=trash');
        } else {
            $keyword = "";
            if ($request->input('search')) {
                $keyword = $request->input('search');
            }
            $users = User::where('name', 'LIKE', "%{$keyword}%")->paginate(20);
        }
        $count = $this->getCountStatus();
        $roles = Role::all();
        $count_permission = Permission::all()->count();
        return \view('admin.user.index', \compact('users', 'count', 'roles', 'count_permission'));
    }

    public function create()
    {
        $this->authorize('create', User::class);
        $roles = Role::all();
        return \view('admin.user.create', \compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&]{8,255}$/', 'min:8', 'confirmed'],
                'address' => 'nullable|string|max:255',
                'phone_number' => ['nullable', 'regex:/^(0[5|7|8|9])([0-9]{8})$/'],
                'birthday' => 'nullable|date',
                'avatar' =>  'nullable|image|mimes:jpeg,jpg,png|mimetypes:image/jpeg,image/png,image/jpg|max:2048',
                'gender' => 'nullable',
                'role' => 'nullable',
            ],
            [
                'required' => ':attribute không được để trống!',
                'password.regex' => 'Mật khẩu dài từ 8 ký trở lên, có ít nhất một chữ và một số!',
                'confirmed' => ':attribute nhập lại không chính xác!',
                'unique' => ':attribute đã tồn tại trên hệ thống!',
                'image' => ':attribute không đúng định dạng! (jpg, jpeg, png)',
                'max' => ':attribute có độ dài tối đa :max ký tự!',
                'phone_number.regex' => 'Số điện thoại không chính xác!'
            ],
            [
                'name' => 'Họ tên',
                'email' => 'Email',
                'password' => 'Mật khẩu',
                'address' => 'Địa chỉ',
                'phone_number' => 'Số điện thoại',
                'birthday' => 'Ngày sinh',
                'avatar' => 'Ảnh đại diện',
                'gender' => 'Giới tính'
            ],
        );

        //ĐỔI TÊN ẢNH
        if ($request->hasFile('avatar')) {
            $thumb = $request->avatar;
            $name_avt = CommonHelper::convertTitleToSlug($request->name,'-').'-'.time().'.'.$thumb ->extension();
            $folder_upload = 'upload/images/user';
            CommonHelper::uploadImage($thumb, $name_avt, $folder_upload);
        }
        ($request->input('is_admin')) ? $is_admin = $request->input('is_admin') : $is_admin = NULL;
        ($request->input('role')) ? $role_id = $request->input('role') : $role_id = NULL;
        (!empty($name_avt)) ? $avatar =  $name_avt : $avatar = NULL;
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('address'),
            'gender' => $request->input('gender'),
            'birthday' => $request->input('birthday'),
            'avatar' => $avatar,
            'role_id' => $role_id,
            'is_admin' => $is_admin,
        ]);
        return \redirect()->route('user.list')->with('success', 'Thêm thành viên mới thành công!');
    }

    public function edit($id)
    {
        $this->authorize('update', User::class);
        $user = User::find($id);
        if($user != NULL){
            if($user->is_admin==1 && Auth::user()->is_admin != 1){
                return \abort(404);
            }else{
                $roles = Role::all();
                return \view('admin.user.update', \compact('user', 'roles'));
            }
        }else{
            return \abort(404);
        }

    }

    public function updatePassword(Request $request, $id)
    {
        $this->authorize('update', User::class);
        $request->validate(
            [
                'password' => ['required', 'string', 'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&]{8,255}$/', 'min:8'],
                'password_confirmation' => 'required|same:password|min:8',
            ],
            [
                'required' => ':attribute không được để trống!',
                'min' => ':attribute có ít nhất 8 ký tự!',
                'same' => 'Mật khẩu nhập lại nhận không chính xác!',
                'regex' => ':attribute dài từ 8 ký trở lên, có ít nhất một chữ và một số!'
            ],
            [
                'password' => 'Mật khẩu mới',
                'password_confirmation' => 'Mật khẩu nhập lại',
            ]
        );
        User::where('id', $id)->update(['password' => Hash::make($request->input('password'))]);
        return \back()->with('success', 'Bạn đã thay đổi mật khẩu thành công!');
    }

    public function delete(Request $request)
    {
        $this->authorize('delete', User::class);
        $data = $request->all();
        $id = $data['id'];
        User::find($id)->delete();
        $count = $this->getCountStatus();
        echo \json_encode($count);
    }

    public function restore(Request $request)
    {
        $this->authorize('delete', User::class);
        $data = $request->all();
        $id = $data['id'];
        User::withTrashed()->where('id', $id)->restore();
        $count = $this->getCountStatus();
        echo \json_encode($count);
    }

    public function forceDelete(Request $request)
    {
        $this->authorize('delete', User::class);
        $data = $request->all();
        $id = $data['id'];

        try {
            DB::beginTransaction();
            $user = User::withTrashed()->where('id', $id)->first();
            $avatar = $user->avatar;
            File::delete(\public_path('/upload/images/user/' . $avatar));
            User::withTrashed()->where('id', $id)->forceDelete();
            DB::commit();
            $count_trash = User::onlyTrashed()->count();
            $count = [
                'count_trash' => $count_trash,
            ];
            echo \json_encode($count);
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

}
