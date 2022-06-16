@extends('admin.layouts.main')
@section('subcontent')
 <div class="content">
                <h2 class="intro-y text-lg font-medium mt-10">
                   {{ $title}}
                </h2>
        <div class="form-group">
        <form action="{{ route('categorypost.update',[$edit->id]) }}" method="POST">
            @csrf
            <div class="form-heade">
            </div>
            <div class="grid grid-cols-12 gap-x-5">
            <div class="col-span-12 xl:col-span-6">
            <div class="form-group mb-4">
                <label>Tên danh mục</label>
                <input type="text" class="form-control" name='name' value="{{old('name') ?? $edit->name}}"  id="typinginput">
               @error('name')<span style="color: rgb(239 68 68);">{{ $message }}</span>@enderror
            </div>
            <div class="form-group mb-4">
                <label>SLUG</label>
                <textarea type="text" class="form-control" rows="1" id="slugchanged" name='slug'> {{old('slug') ?? $edit->slug}}</textarea>
                @error('slug')<span style="color: rgb(239 68 68);">{{ $message }}</span>@enderror
            </div>
            <div class="form-group mb-4">
                <label>Danh mục cha</label>
                    <select name="parent_id"  class="tom-select w-full">
                            @foreach ($categorieslv as $val)
                            <option value="{{$val->id}}" class="form-control">
                                @php
                                $str ='';
                                for ($i=0; $i < $val->level; $i++) {
                                    echo $str;
                                    $str.='&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
                                    // code...
                                }
                                @endphp
                                {{$val->name}}
                            </option>
                            @endforeach
                            <option value="0">Mặc định</option>
                    </select>
            </div>
            </div>
            <div class="col-span-12 xl:col-span-6">
            <div class="form-group mb-4">
                <label>Người dùng</label>
                <input type="number" class="form-control" name='user_id' value="{{old('user_id') ??  $edit->user_id}}">
            </div>
            <div class="form-group mb-4">
                <label>Trạng thái</label><br>
                 <input type="checkbox" class="form-check-switch" name='status' value="{{$edit->status == true ? '1' : '0'}}" {{$edit->status == true ? 'checked' : ' '}}>
            </div>
            </div>
            </div>
            <div class="modal-footer">
            <a type="button" class="btn btn-default" href="{{ route('categorypost.index')}}">Hủy</a>
            <input type="submit" class="btn btn-primary " value="Cập nhật">
        </div>
    </form>
</div>
</div>
@endsection
