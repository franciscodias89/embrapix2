<!DOCTYPE html>
<html lang="{{ app()->getLocale()}}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="apple-touch-icon" sizes="180x180"
            href="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/images/favicons/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32"
            href="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/images/favicons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16"
            href="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/images/favicons/favicon-16x16.png">
        <title>@yield("title")</title>
        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
            type="text/css">
        <link href="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet"
            type="text/css">
        <link href="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/css/bootstrap.min.css?v=2.4.0-stable-01" rel="stylesheet" type="text/css">
        <link href="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/css/combined.min.css" rel="stylesheet" type="text/css">
        <link href="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/css/layout.min.css" rel="stylesheet" type="text/css">
        <link href="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/css/components.min.css?v=2.4.0-stable-01" rel="stylesheet" type="text/css">
        <link href="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/css/colors.min.css" rel="stylesheet" type="text/css">
        <link href="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/css/extras/animate.min.css" rel="stylesheet"
            type="text/css">
        <link href="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/css/backend-custom.css?v=2.4.1" rel="stylesheet"
            type="text/css">
        <link href="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/css/bootstrap-material-datetimepicker.css" rel="stylesheet" type="text/css">

        <link type="text/css" href="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/css/OverlayScrollbars.min.css" rel="stylesheet"/>
        
        <!-- /global stylesheets -->

  <!-- FileUploader -->
        <link href="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/fileuploader/dist/font/font-fileuploader.css" rel="stylesheet" type="text/css">
        <link href="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/fileuploader/dist/jquery.fileuploader.min.css" rel="stylesheet" type="text/css">
        <link href="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/fileuploader/examples/avatar2/css/jquery.fileuploader-theme-avatar.css" rel="stylesheet" type="text/css">
        <!-- /FileUploader -->
        
        <!-- Core JS files -->
        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/js/main/jquery.min.js"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.10.2/Sortable.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>

        
        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/js/jquery.overlayScrollbars.min.js"></script>
        
        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets//js/plugins/ui/moment/moment.min.js"></script>


        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/js/main/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/js/plugins/loaders/blockui.min.js"></script>
        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/js/plugins/ui/slinky.min.js"></script>
        <!-- /core JS files -->

        <!-- FileUploader -->
        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/fileuploader/dist/jquery.fileuploader.min.js"></script>
        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/fileuploader/examples/avatar2/js/custom.js"></script>  
        <!-- /FileUploader -->

        <!-- Theme JS files -->
        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/js/plugins/ui/sticky.min.js"></script>
        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/js/plugins/buttons/spin.min.js"></script>
        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/js/plugins/buttons/ladda.min.js"></script>

        @if(!Request::is('admin/dashboard'))
            <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/js/plugins/notifications/jgrowl.min.js"></script>
            <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/js/plugins/forms/selects/select2.min.js"></script>
            <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
            <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
            <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/js/plugins/pickers/color/spectrum.js"></script>
            <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/js/plugins/editors/summernote/summernote.js"></script>
            <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/js/plugins/pickers/daterangepicker.js"></script>
            <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/js/plugins/uploaders/dropzone.min.js"></script>
        @endif

        

        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/js/plugins/tables/datatables/extensions/fixed_columns.min.js"></script>
        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/js/plugins/tables/datatables/extensions/col_reorder.min.js"></script>
        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>

        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/js/plugins/visualization/echarts/echarts.js" defer></script>

        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/js/app.js"></script>
        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/js/navbar-sticky.js"></script>
        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/js/printThis.js"></script>
        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/js/jquery-alphanum.js"></script>
        @if(Request::is('admin/settings'))
        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/js/plugins/editors/ace/ace.js"></script>
        @endif 

        {{-- @if(Request::is('admin/stores') || Request::is('admin/store/*') || Request::is('store-owner/stores') || Request::is('store-owner/store/*') || Request::is('admin/popular-geo-locations')) --}}
        <!-- Load GMAPS Only when needed -->
            {{-- <script src="https://maps.googleapis.com/maps/api/js?key={{ config('settings.googleApiKeyIP') }}"></script> --}}
            {{-- <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/js/google-maps.js"></script> --}}
        {{-- @endif --}}
        
        <script type="text/javascript" src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/js/bootstrap-material-datetimepicker.js"></script>
        <!-- /theme JS files -->
        <link rel="manifest" href="{{ URL::asset('backend-manifest.json') }}">

    </head>
    <body>
        @if(!Request::is('auth/login'))
            @include("admin.includes.header")
        @endif
        <div class="page-content container pt-0">
            <div class="content-wrapper">
                @yield("content")
            </div>
        </div>
        @include('admin.includes.notification')

        <script>
            $(function() {
                $('form').submit(function(){
                    $(this).find(':input[type=submit]').prop('disabled', true);
                });
                $('.note-codable').on('blur', function() {
                  var codeviewHtml        = $(this).val();
                  var $summernoteTextarea = $(this).closest('.note-editor').siblings('textarea');
                  $summernoteTextarea.val(codeviewHtml);
                 });
                // $(".dataTables_scrollBody").overlayScrollbars({
                //     scrollbars : {
                //         visibility: "auto",
                //         autoHide: "move",
                //         autoHideDelay: 1000
                //     }
                // });
            });
        </script>
    </body>
</html>