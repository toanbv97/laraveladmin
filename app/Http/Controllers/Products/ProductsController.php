<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Image;
use Yajra\DataTables\DataTables;
use App\Helpers\CommonHelper;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            \session(['module_active' => 'products',  'active' => 'Sản phẩm']);
            return $next($request);
        });
    }


    public function index(Request $request)
    {
        $this->authorize('viewAny', Products::class);
        $limit =  $request->query('limit');
        $keywords =  $request->query('search');
        $orderby =  $request->query('orderby');
        $desc_asc = 'ASC';
        if ($limit == null) {
            $limit = 10;
        }
        if ($keywords == null) {
            $keywords = "";
        }
        if ($orderby == null) {
            $orderby = "id";
        }
        if ($limit == 10 && $keywords == "" && $orderby == "id") {
            $Products = Products::paginate($limit);
        } else
            $Products = Products::where('name', 'like', '%' . $keywords . '%')->orderby($orderby, $desc_asc)->Paginate($limit);
        return view('admin.products.index', [
            'products' => $Products,
            'title' => 'Sản phẩm',
        ]);
    }

    public function create()
    {
        $this->authorize('create', Products::class);
        return view('admin.products.create', [
            'title' => 'Thêm sản phẩm'
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('update', Products::class);
        $request->validate(
            [
                'name' => 'required|max:300|unique:products',
                'thumb' => 'image|mimes:jpeg,jpg,png|mimetypes:image/jpeg,image/png,image/jpg|max:5048'
            ],
            [
                'name.required' => 'Tên sản phẩm không được để bỏ trống.',
                'name.max' => 'Tên sản phẩm có độ dài tối đa :max ký tự.',
                'name.unique' => 'Tên sản phẩm đã tồn tại trong hệ thống',
                'thumb.image' => 'Ảnh đại diện không đúng định dạng! (jpg, jpeg, png)',
            ]
        );

        $status = Products::ACTIVE;
        $nameFile = Products::IMAGE;
        if ($request->status == null)
            $status = Products::DISABLE;
        if ($request->thumb != null)
            $nameFile = CommonHelper::convertTitleToSlug($request->name, '-') . '-' . time() . '.' . $request->thumb->extension();
        //xu ly tien te va so luong
        $request->price =  preg_replace('/[^A-Za-z0-9\-]/', '', $request->price);
        $request->quantity =  preg_replace('/[^A-Za-z0-9\-]/', '', $request->quantity);
        if( $request->price == "") $request->price = 0;
        if( $request->quantity == "") $request->quantity = 0;

        $imgs = $this->saveimg($request, '');

        if ($imgs === "null"){ $imgs = 'no-images.jpg'; }


        $Product = [
            'name' => $request->name,
            'slug' => CommonHelper::convertTitleToSlug($request->name, '-'),
            'price' => $request->price,
            'quantity' => $request->quantity,
            'content' => $request->content,
            'thumb' => $nameFile,
            'status' => $status,
            'user_id' => Auth::id(),
            'image' => $imgs,
        ];


        try {
            DB::beginTransaction();

            Products::create($Product);

            // xu ly anh khong bi vo anh
            if ($request->thumb != null) {
                $folder_thumb = 'upload/images/products/thumb/';
                $folder_medium = 'upload/images/products/medium/';
                $folder_larage = 'upload/images/products/larage/';
                CommonHelper::cropImage2($request->thumb, $nameFile, 150, 150, $folder_thumb);
                CommonHelper::cropImage2($request->thumb, $nameFile, 300, 300, $folder_medium);
                CommonHelper::cropImage2($request->thumb, $nameFile, 600, 600, $folder_larage);
                $folder = 'upload/images/products';
                CommonHelper::uploadImage($request->thumb, $nameFile, $folder);
            }
            DB::commit();
            return redirect()->route('products.index')->with('success', 'Thêm sản phẩm mới thành công.');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->route('products.index')->with('error', 'Đã có lỗi xảy ra. Vui lòng thử lại!');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $this->authorize('update', Products::class);
        $edit = Products::find($id);
        $img = json_decode($edit->image);

        if ($edit !== null) {
            return view('admin.products.edit', [
                'title' => 'Sửa sản phẩm',
                'edit' => $edit,
                'img' => $img,
            ]);
        } else {
            \abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update', Products::class);
        $request->validate(
            [
                'name' => 'required|max:300|unique:products,name,' . $id . ',id',
                'thumb' => 'image|mimes:jpeg,jpg,png|mimetypes:image/jpeg,image/png,image/jpg|max:5048',
            ],
            [
                'name.required' => 'Tên sản phẩm không được để bỏ trống.',
                'name.max' => 'Tên sản phẩm có độ dài tối đa :max ký tự.',
                'name.unique' => 'Tên sản phẩm đã tồn tại trong hệ thống',
                'thumb.image' => 'Ảnh đại diện không đúng định dạng! (jpg, jpeg, png)',
            ]
        );
        $Products = Products::find($id);

        if (!is_null($Products)) {
            $status = Products::ACTIVE;
            $nameFile = Products::IMAGE;
            $nameFileOld = $Products->thumb;
            if ($request->status == null)
                $status = Products::DISABLE;
            if ($request->thumb != null)
                $nameFile = CommonHelper::convertTitleToSlug($request->name, '-') . '-' . time() . '.' . $request->thumb->extension();
            else $nameFile = $nameFileOld;

            $request->price =  preg_replace('/[^A-Za-z0-9\-]/', '', $request->price);
            $request->quantity =  preg_replace('/[^A-Za-z0-9\-]/', '', $request->quantity);
            if( $request->price == "") $request->price = 0;
            if( $request->quantity == "") $request->quantity = 0;

            // xu ly anh abum
            $oldimage = $Products->image;
            if ($request->image == null){
                $imgs = $oldimage;
            } else{
                $imgs = $this->saveimg($request, $oldimage);
            }
            $Product = [
                'name' => $request->name,
                'slug' => CommonHelper::convertTitleToSlug($request->name, '-'),
                'price' => $request->price,
                'quantity' => $request->quantity,
                'content' => $request->content,
                'thumb' => $nameFile,
                'status' => $status,
                'user_id' => Auth::id(),
                'image' => $imgs,
            ];

            try {
                DB::beginTransaction();


                Products::where('id', $id)->update($Product);

                // xu ly anh khong bi vo anh
                if ($request->thumb != null) {
                    $folder_thumb = 'upload/images/products/thumb/';
                    $folder_medium = 'upload/images/products/medium/';
                    $folder_larage = 'upload/images/products/larage/';
                    CommonHelper::cropImage2($request->thumb, $nameFile, 150, 150, $folder_thumb);
                    CommonHelper::cropImage2($request->thumb, $nameFile, 300, 300, $folder_medium);
                    CommonHelper::cropImage2($request->thumb, $nameFile, 600, 600, $folder_larage);
                    $folder = 'upload/images/products';
                    CommonHelper::uploadImage($request->thumb, $nameFile, $folder);

                    //Xoá ảnh cũ khi có upload ảnh mới
                    if ($nameFileOld != Products::IMAGE && $nameFile != Products::IMAGE) {
                        $path = 'upload/images/products/';
                        $path_thumb = 'upload/images/products/thumb/';
                        $path_medium = 'upload/images/products/medium/';
                        $path_larage = 'upload/images/products/larage/';
                        CommonHelper::deleteImage($nameFileOld, $path);
                        CommonHelper::deleteImage($nameFileOld, $path_thumb);
                        CommonHelper::deleteImage($nameFileOld, $path_medium);
                        CommonHelper::deleteImage($nameFileOld, $path_larage);
                    }
                }
                DB::commit();
                return redirect()->route('products.index')->with('success', 'Sửa sản phẩm mới thành công.');
            } catch (\Exception $exception) {
                DB::rollBack();
                return redirect()->route('products.index')->with('error', 'Đã có lỗi xảy ra. Vui lòng thử lại!');
            }
        } else \abort(404);
    }


    public function saveimg($request, $oldimage)
    {
        $image = \json_decode($oldimage);
        if ($files = $request->file('image')) {
            foreach ($files as $file) {

                $image_name = md5(rand(1000, 10000));
                $ext =  strtolower($file->getClientOriginalExtension());

                $image_full_name = $image_name . '.' . $ext;
                $upload_path = 'upload/images/products/';
                $image_url = $upload_path . $image_full_name;
                $file->move($upload_path, $image_full_name);
                $image[] = $image_full_name;
            }
        }
        return json_encode($image);
    }

    // public function deleteoldimage($oldimage)
    // {

    //     $images = json_decode($oldimage);
    //     if ($files = $images) {
    //         foreach ($files as $file) {
    //             File::delete('upload/images/products/' . $file);
    //         }
    //     }
    // }

    public function destroy(Request $request)
    {
        $this->authorize('delete', Products::class);
        $Products = Products::find($request->id);
        if (!is_null($Products)) {
            $Products->delete();
            return \json_encode(array('success' => true));
        }
    }

    public function deleteImgAjax(Request $request)
    {
        $data = $request->all();
        $id = $data['product_id'];
        $image = $data['img'];
        $images = \json_decode(Products::find($id)->image);
        $db = array();
        foreach ($images as $k) {
            if ($image != $k) {
                $db[] = $k;
            } else {
                File::delete('upload/images/products/' . $k);
            }
        }
        if (empty($db)) {
            $input = 'no-image.jpg';
        } else {
            $input =  json_encode($db);
        }
        Products::where('id', $id)->update(['image' => $input]);
        return \json_encode(array('success' => \true));
    }
    // static $name_image;
    // public function uploadCropImage(Request $request)
    // {
    //     // $folderPath = public_path('upload/');

    //     $image_parts = explode(";base64,", $request->image);
    //     // $image_type_aux = explode("image/", $image_parts[0]);
    //     // $image_type = $image_type_aux[1];
    //     $image_base64 = base64_decode($image_parts[1]);

    //     $imageName = uniqid() . '.png';

    //     $name_image =  $imageName;

    //     dd($imageName);
    //     // $imageFullPath = $folderPath.$imageName;

    //     // file_put_contents($imageFullPath, $image_base64);

    //     //  $saveFile = new Picture;
    //     //  $saveFile->name = $imageName;
    //     //  $saveFile->save();

    //     return response()->json(['success'=>'Crop Image Uploaded Successfully']);
    // }
}
