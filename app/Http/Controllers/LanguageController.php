<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    public function index(){
        $languages = array_diff(scandir(base_path('resources/lang/')), ['.', '..']);
        return $languages;
    }

    private function fa_items(){
        $langs = $this->index();
        $path = base_path("resources/lang/fa/messages.php");
        return include $path;
    }

    public function generateJS(){
        $langs = $this->index();
        $preferred = config('app.locale');
        ob_start();
        echo 'function config($translateProvider) {

    $translateProvider';
        foreach($langs as $lang){
            echo "
            .translations('{$lang}', {
                ";
            $items = include base_path("resources/lang/{$lang}/messages.php");
            foreach($items as $item_key => $item_value){
                if(empty($item_value)) continue;
                $item_key = strtoupper($item_key);
                $item_value = str_replace('\'', '', $item_value);
                echo "{$item_key}: '{$item_value}',
                ";
            }
            echo "})";
        }
        echo '
        $translateProvider.preferredLanguage(\''.$preferred.'\');';
        echo "
    }

angular
    .module('inspinia')
    .config(config)";
    file_put_contents('js/translations.js', ob_get_contents());
    ob_get_clean();
    }

    public function create(){
        $items = $this->fa_items();
        return $items;
    }

    public function store(Request $request){
        $langs = $this->index();
        if(array_search($request->titleOfLanguage, $langs)){
            return [
                'result' => 'exception',
                'errors' => trans('language_already_exists')
            ];
        }
        $path = '../resources/lang/'.$request->titleOfLanguage;
        if(!mkdir($path, 0777, true)){
            return [
                'result' => 'exception',
                'errors' => trans('language_directory_permission_denied')
            ];
        }
        $fa_items = array_keys($this->fa_items());
        $inputs = $request->all();
        ob_start();
        echo 
"<?php

    return [";
    foreach($fa_items as $key){
        $value = (array_key_exists($key, $inputs)) ? $inputs[$key] : '';
        echo "
        '{$key}' => '{$value}',";
    }
echo "];";
        file_put_contents($path.'/messages.php', ob_get_contents());
        ob_get_clean();
        return [
            'result' => 'success',
            'message' => trans('language_added'),
            'reset' => true
        ];
    }

    public function edit($key){
        $fa_items = $this->fa_items();
        $path = base_path("resources/lang/{$key}/messages.php");
        $items = include $path;
        foreach($fa_items as $fa_item_key => $fa_item_value){
            if(!array_key_exists($fa_item_key, $items)){
                $items[$fa_item_key] = '';
            }
        }
        return $items;
    }

    public function update(Request $request, $key){
        $path = '../resources/lang/'.$request->titleOfLanguage;
        $fa_items = $this->fa_items();
        $inputs = $request->all();
        ob_start();
        echo 
"<?php

    return [";
    foreach($fa_items as $fa_key => $fa_value){
        $value = (array_key_exists($fa_key, $inputs)) ? str_replace('\'','',$inputs[$fa_key]) : '';
        echo "
        '{$fa_key}' => '{$value}',";
    }
echo "];";
        
        file_put_contents($path.'/messages.php', ob_get_contents());
        ob_get_clean();
        $this->generateJS();
        return [
            'result' => 'success',
            'message' => trans('language_updated'),
        ];
    }
}
