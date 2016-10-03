<?php

/*

    These functions are not available out of the box 
    Added by TPANEL

 */

if (!function_exists('isAdmin')){
    /**
     * checks if user is admin
     *
     * @param  object  $user
     * @return string
     */
    
    function isAdmin($user){
        return ($user->role == 2);
    }
}

if (!function_exists('isAgent')){
    /**
     * checks if user is agent
     *
     * @param  object  $user
     * @return string
     */
    
    function isAgent($user){
        return ($user->role == 1);
    }
}

if (!function_exists('isLawyer')){
    /**
     * checks if user is lawyer
     *
     * @param  object  $user
     * @return string
     */
    
    function isLawyer($user){
        return ($user->role == 3);
    }
}

if (!function_exists('userRole')){
    /**
     * returns user's role
     *
     * @param  object  $user
     * @return string
     */
    
    function userRole($user){
        if($user->role == 1){
            return 'agent';
        }
        if($user->role == 2){
            return 'admin';
        }
        return 'user';
    }
}

if (!function_exists('activateUserLink')) {

    /**
     * Return suitable link according to user's active status
     *
     * @param  object  $user
     * @return string
     */
    function activateUserLink($user){
        if($user->active == 1) {
            return '<a href="#">' . trans('users_list_deactivate') . '</a>';
        }
        return '<a href="#">' . trans('users_list_activate') . '</a>';
    }
}

if (!function_exists('changeUsersRoleLink')) {

    /**
     * Return suitable link according to user's role status
     *
     * @param  object  $user
     * @return string
     */
    
    function changeUsersRoleLink($user){
        if($user->role == 0) {
            return '<a href="#">' . trans('users_list_to_agent') . '</a>';
        }
        if($user->role == 1) {
            return '<a href="#">' . trans('users_list_to_user') . '</a>';
        }
    }
}

if (!function_exists('online_status')){

    /**
     * Return suitable status according to users login and logout time
     *
     * @param  object  $user
     * @return string
     */
    function online_status($user){
        if(isset($user->last_logout) && 
            ($user->last_logout > $user->last_login 
            || strtotime('now') > strtotime($user->last_login) + 2*3600)
        ) return trans('offline');
        return trans('online');
    }
}

if(!function_exists('jalali')){

    /**
     * Returns Jalali date and time
     *
     * @param timestamp $date timestamp you wish to translate
     * @param boolean $time true if you want time and date together
     * @param boolean $just_year true if you want to return just year
     * @return string
     */
    function jalali($date, $format=null, $time=false){
        return \App\Jalali::stampToDate($date, $format, $time);
    }
}

if(!function_exists('checkbox')){

    /**
     * Returns checked if input value is true
     *
     * @param boolean $checked
     * @return string
     */
    
    function checkbox($checked){
        if($checked) return 'checked="checked"';
    }
}

if(!function_exists('selected')){

    /**
     * Returns selected if input value is true
     *
     * @param boolean $checked
     * @return string
     */
    
    function selected($selected){
        if($selected) return 'selected="selected"';
    }
}

if(!function_exists('sms_status')){

    /**
     * Returns appropriate status for sms using its status number
     *
     * @param object $msg
     * @return string
     */
    function sms_status($status, $trashed){
        if($status == 1) return trans('sms_status_successful');
        if($status == 0) return trans('sms_status_pending');
        return trans('sms_status_unsuccessful');
    }
}

if(!function_exists('sms_type')){

    /**
     * Returns appropriate type for sms using its type number
     *
     * @param int $type
     * @return string
     */
    function sms_type($type){
        if($type == 0) return trans('sms_type_single');
        if($type == 1) return trans('sms_type_group');
        if($type == 2) return trans('sms_type_mass');
        return trans('sms_type_resend');
    }
}

if(!function_exists('trashed_sms_type')){

    /**
     * Returns appropriate type for trashed sms using its type number
     *
     * @param int $type
     * @return string
     */
    function trashed_sms_type($type){
        if($type == 0) return trans('sms_type_sent');
        return trans('sms_type_received');
    }
}

