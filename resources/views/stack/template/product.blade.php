@extends('layouts.stack.page')
@section('vendor-css')
    <link rel="stylesheet" type="text/css" href="{{asset(config('setting.theme'))}}/app-assets/vendors/css/vendors.min.css">
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{asset(config('setting.theme'))}}/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="{{asset(config('setting.theme'))}}/app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="{{asset(config('setting.theme'))}}/app-assets/vendors/css/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="{{asset(config('setting.theme'))}}/app-assets/css/plugins/extensions/toastr.css">
@endsection

@section('content')
    <product-component></product-component>
@endsection

@section('script')
    <script src="{{asset(config('setting.theme'))}}/app-assets/js/scripts/ui/breadcrumbs-with-stats.js"></script>
    <script src="{{asset(config('setting.theme'))}}/app-assets/vendors/js/extensions/toastr.min.js"></script>
    <script src="{{asset('js/app.js')}}"></script>
@endsection
