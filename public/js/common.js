$(document).ready(function () {
    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});



    //Thay đổi kiểu chữ khi nhập(tên)
    //id input nhập
    $('#typinginput').on('keyup',  function(){
        var str = this.value;
        // Chuyển hết sang chữ thường
        str = str.toLowerCase();

        // xóa dấu
        str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
        str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
        str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
        str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
        str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
        str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
        str = str.replace(/(đ)/g, 'd');

        // Xóa ký tự đặc biệt
        str = str.replace(/([^0-9a-z-\s])/g, '');

        // Xóa khoảng trắng thay bằng ký tự -
        str = str.replace(/(\s+)/g, '-');

        // xóa phần dư - ở đầu
        str = str.replace(/^-+/g, '');

        // xóa phần dư - ở cuối
        str = str.replace(/-+$/g, '');
        // id slug
        document.getElementById('slugchanged').value = str;
    });
    //Thay đổi dữ liệu khi người dùng lưu sau khi nhập slug
    $('#slugchanged').on('change',  function(){
        var str = this.value;
        // Chuyển hết sang chữ thường
        str = str.toLowerCase();

        // xóa dấu
        str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
        str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
        str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
        str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
        str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
        str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
        str = str.replace(/(đ)/g, 'd');

        // Xóa ký tự đặc biệt
        str = str.replace(/([^0-9a-z-\s])/g, '');

        // Xóa khoảng trắng thay bằng ký tự -
        str = str.replace(/(\s+)/g, '-');

        // xóa phần dư - ở đầu
        str = str.replace(/^-+/g, '');

        // xóa phần dư - ở cuối
        str = str.replace(/-+$/g, '');
        // id slug
        document.getElementById('slugchanged').value = str;
    });

    /**Hiển thị ảnh ngay khi upload */
    $(document).on('change','#file-image',function () {
        var show_image = $(".show-image");
        var selectedFile = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function(event) {
            var image = '<div class="w-24 h-24 relative image-fit mb-5 mr-5 cursor-pointer zoom-in"><img src="'+event.target.result+'"></div>';
            show_image.empty();
            show_image.append(image);
        };
        reader.readAsDataURL(selectedFile);
    })
    /** Upload nhiều image */
    var imagesPreview = function(input, placeToInsertImagePreview) {
        if (input.files) {
            var filesAmount = input.files.length;
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    };
    $(document).on('change','#file-images',function () {
        var show_image = $(".show-image");
        show_image.empty();
        imagesPreview(this,'div.show-image')
    })

    $('.btn-delete').on('click',function (e) {
        e.preventDefault();
        var id = $(this).attr('data-value');
        $('#delete_id').val(id);
    });


    //xử lý hien thi abum ảnh
    $("#fileupload").change(function () {
        if (typeof (FileReader) != "undefined") {
            var dvPreview = $("#dvPreview");
            dvPreview.html("");
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
            $($(this)[0].files).each(function () {
                var file = $(this);
                if (regex.test(file[0].name.toLowerCase())) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var img = $("<img />");
                        img.attr("class", "rounded-md inline-block w-24 h-24 relative image-fit mb-5 mr-5 cursor-pointer zoom-in");
                        img.attr("src", e.target.result);
                        dvPreview.append(img);
                    }
                    reader.readAsDataURL(file[0]);
                } else {
                    alert(file[0].name + " không phải file ảnh");
                    dvPreview.html("");
                    return false;
                }
            });
        } else {
            alert("Trình duyệt này không hỗ trợ HTML 5 FileReader");
        }
    });
    // xử lý hiển thị 1 ảnh copy từ xử lý abum
    $("#fileupload2").change(function () {
        if (typeof (FileReader) != "undefined") {
            var dvPreview = $("#dvPreview2");
            dvPreview.html("");
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
            $($(this)[0].files).each(function () {
                var file = $(this);
                if (regex.test(file[0].name.toLowerCase())) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var img = $("<img />");
                        img.attr("style", " display: inline-block; object-fit: cover; object-position: 50% 0; width: 300px;height: 300px;");
                        img.attr("src", e.target.result);
                        dvPreview.append(img);
                    }
                    reader.readAsDataURL(file[0]);
                } else {
                    alert(file[0].name + " không phải file ảnh");
                    dvPreview.html("");
                    return false;
                }
            });
        } else {
            alert("Trình duyệt này không hỗ trợ HTML 5 FileReader");
        }
    });

    //xu ly nhap tien te (note:loai bo ky tu dac biet khi luu trong controller)
    $('#tiente').on('keyup',  function(){
        const number = this.value;
        const loaibokitudacbiet =  number.replace(/[^a-zA-Z0-9 ]/g, '');
        document.getElementById('tiente').value = new Intl.NumberFormat('vi-VN').format(loaibokitudacbiet);
    });
    //xu ly so luong copy tu tien te

    $('#soluong').on('keyup',  function(){
        const number = this.value;
        const loaibokitudacbiet =  number.replace(/[^a-zA-Z0-9 ]/g, '');
        document.getElementById('soluong').value = new Intl.NumberFormat('vi-VN').format(loaibokitudacbiet);

    });


    // function filter(){
    //     var limit = document.getElementById('limit').value;
    //     var orderby = document.getElementById('orderby').value;
    //     var search = document.getElementById('search').value;
    //     $.ajax({
    //         url: "category",
    //         method: "get",
    //         data: {
    //             limit : limit,
    //             orderby : orderby,
    //             search : search,
    //         },
    //         dataType: "json",
    //         success: function (data) {
    //             $('#searchs').remove();
    //             console.log(data);
    //             console.log(data.html);
    //             $.each(data.html, function (i ,item) {
    //                 console.log(item.name);
    //             })
    //
    //             // $('#searchs').append(data);
    //         },
    //     });
    //     // console.log(limit,orderby,search);
    // }
    // $('#limit').on('change',  function(){ filter();});
    // $('#orderby').on('orderby',  function(){ filter();});

});

