$(document).ready(function () {
    $(document).on("click", "#search_btn", function(e) {
        e.preventDefault();
        var url = $(this).attr("href");
        var append = url.indexOf("?") == -1 ? "?" : "&";
        var finalURL = url + append + $("#form-limit").serialize() + "&" + $("#searchform").serialize();
        console.log(finalURL);
        window.history.pushState({}, null, finalURL);

        $.get(finalURL, function(data) {
            $("#data").remove();
            $("#pagi").remove();
            $("#data-table").append(data);
        });
        return false;
    })

    $(document).on("click", ".pagination a", function(e) {
        e.preventDefault();
        var url = $(this).attr("href");
        window.history.pushState({}, null, url);

        $.get(url, function(data) {
            $("#data").remove();
            $("#pagi").remove();
            $("#data-table").append(data);
        });
        return false;
    })

    $(document).on("change", "#limit", function(e) {
        e.preventDefault();
        var url = $('#form-limit').attr('action');
        var append = url.indexOf("?") == -1 ? "?" : "&";
        var finalURL = url + append + $("#form-limit").serialize() + "&" + $("#searchform").serialize();

        window.history.pushState({}, null, finalURL);

        $.get(finalURL, function(data) {
            $("#data").remove();
            $("#pagi").remove();
            $("#data-table").append(data);
        });
        return false;
    })

    $(document).on("keyup", "#search", function(e) {
        e.preventDefault();
        if(e.keyCode == 13) {
            var url = $('#searchform').attr('action');
            var append = url.indexOf("?") == -1 ? "?" : "&";
            var finalURL = url + append + $("#form-limit").serialize() + "&" + $("#searchform").serialize();
            console.log(finalURL);
            window.history.pushState({}, null, finalURL);

            $.get(finalURL, function(data) {
                $("#data").remove();
                $("#pagi").remove();
                $("#data-table").append(data);
            });
        }
        return false;
    })
})