if(!function_exists('reaction_type')){

    /**
     * Returns appropriate type for autoreply reaction using its type number
     *
     * @param int $type
     * @return string
     */
    function reaction_type($type){
        if($type == 1) return trans('autoreply_reaction_add_to_group');
        if($type == 2) return trans('autoreply_reaction_remove_from_group');
        return trans('autoreply_reaction_reply');
    }
}

if(!function_exists('condition_type')){

    /**
     * Returns appropriate condition for autoreply using its condition number
     *
     * @param int $type
     * @return string
     */
    function condition_type($condition){
        if($condition == 1) return trans('autoreply_condition_anything');
        return trans('autoreply_condition_containing');
    }
}

if(!function_exists('setting')){

    /**
     * Returns appropriate setting value for given key
     *
     * @param string $key
     * @return string
     */
    function setting($key=null){
        // $redis = Redis::connection();
        // $settings = $redis->get('admin_settings');
        // if(!$settings || !unserialize($settings)){
            $settings = App\AdminSetting::all()->lists('value', 'key')->toArray();
            $settings = serialize($settings);
        //     $redis->set('admin_settings', $settings);
        // }
        $settings = unserialize($settings);
        if(empty($key)) return $settings;
        return (array_key_exists($key, $settings)) ? $settings[$key] : '';
    }
}

if(!function_exists('site_title')){

    /**
     * Returns appropriate site title according to site's language
     *
     * @return string
     */
    function site_title(){
        $site_lang = site_language();
        return setting('site_title_' . $site_lang);
    }
}

if(!function_exists('site_language')){

    /**
     * Returns site's language key
     *
     * @return string
     */
    function site_language(){
        $site_lang = setting('site_lang');
        return $site_lang;
    }
}

if(!function_exists('show_errors')){

    /**
     * Returns alerts to show as errors
     *
     * @return string
     */
    function show_errors($errors){
        if(count($errors) <= 0) return;
        $return = '
            <div class="alert alert-danger">
                <ul>
            ';
        foreach($errors->all() as $error){
            $return .= '<li>' . $error . '</li>';
        }
        $return .= '</ul></div>';
        return $return;
    }
}

if(!function_exists('rtl_style')){

    /**
     * Returns appropriate stylesheet according to language
     *
     * @return string
     */
    function rtl_style(){
        $rtl_langs = setting('rtl_langs');
        $rtl_langs = unserialize($rtl_langs);
        $site_language = site_language();
        if(in_array($site_language, $rtl_langs)){
            return '<link rel="stylesheet" type="text/css" href="' . asset('css/rtl.css') . '">';
        }
    }
}

if(!function_exists('permissions')){

    /**
     * Returns user's permissions
     * @param  $user User object
     * @return string
     */
    function permissions($user, $allowed=false){
        if(!$user->permissions){
            $user->permissions()->create(Cons::$permissions);
        }
        $changablePermissions = $user->permissions()->get()->toArray()[0];
        $role = userRole($user);
        $roleBasedPermissions = Cons::$roleBasedPermissions[$role];
        $result = array_merge($changablePermissions, $roleBasedPermissions);
        if(userRole(Auth::user()) == 'admin'){
            $permissions = array_fill(0, count($result), 1);
            return array_combine(array_keys($result), $permissions);
        }
        if ($allowed) {
            $filtered = collect($result)->reject(function ($value, $key) {
                return $value != 1;
            });

            return $filtered->all();
        }
        return $result;
    }
}

