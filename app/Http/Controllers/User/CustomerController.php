<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helpers\CommonHelper;
class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            \session(['module_active' => 'customer', 'active' => 'Khách hàng']);
            return $next($request);
        });
    }

    public function getCountStatus(){
        $count_total = Customer::all()->count();
        $count_trash = Customer::onlyTrashed()->count();
        return [
            'count_total' => $count_total,
            'count_trash' => $count_trash
        ];
    }

    public function index(Request $request)
    {
        $this->authorize('view', Customer::class);
        $status = $request->input('status');
        if ($status == 'trash') {
            $customers = Customer::onlyTrashed()->orderByDesc('id')->paginate(20);
            $customers->withPath('?status=trash');
        } else {
            $keyword = "";
            if ($request->input('search')) {
                $keyword = $request->input('search');
            }
            $customers = Customer::where('name', 'LIKE', "%{$keyword}%")
            ->orwhere('email', 'LIKE', "%{$keyword}%")
            ->orderByDesc('id')->paginate(20);
        }
        $count = $this->getCountStatus();
        return \view('admin.customer.index', \compact('customers', 'count'));
    }

    public function create()
    {
        $this->authorize('create', Customer::class);
        return \view('admin.customer.create');
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

        //Gán giá trị cho avatar trong 2 trường hợp
        if(!empty($name_avt)){
            $avatar =  $name_avt;
        }else{
            $avatar = NULL;
        }

        Customer::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('address'),
            'gender' => $request->input('gender'),
            'birthday' => $request->input('birthday'),
            'avatar' => $avatar,
        ]);
        return \redirect()->route('customer.list')->with('success', 'Thêm thành viên mới thành công!');
    }

    public function edit($id)
    {
        $this->authorize('update', Customer::class);
        $customer = Customer::find($id);
        if($customer != NULL){
            return \view('admin.customer.update', \compact('customer'));
        }else{
            return \abort(404);
        }
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

        //Tạo mảng giá trị update
        $input = [
            'name' => $request->input('name'),
            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('address'),
            'gender' => $request->input('gender'),
            'birthday' => $request->input('birthday'),
        ];

        //2 trường hợp có thay đổi avatar và không thay đổi avatar,
        //Có: phải xóa avatar cũ
        if (!empty($name_avt)) {
            $input['avatar'] = $name_avt;
            $user = Customer::find($id);
            $avatar = $user->avatar;
            CommonHelper::deleteImage($avatar, '/upload/images/user/');
            if (Customer::where('id', $id)->update($input)) {
                return \back()->with('success', 'Bạn đã cập nhật tài khoản thành công!');
            } else {
                return \back()->withInput();
            }
        } else {
            if (Customer::where('id', $id)->update($input)) {
                return \back()->with('success', 'Bạn đã cập nhật tài khoản thành công!');
            } else {
                return \back()->withInput();
            }
        }
    }

    public function updatePassword(Request $request, $id)
    {
        $this->authorize('update', Customer::class);
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
        Customer::where('id', $id)->update(['password' => Hash::make($request->input('password'))]);
        return \back()->with('success', 'Bạn đã thay đổi mật khẩu thành công!');
    }

    public function delete(Request $request)
    {
        $this->authorize('delete', Customer::class);
        $data = $request->all();
        $id = $data['id'];
        Customer::find($id)->delete();
        $count = $this->getCountStatus();
        echo \json_encode($count);
    }

    public function restore(Request $request)
    {
        $this->authorize('delete', Customer::class);
        $data = $request->all();
        $id = $data['id'];
        Customer::withTrashed()->where('id', $id)->restore();
        $count = $this->getCountStatus();
        echo \json_encode($count);
    }

    public function forceDelete(Request $request)
    {
        $this->authorize('delete', Customer::class);
        $data = $request->all();
        $id = $data['id'];

        try {
            DB::beginTransaction();
            $customer = Customer::withTrashed()->where('id', $id)->first();
            $avatar = $customer->avatar;
            CommonHelper::deleteImage($avatar, '/upload/images/user/');
            Customer::withTrashed()->where('id', $id)->forceDelete();
            DB::commit();
            $count_trash = Customer::onlyTrashed()->count();
            $count = [
                'count_trash' => $count_trash
            ];
            echo \json_encode($count);
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}
