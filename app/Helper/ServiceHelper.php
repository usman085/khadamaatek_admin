<?php
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
    function getDocumentListArray($formbuilder_id_array){
        $formbuilder_ids = !empty($formbuilder_id_array) ? json_decode($formbuilder_id_array) : [];
        return $formbuilder_ids = (array)$formbuilder_ids;
    }
    function deocdeLocalVariale($name){
        $formbuilder_ids = !empty($name) && strpos($name, '{') !== false  ? json_decode($name) : [$name];
        return $formbuilder_ids = (array)$formbuilder_ids;
    }
    function getFormatedName($value){
        $current_locale = Session::get('current_locale','en');
        $array = deocdeLocalVariale($value);
        if(!empty($current_locale) && array_key_exists($current_locale,$array)){
            return $array[$current_locale];
        }
        return isset($array[0]) ? $array[0] : (isset($array['en']) ? $array['en']: $array['ar']);
    }
    function setFormatedName($value,$old_values){
        $current_locale = Session::get('current_locale','en');
        $default = [$current_locale => $value];
        if(count($old_values) > 0){
            $array = deocdeLocalVariale($old_values['name']);
            if(array_key_exists(0,$array)){
                return json_encode($default);
            }else if(array_key_exists($current_locale,$array)){
                $array[$current_locale] = $value;
            }else{
                $array[$current_locale] = $value;
            }
            return json_encode($array);
        }
        return json_encode($default);
    }
    function translateMessage($message){
        App::setLocale(Session::get('current_locale'));
        return __($message);
    }
    function translateNotification($message){
        App::setLocale(Session::get('current_locale'));
        return __($message);
    }
    function changeToArabicDigits($inputString) {
        $western_arabic = array('0','1','2','3','4','5','6','7','8','9');
        $eastern_arabic = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');
        if(Session::get('current_locale') == 'ar'){
            return str_replace($western_arabic, $eastern_arabic, $inputString);
        }
        return str_replace($eastern_arabic, $western_arabic, $inputString);
    }
?>