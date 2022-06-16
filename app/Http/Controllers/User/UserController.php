<?php

namespace App\Http\Controllers\User;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {

    }

    public function info()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return \view('admin.user.info', \compact('user'));
    }

    public function edit()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return \view('admin.user.update', \compact('user'));
    }

    public function update(Request $request)
    {
        $id = $request->input('user_id');
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'address' => 'nullable|string|max:255',
                'phone_number' => ['nullable', 'regex:/^(0[5|7|8|9])([0-9]{8})$/'],
                'birthday' => 'nullable|date',
                'avatar' =>  'nullable|image|mimes:jpeg,jpg,png|mimetypes:image/jpeg,image/png,image/jpg|max:2048',
                'gender' => 'nullable',
                'role' => 'nullable',
            ],
            [
                'required' => ':attribute không được để trống!',
                'email' => ':attribute không đúng định dạng!',
                'max' => ':attribute có độ dài tối đa :max ký tự!',
                'unique' => ':attribute đã tồn tại trong hệ thống!',
                'image' => ':attribute không đúng định dạng! (jpg, jpeg, png)',
                'regex' => ':attribute không chính xác!'
            ],
            [
                'name' => 'Họ tên',
                'address' => 'Địa chỉ',
                'phone_number' => 'Số điện thoại',
                'birthday' => 'Ngày sinh',
                'avatar' => 'Ảnh đại diện',
                'gender' => 'Giới tính'
            ]
        );

        if ($request->hasFile('avatar')) {
            $thumb = $request->avatar;
            $name_avt = CommonHelper::convertTitleToSlug($request->name,'-').'-'.time().'.'.$thumb ->extension();
            $folder_upload = 'upload/images/user';
            CommonHelper::uploadImage($thumb, $name_avt, $folder_upload);
        }

        ($request->input('is_admin')) ? $is_admin = $request->input('is_admin') : $is_admin = NULL;  

        //Tạo mảng giá trị update
        $input = [
            'name' => $request->input('name'),
            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('address'),
            'gender' => $request->input('gender'),
            'birthday' => $request->input('birthday'),
            'is_admin' => $is_admin,
        ];
        //Kiểm tra xem có tồn tại input Role không để gán giá trị role vào mảng update
        if(isset($_POST['role'])){
            if($request->input('role') == 0){
                $input['role_id'] = NULL;
            }else{
                $role_id = $request->input('role');
                $input['role_id'] = $role_id;
            }
        }

        //2 trường hợp có thay đổi avatar và không thay đổi avatar,
        //Có: phải xóa avatar cũ
        if (!empty($name_avt)) {
            $input['avatar'] = $name_avt;
            $user = User::find($id);
            $avatar = $user->avatar;
            CommonHelper::deleteImage($avatar, '/upload/images/user/');
            if (User::where('id', $id)->update($input)) {
                return \back()->with('success', 'Bạn đã cập nhật tài khoản thành công!');
            } else {
                return \back()->withInput();
            }
        } else {
            if (User::where('id', $id)->update($input)) {
                return \back()->with('success', 'Bạn đã cập nhật tài khoản thành công!');
            } else {
                return \back()->withInput();
            }
        }
    }

    public function editPassword()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return \view('admin.user.edit-password', \compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $id = Auth::user()->id;
        $request->validate(
            [
                'pw_old' => 'required|string|min:8',
                'password' => ['required', 'string', 'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&]{8,255}$/', 'min:8', 'different:pw_old'],
                'password_confirmation' => 'required|same:password|min:8',
            ],
            [
                'required' => ':attribute không được để trống!',
                'min' => ':attribute có ít nhất 8 ký tự!',
                'same' => 'Mật khẩu nhập lại nhận không chính xác!',
                'different' => ':attribute không được giống mật khẩu cũ!',
                'regex' => ':attribute dài từ 8 ký trở lên, có ít nhất một chữ và một số!'
            ],
            [
                'pw_old' => 'Mật khẩu cũ',
                'password' => 'Mật khẩu mới',
                'password_confirmation' => 'Mật khẩu nhập lại',
            ]
        );
        $user = User::find($id);

        if (!(Hash::check($request->pw_old, $user->password))) {
            return \back()->withInput()->with('error', 'Mật khẩu cũ không chính xác!');
        } else {
            User::where('id', $id)->update(['password' => Hash::make($request->input('password'))]);
            return \redirect()->route('user.info')->with('success', 'Bạn đã thay đổi mật khẩu thành công!');
        }
    }
}
