<!DOCTYPE html>
<html lang="vi" class="light">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href="/upload/images/common_img/logo.svg" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="It24h, công ty cung cấp giải pháp CNTT">
        <meta name="keywords" content="Thiết kế website, website doanh nghiệp, seo web, website bán hàng">
        <title>Admin</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- BEGIN: CSS Assets-->

        <link rel="stylesheet" href="/css/app.css"/>
        <link rel="stylesheet" href="/lib/tailwind227.min.css">
        <link rel="stylesheet" href="/lib/fontawesome/css/all.min.css">
        
        {{-- toanbv crop image --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>

        @yield('css')
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
    @yield('body')
</html>
