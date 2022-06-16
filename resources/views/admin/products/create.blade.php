@extends('admin.layouts.main')
@section('css')
    <script src="{{ asset('lib/tinymce/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
@endsection
@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{$title}}
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            @can('viewAny',App\Models\Products::class)
                <a class="btn btn-primary shadow-md mr-2" href="{{route('products.index')}}">Danh sách sản phẩm</a>
            @endcan
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12">
            <!-- BEGIN: Form Layout -->
            <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data" id="form-post">
                <div class="intro-y box p-5">
                    <div>
                        <label for="crud-form-1" class="form-label">Tên sản phẩm(<span class="text-red-600">*</span>)</label>
                        <input id="crud-form-1" type="text" name="name" value="{{old('name')}}" class="form-control w-full">
                        @error('name')
                        <span style="color:red">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                     <label>Trạng thái</label> <br>
                     <input type="checkbox" name='status' checked="checked" class="form-check-switch">
                     </div>
                    <div class="mt-3">
                        <div class="grid grid-cols-12 gap-x-5">
                        <div class="col-span-12 xl:col-span-4">
                        <label>Ảnh sản phẩm</label><br>
                       <div class="px-4 pb-4 flex items-center cursor-pointer relative">
                        <i data-feather="image" class="w-4 h-4 mr-2"></i>
                        <span class="text-theme-1 dark:text-theme-10 mr-1">Upload ảnh</span>
                        <input name='thumb' type="file" class="w-56 h-56 top-0 left-0 absolute opacity-0" id="fileupload2" />
                        {{-- @include('admin.products.cropimg') --}}
                        </div>
                        <div class="border-2 border-dashed dark:border-dark-5 rounded-md p-2">
                            <div class="flex flex-wrap px-4 w-full">
                            <div id="dvPreview2">         
                            @error('thumb')
                                <span style="color:red">{{$message}}</span>
                            @enderror
                            </div>
                            </div>
                        </div>
                        </div>

                            <div class="col-span-12 xl:col-span-7 ">
                        <label>Ảnh giới thiệu sản phẩm</label><br>
                        <div class="px-4 pb-4 flex items-center cursor-pointer relative">
                                <i data-feather="image" class="w-4 h-4 mr-2"></i> 
                                <span class="text-theme-1 dark:text-theme-10 mr-1">Upload ảnh</span>
                                <input type="file" class="w-full h-full top-0 left-0 absolute opacity-0" name="image[]" multiple id="fileupload">
                        </div>
                        <div class="border-2 border-dashed dark:border-dark-5 rounded-md p-2">
                            <div class="flex flex-wrap px-4 w-full">
                                <div class="mt-2 ">
                                <div id="dvPreview" >
                                </div>
                                @error('thumb')
                                    <span style="color:red">{{$message}}</span>
                                @enderror
                                </div>

                            </div>
                            </div>
                            
                        </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label>Giá bán</label>
                        <div class="mt-2">
                            <input type="int-number" class="form-control" id="tiente"  name="price" >
                        </div>
                    </div>
                    <div class="mt-3">
                        <label>Số lượng</label>
                        <div class="mt-2">
                            <input type="int-number" class="form-control" id="soluong" name="quantity" >
                        </div>
                    </div>
                    <div class="mt-3">
                        <label>Nội dung</label>
                        <div class="mt-2">
                            <textarea name="content" id="tiny-editor" rows="7">{{old('content')}}</textarea>
                        </div>
                    </div>
                    <div class="text-right mt-5">
                        @can('viewAny',App\Models\Products::class)
                            <a type="button" href="{{route('products.index')}}" class="btn btn-outline-secondary w-24 mr-1">Hủy</a>
                        @endcan
                        @can('update',App\Models\Products::class)
                            <button type="submit" class="btn btn-primary w-24">Lưu</button>
                        @endcan
                    </div>
                    @csrf
                </div>
            </form>
            <!-- END: Form Layout -->
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/post-form.js') }}"></script>
@endsection
