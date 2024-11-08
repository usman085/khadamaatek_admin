@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('permissions') }}
@endsection
@php
    $current_locale = Session::get('current_locale','en');
    $locale_array = ['en'=>'English','ar'=>'Arabic']
@endphp
@section('content')


<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        @if($locale_array[$current_locale] == "English" )
                        <h4>@lang('setting.rolesPermissions')</h4>
                         @else
                            <h4 class="align-right">@lang('setting.rolesPermissions')</h4>
                         @endif
                    </div>
                    <div class="card-body">
                        @if (!$menulist)
                        <div class="row mb-3 ml-3">
                            <a class="btn btn-lg btn-primary" href="{{ route('menu.create') }}">@lang('setting.addNewMenuElement')Add new menu element</a>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <form action="{{ route('menu.index') }}" methos="GET">
                                    <select class="form-control" name="menu">
                                        @foreach($menulist as $menu1)
                                        @if($menu1->id == $thisMenu)
                                        <option value="{{ $menu1->id }}" selected>{{ $menu1->name }}</option>
                                        @else
                                        <option value="{{ $menu1->id }}">{{ $menu1->name }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <br>
                                    <button type="submit" class="btn btn-primary">Change menu</button>
                                </form>
                            </div>
                        </div>
                        @endif
                        <?php

    function renderDropdownForMenuEdit($data, $role){
        if(array_key_exists('slug', $data) && $data['slug'] === 'dropdown'){
            $name =  str_replace(' ','',strtolower($data['name']));
            $name= translateMessage("sideBar.$name");
            $edit = translateMessage('common.edit');
            $current_locale = Session::get('current_locale','en');
            $locale_array = ['en'=>'English','ar'=>'Arabic'];
            if($locale_array[$current_locale] == "English" ){
            echo '<tr>';
            // echo '<td>';
            // if($data['hasIcon'] === true && $data['iconType'] === 'coreui'){
            //     echo '<svg class="c-nav-icon edit-menu-icon"><use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#' . $data['icon'] . '"></use></svg>';    
            //     echo '<i class="' . $data['icon'] . '"></i>';
            // }
            // echo '</td>';
            // echo '<td>' . $data['slug'] . '</td>';
            echo '<td>' . $name . '</td>';
            // echo '<td></td>';
            // echo '<td>' . $data['sequence'] . '</td>';
            // echo '<td>';
            // echo '<a class="btn btn-success" href="' . route('menu.up', ['id' => $data['id']]) . '"><i class="cil-arrow-thick-top"></i></a>';
            // echo '</td>';
            // echo '<td>';
            // echo '<a class="btn btn-success" href="' . route('menu.down', ['id' => $data['id']]) . '"><i class="cil-arrow-thick-bottom"></i></a>';
            // echo '</td>';
            // echo '<td>';
            // echo '<a class="btn btn-primary" href="' . route('menu.show', ['id' => $data['id']]) . '">Show</a>';
            // echo '</td>';
            echo '<td>';
            echo '<a class="btn btn-primary" href="' . route('menu.edit', ['id' => $data['id']]) . '">'.$edit.'</a>';
            echo '</td>';
            // echo '<td>';
            // echo '<a class="btn btn-danger" href="' . route('menu.delete', ['id' => $data['id']]) . '">Delete</a>';
            // echo '</td>';
            echo '</tr>';
            }else{
                echo '<tr class="align-right">';
                echo '<td>';
                echo '<a class="btn btn-primary" href="' . route('menu.edit', ['id' => $data['id']]) . '">'.$edit.'</a>';
                echo '</td>';
                echo '<td>' . $name . '</td>';
                echo '</tr>';
            }
            renderDropdownForMenuEdit( $data['elements'], $role );
        }else{
            for($i = 0; $i < count($data); $i++){
                if( $data[$i]['slug'] === 'link' ){
                    $current_locale = Session::get('current_locale','en');
                    $locale_array = ['en'=>'English','ar'=>'Arabic'];
                  $name =  str_replace(' ','',strtolower($data[$i]['name']));
                  $name= translateMessage("sideBar.$name");
                  $edit = translateMessage('common.edit');
                  if($locale_array[$current_locale] == "English" ){
                    echo '<tr>';
                    // echo '<td>';
                    // echo '<i class="cil-arrow-thick-to-right"></i>';
                    // echo '</td>';
                    // echo '<td>' . $data[$i]['slug'] . '</td>';

                    echo '<td>' . $name . '</td>';
                    // echo '<td>' . $data[$i]['href'] . '</td>';
                    // echo '<td>' . $data[$i]['sequence'] . '</td>';
                    // echo '<td>';
                    // echo '<a class="btn btn-success" href="' . route('menu.up', ['id' => $data[$i]['id']]) . '"><i class="cil-arrow-thick-top"></i></a>';
                    // echo '</td>';
                    // echo '<td>';
                    // echo '<a class="btn btn-success" href="' . route('menu.down', ['id' => $data[$i]['id']]) . '"><i class="cil-arrow-thick-bottom"></i></a>';
                    // echo '</td>';
                    // echo '<td>';
                    // echo '<a class="btn btn-primary" href="' . route('menu.show', ['id' => $data[$i]['id']]) . '">Show</a>';
                    // echo '</td>';
                    echo '<td>';
                    echo '<a class="btn btn-primary" href="' . route('menu.edit', ['id' => $data[$i]['id']]) . '">'.$edit.'</a>';
                    echo '</td>';
                    // echo '<td>';
                    // echo '<a class="btn btn-danger" href="' . route('menu.delete', ['id' => $data[$i]['id']]) . '">Delete</a>';
                    // echo '</td>';
                    echo '</tr>';
                    }else{
                      echo '<tr class="align-right">';
                      echo '<td>';
                      echo '<a class="btn btn-primary" href="' . route('menu.edit', ['id' => $data[$i]['id']]) . '">'.$edit.'</a>';
                      echo '</td>';
                      echo '<td>' . $name . '</td>';
                      echo '</tr>';
                  }
                }elseif( $data[$i]['slug'] === 'dropdown' ){
                    renderDropdownForMenuEdit( $data[$i], $role );
                }
            }
        }
    }

              ?>


                        <table class="table table-striped table-bordered datatable">
                            <thead>
                            @if($locale_array[$current_locale] == "English" )
                                <tr>
                                    <th>@lang('common.name')</th>
                                    {{-- <th></th> --}}
                                    {{-- <th>Type</th> --}}
                                    {{-- <th>href</th> --}}
                                    {{-- <th>Sequence</th> --}}
                                    {{-- <th></th> --}}
                                    {{-- <th></th> --}}
                                    {{-- <th></th> --}}
                                    {{-- <th></th> --}}
                                    <th></th>
                                </tr>
                            @else
                                <tr class="align-right">
                                    <th></th>
                                    <th>@lang('common.name')</th>

                                </tr>
                            @endif
                            </thead>
                            <tbody>

                                @foreach($menuToEdit as $menuel)
                                @if($menuel['slug'] === 'link')
                                    @if($locale_array[$current_locale] == "English" )
                                <tr>
                                    {{-- <td>
                                        @if($menuel['hasIcon'] === true)
                                        @if($menuel['iconType'] === 'coreui')
                                        <svg class="c-nav-icon edit-menu-icon">
                                            <use
                                                xlink:href="/assets/icons/coreui/free-symbol-defs.svg#{{ $menuel['icon'] }}">
                                    </use>
                                    </svg>
                                    <i class="{{ $menuel['icon'] }}"></i>
                                    @endif
                                    @endif
                                    </td> --}}
                                    {{-- <td>
                                        {{ $menuel['slug'] }}
                                    </td> --}}
                                    <td>
                                        <?php
                                        $name =  str_replace(' ','',strtolower($menuel['name']));
                                        echo translateMessage("sideBar.$name");
                                        ?>

                                    </td>
                                    {{-- <td>
                                        {{ $menuel['href'] }}
                                    </td> --}}
                                    {{-- <td>
                                        {{ $menuel['sequence'] }}
                                    </td> --}}
                                    {{-- <td>
                                        <a class="btn btn-success"
                                            href="{{ route('menu.up', ['id' => $menuel['id']]) }}">
                                    <i class="cil-arrow-thick-top"></i>
                                    </a>
                                    </td> --}}
                                    {{-- <td>
                                        <a class="btn btn-success"
                                            href="{{ route('menu.down', ['id' => $menuel['id']]) }}">
                                    <i class="cil-arrow-thick-bottom"></i>
                                    </a>
                                    </td> --}}
                                    {{-- <td>
                                        <a class="btn btn-primary"
                                            href="{{ route('menu.show', ['id' => $menuel['id']]) }}">Show</a>
                                    </td> --}}
                                    <td>
                                        <a class="btn btn-primary"
                                            href="{{ route('menu.edit', ['id' => $menuel['id']]) }}">@lang('common.edit')</a>
                                    </td>
                                    {{-- <td>
                                        <a class="btn btn-danger"
                                            href="{{ route('menu.delete', ['id' => $menuel['id']]) }}">Delete</a>
                                    </td> --}}
                                </tr>
                                   @else
                                        <tr class="align-right">
                                            <td>
                                                <a class="btn btn-primary"
                                                   href="{{ route('menu.edit', ['id' => $menuel['id']]) }}">@lang('common.edit')</a>
                                            </td>
                                            <td>
                                                <?php
                                                $name =  str_replace(' ','',strtolower($menuel['name']));
                                                echo translateMessage("sideBar.$name");
                                                ?>

                                            </td>

                                        </tr>
                                   @endif
                                @elseif($menuel['slug'] === 'dropdown')
                                <?php renderDropdownForMenuEdit($menuel, $role) ?>
                                @elseif($menuel['slug'] === 'title')
                                    @if($locale_array[$current_locale] == "English" )
                                     <tr>
                                    <td>
                                        {{ $menuel['name'] }}
                                    </td>
                                    {{-- <td>
                                        @if($menuel['hasIcon'] === true)
                                        @if($menuel['iconType'] === 'coreui')
                                        <svg class="c-nav-icon edit-menu-icon">
                                            <use
                                                xlink:href="/assets/icons/coreui/free-symbol-defs.svg#{{ $menuel['icon'] }}">
                                    </use>
                                    </svg>
                                    <i class="{{ $menuel['icon'] }}"></i>
                                    @endif
                                    @endif
                                    </td>
                                    <td>
                                        {{ $menuel['slug'] }}
                                    </td> --}}

                                    {{-- <td>

                                    </td>
                                    <td>
                                        {{ $menuel['sequence'] }}
                                    </td>
                                    <td>
                                        <a class="btn btn-success"
                                            href="{{ route('menu.up', ['id' => $menuel['id']]) }}">
                                            <i class="cil-arrow-thick-top"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-success"
                                            href="{{ route('menu.down', ['id' => $menuel['id']]) }}">
                                            <i class="cil-arrow-thick-bottom"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary"
                                            href="{{ route('menu.show', ['id' => $menuel['id']]) }}">Show</a>
                                    </td> --}}
                                    <td>
                                        <a class="btn btn-primary"
                                            href="{{ route('menu.edit', ['id' => $menuel['id']]) }}">@lang('common.edit')Edit</a>
                                    </td>
                                    {{-- <td>
                                        <a class="btn btn-danger"
                                            href="{{ route('menu.delete', ['id' => $menuel['id']]) }}">Delete</a>
                                    </td> --}}
                                </tr>
                                        @else
                                        <tr class="align-right">
                                            <td>
                                                <a class="btn btn-primary"
                                                   href="{{ route('menu.edit', ['id' => $menuel['id']]) }}">@lang('common.edit')Edit</a>
                                            </td>
                                            <td>
                                                {{ $menuel['name'] }}
                                            </td>

                                        </tr>
                                        @endif
                                @endif
                                @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection

@section('javascript')

@endsection
