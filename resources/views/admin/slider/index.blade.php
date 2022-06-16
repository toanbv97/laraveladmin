@extends('admin.layouts.main')
@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{$title}}
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5" id="data-table">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            @can('create',\App\Models\Slider::class)
                <a href="{{route('slider.create')}}" class="btn btn-primary shadow-md mr-2">Tạo Slider</a>
            @endcan
            <div class="hidden md:block mx-auto text-gray-600"></div>
            <form id="searchform" name="searchform" action="{{ route('slider.index')}}" class="flex flex-col sm:flex-row sm:items-end xl:items-start" onsubmit="return false">
                <select name="location" class="form-select select-search sm:w-32 2xl:w-full mt-2 sm:mt-0 sm:w-auto box mr-3">
                    <option value="">--Tất cả--</option>
                    @foreach(\App\Models\Slider::$arr_location as $index => $item)
                        <option value="{{$index}}">{{$item}}</option>
                    @endforeach
                </select>
                <div class="sm:w-42 2xl:w-full mt-2 sm:mt-0 sm:w-auto box">
                    <div class="w-full relative text-gray-700 dark:text-gray-300">
                        <input type="text" class="form-control w-56 box pr-10 placeholder-theme-13" id="search" name="search" value="{{request()->search}}" placeholder="Tìm kiếm...">
                        <a class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" href="{{route('slider.index')}}" id='search_btn'><i class="absolute my-auto inset-y-0 right-0" data-feather="search"></i></a>
                    </div>
                </div>
            </form>
        </div>
        @include("admin.slider.data-table",["sliders"=>$sliders])
    </div>

    <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <form method="POST">
                        <input type="hidden" name="id" id="delete_id">
                        <div class="p-5 text-center">
                            <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                            <div class="text-3xl mt-5">Bạn muốn xoá Slider này?</div>
                            <div class="text-gray-600 mt-2">
                                Lưu ý: Quá trình này sẽ không thể hoàn tác.
                            </div>
                        </div>
                        <div class="px-5 pb-8 text-center">
                            <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Quay lại</button>
                            <button type="button" data-dismiss="modal"
                                    class="delete btn btn-danger w-24">Thực
                                hiện</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {

            $('.delete').click(function() {
                var id = $("#delete_id").val();
                var _token = $('meta[name="csrf-token"]').attr('content');
                var data = {
                    id: id,
                    _token: _token
                };
                $.ajax({
                    url: "{{ route('slider.delete') }}",
                    method: "POST",
                    data: data,
                    dataType: "json",
                    success: function(data) {
                        $('#' + id).remove();
                    }
                });
            });
        });
    </script>
    <script src="{{ asset('/js/slider-index.js') }}"></script>
@endsection


