<?php
/*
    $data = $menuel['elements']
*/


?><?php
use App\MenuBuilder\FreelyPositionedMenus;
if(isset($appMenus['top menu'])){
    FreelyPositionedMenus::render( $appMenus['top menu'] , 'c-header-', 'd-md-down-none');
}
$current_locale = Session::get('current_locale','en');
$locale_array = ['en'=>'English','ar'=>'Arabic'];

if($locale_array[$current_locale] == "English" ){

    if(!function_exists('renderDropdown')){
        function renderDropdown($data){
      
            if(array_key_exists('slug', $data) && $data['slug'] === 'dropdown'){
                
                echo '<li class="c-sidebar-nav-dropdown">';
                echo '<a class="c-sidebar-nav-dropdown-toggle" href="#">';
                if($data['hasIcon'] === true && $data['iconType'] === 'coreui'){
                    echo '<i class="' . $data['icon'] . ' c-sidebar-nav-icon"></i>';
                }
                echo translateMessage('sideBar.'.str_replace(' ','',strtolower($data['name'])))  . '</a>';
                echo '<ul class="c-sidebar-nav-dropdown-items">';
                renderDropdown( $data['elements'] );
                echo '</ul></li>';
            }else{
                for($i = 0; $i < count($data); $i++){
                    if( $data[$i]['slug'] === 'link' && $data[$i]['name'] !== 'Edit menu' ){
                        echo '<li class="c-sidebar-nav-item">';
                        echo '<a class="c-sidebar-nav-link" href="' . env('APP_URL', '') . $data[$i]['href'] . '">';
                        echo '<span class="c-sidebar-nav-icon"></span>' . 
                        $name =  translateMessage('sideBar.'.str_replace(' ','',strtolower($data[$i]['name']))) 
                        
                        . '</a></li>';
                    }elseif( $data[$i]['slug'] === 'dropdown' ){
                        renderDropdown( $data[$i] );
                    }
                }
            }
        }
    }
}
else{
    if(!function_exists('renderDropdown')){
        function renderDropdown($data){
      
            if(array_key_exists('slug', $data) && $data['slug'] === 'dropdown'){
                
                echo '<li class="c-sidebar-nav-dropdown add-sidebar">';
                echo '<a class="c-sidebar-nav-dropdown-toggle add-sidebar" href="#" >';
                if($data['hasIcon'] === true && $data['iconType'] === 'coreui'){
                    echo '<i class="' . $data['icon'] . ' c-sidebar-nav-icon"  style="margin-left: 0"></i>';
                }
                echo translateMessage('sideBar.'.str_replace(' ','',strtolower($data['name'])))  . '</a>';
                echo '<ul class="c-sidebar-nav-dropdown-items " >';
                renderDropdown( $data['elements'] );
                echo '</ul></li>';
            }else{
                for($i = 0; $i < count($data); $i++){
                    if( $data[$i]['slug'] === 'link' && $data[$i]['name'] !== 'Edit menu' ){
                        echo '<li class="c-sidebar-nav-item">';
                        echo '<a class="c-sidebar-nav-link add-sidebar" style="justify-content: center;" href="' . env('APP_URL', '') . $data[$i]['href'] . '">';
                        echo '<span class="c-sidebar-nav-icon"></span>' . 
                        $name = translateMessage('sideBar.'.str_replace(' ','',strtolower($data[$i]['name']))) 
                        
                        . '</a></li>';
                    }elseif( $data[$i]['slug'] === 'dropdown' ){
                        renderDropdown( $data[$i] );
                    }
                }
            }
        }
    }
}

?>

      <div class="c-sidebar-brand">
          <img class="c-sidebar-brand-full" src="{{ env('APP_URL', '') }}/assets/brand/white logo.png" alt="CoreUI Logo">
          <img class="c-sidebar-brand-minimized" src="{{ env('APP_URL', '') }}/assets/brand/white hand.png" alt="CoreUI Logo">
      </div>
      @if($locale_array[$current_locale] == "English" )
        <ul class="c-sidebar-nav">
        @if(isset($appMenus['sidebar menu']))
            @foreach($appMenus['sidebar menu'] as $menuel)
                @if($menuel['slug'] === 'link')
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ env('APP_URL', '') . $menuel['href'] }}">
                        @if($menuel['hasIcon'] === true)
                            @if($menuel['iconType'] === 'coreui')
                                <i class="{{ $menuel['icon'] }} c-sidebar-nav-icon"></i>
                            @endif
                        @endif
                        <?php 
                      $name =  str_replace(' ','',strtolower($menuel['name']));
                     //echo translateMessage("sidebar.$name");
                       echo __("sideBar.$name")
                       ?>
                        </a>
                    </li>
                @elseif($menuel['slug'] === 'dropdown')
                    <?php renderDropdown($menuel) ?>
                @elseif($menuel['slug'] === 'title')
                    <li class="c-sidebar-nav-title">
                        @if($menuel['hasIcon'] === true)
                            @if($menuel['iconType'] === 'coreui')
                                <i class="{{ $menuel['icon'] }} c-sidebar-nav-icon"></i>
                            @endif
                        @endif
                        {{ $menuel['name'] }}
                    </li>
                @endif
            @endforeach
        @endif
        </ul>
        <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized" style="position: relative; justify-content: flex-end;">
            <span style="position: absolute; left:20px;top:30%;color:white;font-size:12px;">
                @lang('sideBar.version'): 1.1.5
            </span>
        </button>
        @else
        <ul class="c-sidebar-nav">
        @if(isset($appMenus['sidebar menu']))
            @foreach($appMenus['sidebar menu'] as $menuel)
                @if($menuel['slug'] === 'link')
                    <li class="c-sidebar-nav-item" style="padding-right:20px; ">
                        <a class="c-sidebar-nav-link add-sidebar" href="{{ env('APP_URL', '') . $menuel['href'] }}" style="float: right">

                        <?php 
                      $name =  str_replace(' ','',strtolower($menuel['name']));
                     echo translateMessage("sideBar.$name");
                        ?>
                            @if($menuel['hasIcon'] === true)
                                @if($menuel['iconType'] === 'coreui')
                                    <i class="{{ $menuel['icon'] }} c-sidebar-nav-icon" style="margin-left: 0"></i>
                                @endif
                            @endif
                        </a>
                    </li>
                @elseif($menuel['slug'] === 'dropdown')
                    <?php renderDropdown($menuel) ?>
                @elseif($menuel['slug'] === 'title')
                    <li class="c-sidebar-nav-title add-sidebar">
                        @if($menuel['hasIcon'] === true)
                            @if($menuel['iconType'] === 'coreui')
                                <i class="{{ $menuel['icon'] }} c-sidebar-nav-icon" style="margin-left: 0"></i>
                            @endif
                        @endif
                        {{ $menuel['name'] }}
                    </li>
                @endif
            @endforeach
        @endif
        </ul>
       
        <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized" style="position: relative; justify-content: flex-end;">
            <span style="position: absolute; left:20px;top:30%;color:white;font-size:12px;">
                @lang('sideBar.version'): 1.1.5
            </span>
        </button>
        @endif
     
    </div>
