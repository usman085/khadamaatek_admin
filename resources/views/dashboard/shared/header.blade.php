<div class="c-wrapper">
<?php
            use App\MenuBuilder\FreelyPositionedMenus;
            if(isset($appMenus['top menu'])){
                FreelyPositionedMenus::render( $appMenus['top menu'] , 'c-header-', 'd-md-down-none');
            }
            $current_locale = Session::get('current_locale','en');
            $locale_array = ['en'=>'English','ar'=>'Arabic']
        ?>
@if($locale_array[$current_locale] == "English" )
<header class="c-header c-header-light c-header-fixed c-header-with-subheader">

        @else
        <header class="c-header add-head c-header-light c-header-fixed c-header-with-subheader" style="flex-direction: row-reverse">
        @endif

        <button class="c-header-toggler c-class-toggler d-lg-none " type="button" data-target="#sidebar"
            data-class="c-sidebar-show"><span class="c-header-toggler-icon"></span></button>
        {{-- <a class="c-header-brand d-sm-none" href="#"><img class="c-header-brand" src="{{ env('APP_URL', '') }}/assets/brand/white
        logo.png" width="97" height="46" alt="CoreUI Logo"></a> --}}
        <button class="c-header-toggler c-class-toggler ml-3 d-md-down-none" type="button" data-target="#sidebar"
            data-class="c-sidebar-lg-show" responsive="true"><span class="c-header-toggler-icon"></span></button>

     @if($locale_array[$current_locale] == "English" )
       <ul class="c-header-nav ml-auto mr-1">
     @else
       <ul class="c-header-nav  mr-1" style="margin-right: auto !important;">
     @endif

            <li class="c-header-nav-item dropdown">
                <a class="c-header-nav-link" data-toggle="dropdown" href="#"
                    role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="c-avatar">
                        <i class="fa fa-globe"></i> {{ $locale_array[$current_locale] }}
                    </div>
                </a>
                @if($locale_array[$current_locale] == "English" )
                    <div class="dropdown-menu dropdown-menu-right pt-0">
                        @else
                            <div class="dropdown-menu  pt-0">
                                @endif

                    @foreach ($locale_array as $key => $locale_object)
                        <a class="dropdown-item" href="{{ route('set.locale',['locale' => $key]) }}">
                            {{ $locale_object }}
                        </a>
                    @endforeach
                </div>
            </li>
        </ul>

        <ul class="c-header-nav ml-2 mr-4">
            {{-- <li class="c-header-nav-item d-md-down-none mx-2"><a class="c-header-nav-link">
                    <svg class="c-icon">
                        <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-bell"></use>
            </svg></a></li> --}}
            {{-- <li class="c-header-nav-item d-md-down-none mx-2"><a class="c-header-nav-link">
                    <svg class="c-icon">
                        <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-list-rich"></use>
            </svg></a></li> --}}
            {{-- <li class="c-header-nav-item d-md-down-none mx-2"><a class="c-header-nav-link">
                    <svg class="c-icon">
                        <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-envelope-open"></use>
            </svg></a></li> --}}
            <li class="c-header-nav-item dropdown"><a class="c-header-nav-link" data-toggle="dropdown" href="#"
                    role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="c-avatar"><img class="c-avatar-img"
                            src="{{ env('APP_URL', '') }}/assets/img/avatars/{{ auth()->user()->avatar }}"
                            alt="{{ auth()->user()->name }}"></div>
                </a>
                @if($locale_array[$current_locale] == "English" )
                    <div class="dropdown-menu dropdown-menu-right pt-0">
                        @else
                            <div class="dropdown-menu  pt-0">
                                @endif
 
                    {{-- <div class="dropdown-header bg-light py-2"><strong>@lang('messages.account')</strong></div>
              <a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-bell"></use>
                    </svg> Updates<span class="badge badge-info ml-auto">42</span></a><a class="dropdown-item" href="#">
                        <svg class="c-icon mr-2">
                            <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-envelope-open"></use>
                        </svg> Messages<span class="badge badge-success ml-auto">42</span></a><a class="dropdown-item"
                        href="#">
                        <svg class="c-icon mr-2">
                            <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-task"></use>
                        </svg> Tasks<span class="badge badge-danger ml-auto">42</span></a><a class="dropdown-item"
                        href="#">
                        <svg class="c-icon mr-2">
                            <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-comment-square"></use>
                        </svg> Comments<span class="badge badge-warning ml-auto">42</span></a> --}}
                    <div class="dropdown-header bg-light py-2"><strong>@lang('sideBar.settings')</strong></div>
                    <a class="dropdown-item" href="{{ route('user.profile') }}">
                        <svg class="c-icon mr-2">
                            <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-user"></use>
                        </svg>@lang('sideBar.Profile') </a>
                    {{-- <a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-settings"></use>
                    </svg> Settings</a> --}}
                    {{-- <a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-credit-card"></use>
                    </svg> Payments<span class="badge badge-secondary ml-auto">42</span></a> --}}
                    {{-- <a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-file"></use>
                    </svg> Projects<span class="badge badge-primary ml-auto">42</span></a> --}}
                    <div class="dropdown-divider"></div>
                    {{-- <a class="dropdown-item" href="#">
                  <svg class="c-icon mr-2">
                    <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-lock-locked"></use>
                    </svg> Lock Account
                    </a> --}}
                    <a class="dropdown-item" href="#">
                        <svg class="c-icon mr-2">
                            <use xlink:href="{{ env('APP_URL', '') }}/icons/sprites/free.svg#cil-account-logout"></use>
                        </svg>
                        <form action="/admin/logout" method="POST"> @csrf <button type="submit"
                                class="btn btn-ghost-dark btn-block">@lang('sideBar.logout') </button></form>
                    </a>
                </div>
            </li>
        </ul>
        <div class="c-subheader px-3">
            @if($locale_array[$current_locale] == "English" )
            <div class="main-breadcrump">
                @else
                    <div class="main-breadcrump" style="display: inline-block;
                    position: absolute;
                    right: 0;">
                @endif
                @yield('breadcrumbs')
            </div>
            {{-- <ol class="breadcrumb border-0 m-0">
                <li class="breadcrumb-item"><a href="/">@lang('dashboard.home')</a></li>
                <?php // $segments = ''; ?>
                @for($i = 1; $i <= count(Request::segments()); $i++) <?php // $segments .= '/'. Request::segment($i); ?>
                    @if($i < count(Request::segments())) <li class="breadcrumb-item">{{ Request::segment($i) }}</li>
            @else
            <li class="breadcrumb-item active">{{ Request::segment($i) }}</li>
            @endif
            @endfor
            </ol> --}}
        </div>
    </header>
