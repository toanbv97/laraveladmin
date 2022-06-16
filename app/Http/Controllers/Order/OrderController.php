<?php

namespace App\Http\Controllers\Order;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            \session(['module_active' => 'order', 'active'=>'Đơn hàng']);
            return $next($request);
        });
    }

    public function getCountStatus(){
        $count_total = Order::all()->count();
        $count_processing = Order::where('status', 1)->count();
        $count_packed = Order::where('status', 2)->count();
        $count_shipping = Order::where('status', 3)->count();
        $count_done = Order::where('status', 4)->count();
        $count_cancelled = Order::where('status', 5)->count();
        $count_trash = Order::onlyTrashed()->count();
        return [
            'count_total' => $count_total,
            'count_processing' => $count_processing,
            'count_packed' => $count_packed,
            'count_shipping' => $count_shipping,
            'count_done' => $count_done,
            'count_cancelled' => $count_cancelled,
            'count_trash' => $count_trash,
        ];
    }

    public function index(Request $request)
    {
        $this->authorize('view', Order::class);
        $status = $request->input('status');
        if ($status == 'processing') {
            $orders = Order::where('status', 1)->orderByDesc('id')->paginate(20);
            $orders->withPath('?status=processing');
        } elseif ($status == 'packed') {
            $orders = Order::where('status', 2)->orderByDesc('id')->paginate(20);
            $orders->withPath('?status=packed');
        } elseif ($status == 'shipping') {
            $orders = Order::where('status', 3)->orderByDesc('id')->paginate(20);
            $orders->withPath('?status=shipping');
        } elseif ($status == 'done') {
            $orders = Order::where('status', 4)->orderByDesc('id')->paginate(20);
            $orders->withPath('?status=done');
        } elseif ($status == 'cancelled') {
            $orders = Order::where('status', 5)->orderByDesc('id')->paginate(20);
            $orders->withPath('?status=cancelled');
        } elseif ($status == 'trash') {
            $orders = Order::onlyTrashed()->orderByDesc('id')->paginate(20);
            $orders->withPath('?status=trash');
        } else {
            $keyword = "";
            if ($request->input('search')) {
                $keyword = $request->input('search');
            }
            $orders = Order::where('id', 'LIKE', "%{$keyword}%")->orwhere('customer_name', 'LIKE', "%{$keyword}%")
                ->orwhere('phone_number', 'LIKE', "%{$keyword}%")
                ->orderByDesc('id')->paginate(20);
        }
        $products = Products::withTrashed()->get();
        $count = $this->getCountStatus();
        return \view('admin.order.index', \compact('orders', 'count', 'products'));
    }

    public function edit($id){
        $this->authorize('show', Order::class);
        $order = Order::find($id);
        $products = Products::withTrashed()->get();
        if($order != NULL){
            return \view('admin.order.update', \compact('order', 'products'));
        }else{
            return \abort(404);
        }

    }

    public function updateCustomer(Request $request){
        $this->authorize('update', Order::class);
        $request->validate(
            [
                'customer_name' => 'required|string|max:255',
                'phone_number' => ['required', 'regex:/^(0[5|7|8|9])([0-9]{8})$/'],
                'address' => 'required|string|max:255',
            ],
            [
                'required' => ':attribute không được để trống!',
                'max' => ':attribute có độ dài tối đa :max ký tự!',
                'phone_number.regex' => 'Số điện thoại không chính xác!',
            ],
            [
                'customer_name' => 'Tên khách hàng',
                'phone_number' => 'Số điện thoại',
                'address' => 'Địa chỉ',
            ]
        );
        $input = [
            'customer_name' => $request->input('customer_name'),
            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('address'),
        ];
        $id = $request->input('order_id');
        Order::where('id', $id)->update($input);
        return \redirect()->route('order.edit', $id)->with('success', 'Cập nhật đơn hàng thành công!');
    }

    public function update(Request $request){
        $this->authorize('update', Order::class);
        $id = $request->input('order_id');
        Order::where('id', $id)->update(['status' => $request->input('status')]);
        return \back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }

    public function updateAjax(Request $request){
        $data = $request->all();
        $status = $data['status'];
        $id = $data['order_id'];
        Order::where('id', $id)->update(['status' => $status]);
        $html_status="";
        if($status==1){
            $html_status.=' <span class="inline-block bg-red-600 text-white rounded-lg px-1.5">Chờ xử lý</span>';
        }elseif($status==2){
            $html_status.='<span class="inline-block bg-yellow-600 text-white rounded-lg px-1.5">Đã đóng gói</span>';
        }elseif($status==3){
            $html_status.='<span class="inline-block bg-blue-600 text-white rounded-lg px-1.5">Đang vận chuyển</span>';
        }elseif($status==4){
            $html_status.='<span class="inline-block bg-green-600 text-white rounded-lg px-1.5">Hoàn thành</span>';
        }elseif($status==5){
            $html_status.='<span class="inline-block bg-gray-600 text-white rounded-lg px-1.5">Đã huỷ</span>';
        }
        $count = $this->getCountStatus();
        $count['html_status'] = $html_status;
        echo \json_encode($count);
    }

    public function delete(Request $request)
    {
        $this->authorize('delete', Order::class);
        $data = $request->all();
        $id = $data['id'];
        Order::find($id)->delete();
        $count = $this->getCountStatus();
        echo \json_encode($count);
    }

    public function restore(Request $request)
    {
        $this->authorize('delete', Order::class);
        $data = $request->all();
        $id = $data['id'];
        Order::withTrashed()->where('id', $id)->restore();
        $count = $this->getCountStatus();
        echo \json_encode($count);
    }

    public function forceDelete(Request $request)
    {
        $this->authorize('delete', Order::class);
        $data = $request->all();
        $id = $data['id'];
        Order::withTrashed()->where('id', $id)->forceDelete();
        $count_trash = Order::onlyTrashed()->count();
        $count = [
            'count_trash' => $count_trash
        ];
        echo \json_encode($count);
    }
}
