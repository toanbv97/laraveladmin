$(document).ready(function () {
    function getData(url){
        window.history.pushState({}, null, url);
        $.get(url, function(data) {
            $("#data").remove();
            $("#pagi").remove();
            $("#data-table").append(data);
        });
    }
    $(document).on("click", "#search_btn", function(e) {
        e.preventDefault();
        var url = $(this).attr("href");
        var append = url.indexOf("?") == -1 ? "?" : "&";
        var finalURL = url + append + $("#form-limit").serialize() + "&" + $("#searchform").serialize();
        getData(finalURL);
        return false;
    })

    $(document).on("click", ".pagination a", function(e) {
        e.preventDefault();
        var url = $(this).attr("href");
        getData(url);
        return false;
    })

    $(document).on("change", "#limit, .select-search", function(e) {
        e.preventDefault();
        var url = $('#form-limit').attr('action');
        var append = url.indexOf("?") == -1 ? "?" : "&";
        var finalURL = url + append + $("#form-limit").serialize() + "&" + $("#searchform").serialize();
        getData(finalURL);
        return false;
    })

    $(document).on("keyup", "#search", function(e) {
        e.preventDefault();
        if(e.keyCode == 13) {
            var url = $('#searchform').attr('action');
            var append = url.indexOf("?") == -1 ? "?" : "&";
            var finalURL = url + append + $("#form-limit").serialize() + "&" + $("#searchform").serialize();
            getData(finalURL);
        }
        return false;
    })
})


