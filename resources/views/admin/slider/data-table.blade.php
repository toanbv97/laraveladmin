<!-- BEGIN: Data List -->
<div class="intro-y col-span-12 overflow-auto lg:overflow-visible" id="data">
    <table class="table table-report -mt-2" id="myTable">
        <thead>
        <tr>
            <th class="text-center whitespace-nowrap">Hình ảnh</th>
            <th class="whitespace-nowrap">Tiêu đề</th>
            <th class="whitespace-nowrap">Link</th>
            <th class="text-center whitespace-nowrap">Vị trí</th>
            <th class="text-center whitespace-nowrap">Thứ tự</th>
            <th class="text-center whitespace-nowrap">Trạng thái</th>
            <th class="text-center whitespace-nowrap">Chức năng</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sliders as $slider)
            <tr class="intro-x" id="{{$slider->id}}">
                <td class="w-40">
                    @if($slider->image == \App\Models\Slider::IMAGE)
                        <img src="{{asset('/upload/images/common_img/').'/'.$slider->image}}">
                    @else
                        <img src="{{asset('/upload/images/slider').'/'.$slider->image}}">
                    @endif
                </td>
                <td class="w-52">
                    <div class="font-medium">{{$slider->name}}</div>
                </td>
                <td class="w-40">
                    <div class="font-medium ">{{$slider->link_target}}</div>
                </td>
                <td class="w-10">
                    <div class="text-center">{{\App\Models\Slider::$arr_location[$slider->location]}}</div>
                </td>
                <td class="w-10">
                    <div class="text-center">{{$slider->position}}</div>
                </td>
                <td class="w-10">
                    @if($slider->status == \App\Models\Slider::ACTIVE)
                        <div class="text-theme-9 text-center"> <i class="fa-regular fa-circle-check"></i></div>
                    @else
                        <div class="text-theme-6 text-center"> <i class="fa-solid fa-ban"></i></div>
                    @endif
                </td>
                <td class="table-report__action w-40">
                    <div class="flex justify-center items-center">
                        @can('update',\App\Models\Slider::class)
                            <a href="{{route('slider.edit',['id'=>$slider->id])}}" title="Chỉnh sửa"
                               class="btn btn-sm btn-primary mr-2">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        @endcan
                        @can('delete',\App\Models\Slider::class)
                            <a href="javascript:;" title="Xóa" data-toggle="modal"
                               data-value="{{$slider->id}}"
                               data-target="#delete-confirmation-modal"
                               class="btn btn-danger py-1 px-2 btn-delete"><i class="fa-solid fa-trash-can"
                                                                              style="padding: 1px"></i>
                            </a>
                        @endcan
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- BEGIN: Pagination -->
<div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center" id="pagi">
    {!! $sliders->links('admin.layouts.pagination') !!}
    <form action="{{route('slider.index')}}" id="form-limit">
        <select id="limit" name="limit" class="w-20 form-select box mt-3 sm:mt-0">
            <option value="10" {{request()->limit =='10' ? 'selected' : ''}}>10</option>
            <option value="25" {{request()->limit =='25' ? 'selected' : ''}}>25</option>
            <option value="35" {{request()->limit =='35' ? 'selected' : ''}}>35</option>
            <option value="50" {{request()->limit =='50' ? 'selected' : ''}}>50</option>
        </select>
    </form>

</div>
<!-- END: Pagination -->
