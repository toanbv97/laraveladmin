$(document).ready(function() {

    /* Chức năng hiển thị ảnh khi upload file */
    show_upload_image = function() {
        var upload_image = document.getElementById("avatar")
        if (upload_image.files && upload_image.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#upload-image').attr('src', e.target.result)
            };
            reader.readAsDataURL(upload_image.files[0]);
        }
    }

    /* SHOW HIDDEN PASSWORD */
    const passField_1 = document.querySelector("input#change-password-form-1");
    const showBtn_1 = document.querySelector("span.pw_old i");
    showBtn_1.onclick = (() => {
        if (passField_1.type === "password") {
            passField_1.type = "text";
            showBtn_1.classList.add("hide-btn");
        } else {
            passField_1.type = "password";
            showBtn_1.classList.remove("hide-btn");
        }
    });

    const passField_2 = document.querySelector("input#change-password-form-2");
    const showBtn_2 = document.querySelector("span.pw_new i");
    showBtn_2.onclick = (() => {
        if (passField_2.type === "password") {
            passField_2.type = "text";
            showBtn_2.classList.add("hide-btn");
        } else {
            passField_2.type = "password";
            showBtn_2.classList.remove("hide-btn");
        }
    });

    const passField_3 = document.querySelector("input#change-password-form-3");
    const showBtn_3 = document.querySelector("span.pw_new_confirm i");
    showBtn_3.onclick = (() => {
        if (passField_3.type === "password") {
            passField_3.type = "text";
            showBtn_3.classList.add("hide-btn");
        } else {
            passField_3.type = "password";
            showBtn_3.classList.remove("hide-btn");
        }
    });
});