if(!function_exists('total_cost')) {

    function total_cost($numbers, $text, $smart=false, $international=false, $user=null){
        if(empty($user)) $user = Auth::user();
        if( !$user ) return 0;
        $total = 0;
        $line_patterns = \App\LinePattern::all();
        $price_groups = \App\PriceGroup::first();
        if(!$price_groups){
            die(json_encode([
                'result' => 'exception',
                'errors' => trans('you_cant_send_messages')
            ]))
            ;
        }
        $gender_property = 'gender_'.sms_type_prefix($text, $smart);
        $gender_fee = $price_groups->{$gender_property};
        $price_groups = $price_groups->toArray();
        if(!$user->unit_fee){
            $basePrice = \App\AdminSetting::where('key', 'sms_base_price')->first()->value;
        } else {
            $basePrice = $user->unit_fee;
        }
        if(is_int($numbers)) return $gender_fee*$numbers;
        foreach($numbers as $number){
            $type = sms_type_prefix($text, $smart);
            $matched = false;
            if($international){
                $total = $total + /*$basePrice**/$price_groups['international'];
                // continue;
            }
            foreach($line_patterns as $pattern){
                if(preg_match("/^{$pattern->pattern}/", $number)){
                    $total = 0;
                    $total = $total + /*$basePrice**/$price_groups[$pattern->key.'_'.$type];
                    $matched = true;
                    break;
                }
            }
            if(!$matched){
                $total = $total + 1;
            }
        }
        return $total;
    }
}

if(!function_exists('sms_type_prefix')){
    function sms_type_prefix($text, $smart){
        if($smart) return 'smr';
        $firstWord = explode(' ', trim($text))[0];
        if(preg_match('/[ا-ی]/', $firstWord)){  
            return 'reg';
        }
        return 'lat';
    }
}

if(!function_exists('admin_id')){
    function admin_id(){
        return \App\User::select('id')->whereRole(2)->first()->id;
    }
}

if(!function_exists('parent_id')){
    function parent_id($user){
        if(userRole($user) == 'user') return $user->parent;
        if(userRole($user) == 'agent') return admin_id();
    }
}

if(!function_exists('supervisor_id')){
    function supervisor_id($user){
        if(userRole($user) == 'user') return $user->agent_id;
        if(userRole($user) == 'agent') return admin_id();
    }
}

if(!function_exists('sms_fee')){
    function sms_fee($cash, $user){
        $user = ( empty($user) ) ? Auth::user() : $user;
        $parent = parent_id($user);
        if(!$user->custom_fluent_group){
            $fluent_credits = \App\FluentCredit::whereGroupId($user->group_id)->lists('fee', 'ceil')->toArray();
        } else {
            $fluent_credits = \App\FluentCreditUser::where('group_hash', $user->custom_fluent_group)->lists('fee', 'ceil')->toArray();
        }
        $sms_fee = 0;
        $length = count($fluent_credits);
        foreach($fluent_credits as $ceil => $fee){
            if($cash <= $ceil) {
                $sms_fee = $fee;
                break;
            } else {
                $to_sort = $fluent_credits;
                rsort($to_sort);
                $sms_fee = $to_sort[$length-1];
            }
        }
        if($sms_fee == 0){
            $sms_fee = \App\AdminSetting::where('key', 'sms_base_price')->first()->value;
        }
        return $sms_fee;
    }
}

if(!function_exists('time_difference')){

    function time_difference($time){
        if(!$time) return 0;
        if(strtotime($time) < 0){
            $time = strtotime(shamsi_to_greg($time));
        }
        $now = strtotime('now');
        $diff = $time - $now;
        if($diff < 0) return 0;
        return $diff;
    }
}

if(!function_exists('shamsi_to_greg')){

    function shamsi_to_greg($date){
        if(strtotime($date) > 0 || empty($date)) {
            return $date;
        }
        $date = str_replace(['AM', 'PM'], '', $date);
        $exploded = explode(' ', $date);
        $monthes = $exploded[0];
        $clock = $exploded[1];
        $monthes = explode('-', $monthes);
        $year = $monthes[0];
        $month = $monthes[1];
        $day = $monthes[2];
        $clock = explode(':', $clock);
        $hour = $clock[0];
        $minute = $clock[1];
        $sec = $clock[2];
        return \App\Jalali::toStamp($day, $month, $year, $hour, $minute, $sec);
    }
}
