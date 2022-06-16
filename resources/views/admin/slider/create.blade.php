@extends('admin.layouts.main')
@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{$title}}
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            @can('view',\App\Models\Slider::class)
                <a class="btn btn-primary shadow-md mr-2" href="{{route('slider.index')}}">Danh sách Slider</a>
            @endcan
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12">

            <form action="{{route('slider.store')}}" method="post" enctype="multipart/form-data" id="form-slider">
                <div class="intro-y box p-5">
                    <div>
                        <label for="crud-form-1" class="form-label">Tiêu đề</label>
                        <input id="crud-form-1" type="text" name="name" value="{{old('name')}}" class="form-control w-full" placeholder="Nhập tiêu đề">
                    </div>
                    <div class="mt-3">
                        <label for="crud-form-1" class="form-label">Link</label>
                        <input id="crud-form-1" type="text" name="link_target" value="{{old('link_target')}}" class="form-control w-full" placeholder="Nhập đường dẫn">
                    </div>

                    <div class="mt-3">
                        <div class="grid grid-cols-12 gap-x-5">
                            <div class="col-span-12 xl:col-span-4">
                                <label for="crud-form-2" class="form-label">Vị trí hiển thị</label>
                                <select name="location" data-placeholder="Chọn vị trí hiển thị" class="tom-select w-full" id="crud-form-2">
                                    @foreach($arrLocation as $index => $item)
                                        <option value="{{$index}}"
                                            {{ (old('location') == $index) ? 'selected': false }}
                                        >{{$item}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-12 xl:col-span-4">
                                <label for="crud-form-2" class="form-label">Thứ tự hiển thị(<span class="text-red-600">*</span>)</label>
                                <input id="crud-form-2" type="number" name="position" value="{{old('position')}}" min="1" class="form-control w-full" placeholder="Nhập thứ tự">
                                @error('position')
                                <span style="color:red">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-span-12 xl:col-span-4">
                                <label>Trạng thái</label>
                                <div class="mt-2">
                                    <input type="checkbox" {{old('status') == 'on' ? 'checked' : false}} name="status" class="form-check-switch">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label>Ảnh Slider</label>
                        <div class="mt-2">
                            <div class="w-40 show-image"></div>
                            <input name="image" type="file" class="mt-2" id="file-images"/>
                            @error('image')
                            <span style="color:red">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="text-right mt-5">
                        @can('view',\App\Models\Slider::class)
                            <a type="button" href="{{route('slider.index')}}" class="btn btn-outline-secondary w-24 mr-1">Hủy</a>
                        @endcan
                        <button type="submit" class="btn btn-primary w-24">Lưu</button>
                    </div>
                    @csrf
                </div>
            </form>
            <!-- END: Form Layout -->
        </div>
    </div>
@endsection

