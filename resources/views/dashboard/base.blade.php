<!DOCTYPE html>


<html lang="en">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <meta name="author" content="Łukasz Holeczek"> -->
    <!-- <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard"> -->
    <title>{{ config('app.head_title', 'Laravel') }}</title>
    <link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" />
    <link href="{{ asset('css/free.min.css') }}" rel="stylesheet"> <!-- icons -->
    <link href="{{ asset('css/flag-icon.min.css') }}" rel="stylesheet"> <!-- icons -->
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"> <!-- icons -->
    <!-- Main styles for this application-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/coreui-chartjs.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatable/buttons.bootstrap4.min.css') }}" rel="stylesheet">

    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    @stack('custome_css')
    <style>
        table.dataTable {
            min-width: 100%;
        }
        .navbar-fixed-bottom, .navbar-fixed-top{
   left:auto !important;
}
    </style>

    @yield('css')

    {{-- <!-- Global site tag (gtag.js) - Google Analytics-->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        // Shared ID
        gtag('config', 'UA-118965717-3');
        // Bootstrap ID
        gtag('config', 'UA-118965717-5');

    </script> --}}

</head>



<body class="c-app">
<?php
      $current_locale = Session::get('current_locale','en');
      $locale_array = ['en'=>'English','ar'=>'Arabic']
    ?>   
    <!-- <p>{{ $locale_array[$current_locale] }}</p> -->
        @if($locale_array[$current_locale] == "English" )
        <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">

        @else
        <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-right c-sidebar-lg-show" id="sidebar">

        @endif
 
        @include('dashboard.shared.nav-builder')

        @include('dashboard.shared.header')

        <div class="c-body">

            <main class="c-main">

                @yield('content')

            </main>
            <input type="hidden" id="clipboad_input"/>
            @include('dashboard.shared.footer')
        </div>
    </div>

    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('js/coreui.bundle.min.js') }}"></script>
    <script src="{{ asset('js/coreui-utils.js') }}"></script>
    <script src="{{ asset('js/datatable/jquery.min.js') }}"></script>
    <script src="{{ asset('js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatable/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/datatable/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

    {{-- Toastr --}}
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet"> <!-- icons -->
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    @yield('javascript')
       
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
        };
        toastr.error("{{ $error }}");

    </script>
    @endforeach
    @endif

    @if (Session::get('error'))
    @if(Session::get('message'))
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
        };
        toastr.error("{{ Session::get('message') }}");

    </script>
    @endif
    @endif
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.6/dist/clipboard.min.js"></script>
    <script>
        
        jQuery(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.select2').select2();

            $("body").on('keypress', '.english-char', function (e) {
                var ew = e.which;
                if (ew == 32)
                    return true;
                if (48 <= ew && ew <= 57)
                    return true;
                if (65 <= ew && ew <= 90)
                    return true;
                if (97 <= ew && ew <= 122)
                    return true;
                if (ew == 46 || ew == 45)
                    return true;
                return false;
            });
        })
          function copyTextToClipboard(text) {
            var $temp = $("#clipboad_input");
            $temp.val(text).select();
            document.execCommand("copy");
            toastr.success("Text Copied to Clipboard");
          }
function doConfirm(msg, yesFn, noFn) {
    var confirmBox = $("#confirmBox");
    
    confirmBox.find(".message").text(msg);
    confirmBox.find(".yes,.no").unbind().click(function() {
        confirmBox.hide();
    });
    confirmBox.find(".yes").click(yesFn);
    confirmBox.find(".no").click(noFn);
    confirmBox.show();
}
$(document).on('submit', '.form', function(e){
    e.preventDefault();
    var form = this;
        doConfirm("@lang('common.deleteConfirm')", function yes() {
            form.submit();
        }, function no() {
            // do nothing
        });
})

// $(function() {
//     $("form").submit(function(e) {
//         e.preventDefault();
//         var form = this;
//         doConfirm("@lang('common.deleteConfirm')", function yes() {
//             form.submit();
//         }, function no() {
//             // do nothing
//         });
//     });
// });
    </script>


</body>

</html>
