@extends('admin.layouts.main')
@section('category')
    @csrf
    <!-- BEGIN: Content -->
    <div class="content">

        <h2 class="intro-y text-lg font-medium mt-10">
            <a href="{{ route('category.index')}}">{{ $title}}</a>
        </h2>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                @can('create',App\Models\Category::class)
                    <a class="btn btn-primary shadow-md mr-2" href="{{ route('category.create')}}" data-toggle="modal" data-target="#add-confirmation-modal">Thêm danh mục</a>
                @endcan
                <div class="dropdown">
                    <button class="dropdown-toggle btn px-2 box text-gray-700 dark:text-gray-300" aria-expanded="false">
                        <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="plus"></i> </span>
                    </button>
                    <div class="dropdown-menu w-40">
                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                            <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="printer" class="w-4 h-4 mr-2"></i> Print </a>
                            <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to Excel </a>
                            <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to PDF </a>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block mx-auto text-gray-600"></div>
                <div class="hidden md:block mx-auto text-gray-600"></div>
                <form  action="{{ route('category.index')}}" method="get" class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                    <select id="limit" name="limit" class="form-select  sm:w-32 2xl:w-full mt-2 sm:mt-0 sm:w-auto box mr-3"
                            onchange="this.form.submit()"
                    >
                        <option value="10" {{request()->input('limit') =='10' ? 'selected' : ''}}>10</option>
                        <option value="25" {{request()->input('limit') =='25' ? 'selected' : ''}}>25</option>
                        <option value="35" {{request()->input('limit') =='35' ? 'selected' : ''}}>35</option>
                        <option value="50" {{request()->input('limit') =='50' ? 'selected' : ''}}>50</option>
                    </select>
                    <select id="orderby" name="orderby" class="form-select  sm:w-32 2xl:w-full mt-2 sm:mt-0 sm:w-auto box mr-3" onchange="this.form.submit()">
                        <option value="id" {{request()->input('orderby') =='id' ? 'selected' : ''}} >STT</option>
                        <option value="name" {{request()->input('orderby') =='name' ? 'selected' : ''}} >Tên danh mục</option>
                        <option value="parent_id" {{request()->input('orderby') =='parent_id' ? 'selected' : ''}}>Danh mục cha</option>
                        <option value="user_id" {{request()->input('orderby') =='user_id' ? 'selected' : ''}}>Người dùng</option>
                        <option value="status" {{request()->input('orderby') =='status' ? 'selected' : ''}}>Trạng thái</option>
                    </select>
                    <div class="sm:w-42 2xl:w-full mt-2 sm:mt-0 sm:w-auto box">
                        <div class="w-full relative text-gray-700 dark:text-gray-300">
                            <input id="search" type="text" name="keywords" class="form-control w-full box pr-10 placeholder-theme-13" placeholder="Tìm kiếm..." value="{{request()->input('keywords')}}">
                            <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i>
                        </div></div>
                </form>
            </div>
        </div>

        <div id="searchs">
            <!-- BEGIN: Data List -->

            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <table class="table table-report -mt-2">
                    <thead>
                    <tr >
                        <th class="whitespace-nowrap text-center">STT</th>
                        <th class="whitespace-nowrap">TÊN DANH MỤC</th>
                        <th class="text-center whitespace-nowrap ">SLUG</th>
                        <th class="text-center whitespace-nowrap ">DANH MỤC CHA</th>
                        <th class="text-center whitespace-nowrap w-30">NGƯỜI DÙNG</th>
                        <th style="display:none;"></th>
                        <th class="text-center whitespace-nowrap w-30">TRẠNG THÁI</th>
                        <th class="text-center whitespace-nowrap ">CHỨC NĂNG</th>
                    </tr>
                    </thead>
                    <tbody class="col-span-12 " id="table1" >
                    @foreach($Category as $key => $list)
                        <tr class=" overflow-x-auto scrollbar-hidden" id="{{ $list->id }}">
                            <td class="text-center font-medium ">{{$list->id}}</td>
                            <td class="">{{$list->name}} </td>
                            <td class="overflow-hidden ">{{$list->slug}}</td>
                            <td class="text-center font-medium ">{{$list->parent_id}}</td>
                            <td class="w-30 text-center">{{$list->user_id}}</td>
                            <td style="display:none;">{{$status = $list->status}}</td>
                            <td>
                                @if($status == '1')
                                    <div class="flex items-center justify-center text-theme-9 mr-3" data-bs-toggle="tooltip" title="Kích hoạt"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i></div>
                                @else
                                    <div class="flex items-center justify-center text-theme-6 mr-3"data-bs-toggle="tooltip" title="Vô hiệu hóa"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i></div>
                                @endif
                            </td>
                            <td class="w-20">
                                <div class="flex justify-center items-center">
                                    @can('update',App\Models\Category::class)
                                        <a class="btn btn-sm btn-primary mr-2"
                                           href="{{route('category.edit',['id'=>$list->id])}}" data-bs-toggle="tooltip" title="Sửa" > <i class="fa-solid fa-pen-to-square"></i>
                                            {{-- <i data-feather="check-square" class="w-4 h-4 mr-1"></i></a> --}}
                                            @endcan
                                            @can('delete',App\Models\Category::class)
                                                <a title="Xóa" data-toggle="modal"
                                                   data-value="{{$list->id}}"
                                                   data-target="#delete-confirmation-modal"
                                                   class="btn btn-danger py-1 px-2 btn-delete"><i class="fa-solid fa-trash-can"style="padding: 1px"></i>
                                                </a>
                                    @endcan

                                </div>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @include('admin.category.delete')
        <!-- END: Data List -->
            <!-- BEGIN: Pagination -->
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center"  >

                <ul class="pagination" >

                    <li> {{ $Category->withQueryString()->onEachSide(1)->links('admin.layouts.pagination') }}</li>
                </ul>
            </div>
            <!-- END: Pagination -->
        </div>
    </div>
    <!-- END: Content -->
@endsection
