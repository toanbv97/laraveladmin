
<!DOCTYPE html>
<html lang="vi" class="light">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href="{{asset('upload/images/common/logo.svg')}}" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="It24h, công ty cung cấp giải pháp CNTT">
        <meta name="keywords" content="Thiết kế website, website doanh nghiệp, seo web, website bán hàng">
        <title>Admin</title>

        <!-- BEGIN: CSS Assets-->

        <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
        @yield('css')
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
    <body class="login">
        @yield('content')

        <!-- BEGIN: JS Assets-->
        <script src="{{asset('js/app.js')}}"></script>
        <!-- END: JS Assets-->
        @yield('js')
    </body>
</html>
