 <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
              
                    <input type="hidden" name="id" id="delete_id">
                    <div class="p-5 text-center">
                        <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Bạn muốn xoá danh mục này?</div>
                        <div class="text-gray-600 mt-2">
                            Lưu ý: Quá trình này sẽ không thể hoàn tác.
                        </div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Quay lại</button>
                        <button type="button" data-dismiss="modal"class="delete btn btn-danger w-24">Xóa</button>
                    </div>
        
                </div>
            </div>
        </div>
    </div>

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
                    url: "{{ route('categorypost.delete') }}",
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
@endsection