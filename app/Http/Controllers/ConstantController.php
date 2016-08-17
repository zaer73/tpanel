<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ConstantController extends Controller
{
	// this array is defined to generate panel's sidebar. 
	// title is the key defiend in messages.php file to localize 
	// and route is name of the route that link points to
    public static $sidebar = [
    	'users' => [
    		'title' => 'sidebar_users',
    		'route' => 'users.index'
    	],
    	'create_user' => [
    		'title' => 'sidebar_create_user',
    		'route' => 'users.create'
    	],
        'profile' => [
            'title' => 'sidebar_profile',
            'route' => 'users.profile.index'
        ],
        'settings' => [
            'title' => 'sidebar_settings',
            'route' => 'users.setting.index'
        ],
        'reports' => [
            'title' => 'sidebar_reports',
            'route' => 'users.report.index'
        ],
        'permission_groups' => [
            'title' => 'sidebar_permission_group',
            'route' => 'permissions.groups.index'
        ],
        'lines' => [
            'title' => 'sidebar_lines',
            'route' => 'lines.index'
        ]
    ];

    // this function takes $sidebar array and turns title to localized type
    public static function sidebar(){
    	$sidebar = self::$sidebar;
    	foreach($sidebar as $key => $item){
    		$sidebar[$key]['title'] = trans($item['title']);
    	}
    	return $sidebar;
    }

    public static $max_birth_year = 1390;
    public static $min_birth_year = 1330;

    public static $default_settings = [
        'sms_on_login' => 1, 
        'sms_on_ticket' => 1, 
        'sms_balance' => 1
    ];

    public static $permissions = [
        'send_single_sms',
        'send_group_sms',
        'send_sms_by_city',
        'send_sms_by_occupation',
        'send_sms_by_postal_code',
        'send_sms_by_gender',
        'send_sms_by_map',
        'send_sms_by_brand',
        'send_international_sms',
        'report_for_sms',
        'receive_sms',
        'deleted_sms',
        'contacts_group',
        'contacts_contacts',
        'contacts_contacts_list',
        'contacts_removed',
        'tools_send_from_mobile',
        'tools_poll',
        'tools_polls_list',
        'tools_auto_answer',
        'tools_auto_answer_list',
        'tools_barcode',
        'tools_pretext',
        'tools_blacklist',
        // 'tools_backup',
        'tools_send_to_email',
        'tools_recieve_setting',
        'financial_charge',
        'financial_receipt',
        'financial_transactions',
        'financial_credit_report',
        'shop_buy_lines',
        'shop_buy_modules',
        'shop_extend_lines',
        'shop_special_plans',
        'support_ticket',
        'support_online_backup',
        'support_about_us',
        'support_contact_us',
        'support_our_services',
        'support_faq',
        'support_marketing',
        'user_profile',
        'user_webservice',
        'user_security_report',
        'user_create_user',
        // 'mod_define_user',
        // 'mod_users_list',
        // 'mod_news',
        // 'mod_customization',
        // 'mod_lines',
        // 'mod_fees',
        // 'mod_permissions',
        // 'mod_pretexts',
        // 'mod_number_bank',
        // 'mod_sms_report',
        // 'mod_financial_report',
        // 'mod_shop_permission',
        // 'mod_plans',
        // 'mod_backup',
        // 'mod_webservice',
        // 'mod_filtering',
        // 'mod_language',
        // ''
    ];

    public static $price_groups = [
        'talia_reg',
        'talia_lat',
        'talia_rec',
        'talia_smr',
        'spadana_reg',
        'spadana_lat',
        'spadana_rec',
        'spadana_smr',
        'kish_reg',
        'kish_lat',
        'kish_rec',
        'kish_smr',
        'irancell_reg',
        'irancell_lat',
        'irancell_rec',
        'irancell_smr',
        'rightel_reg',
        'rightel_lat',
        'rightel_rec',
        'rightel_smr',
        'hamrah_reg',
        'hamrah_lat',
        'hamrah_rec',
        'hamrah_smr',
        'international',
        'gender_reg',
        'gender_lat'
    ];

    public static function operators(){
        return [
            'talia' => trans('talia'),
            'spadana' => trans('spadana'),
            'kish' => trans('kish'),
            'irancell' => trans('irancell'),
            'rightel' => trans('rightel'),
            'hamrah' => trans('hamrah')
        ];
    }

    // [admin,agent,user]

    public static $roleBasedPermissions = [
        'admin' => [
            'users_list' => 1,
            'users_create' => 1,
            'users_profile' => 1,
            'users_settings' => 1,
            'users_report' => 1,
            'users_credit' => 1,
            'permissions' => 1,
            'lines' => 1,
            'lines_view' => 1,
            'news_create_list' => 1,
            'price_groups' => 1,
            'customization' => 1,
            'numbers_bank' => 1,
            'create_occupations' => 1,
            'create_postal_codes' => 1,
            'managing_modules' => 1,
            'managing_specials' => 1,
            'managing_plans' => 1,
            'managing_filterings' => 1,
            'create_faqs' => 1,
            'create_charges' => 1,
            'marketing_codes' => 1,
            'support_tickets' => 1,
            'support_online' => 1,
            'support_aboutUs' => 1,
            'support_contactUs' => 1,
            'support_ourServices' => 1,
            'support_faq' => 1,
            'support_marketing' => 1,
            'line_patterns' => 1,
            'shop_invoice' => 1,
            'shop_checkout' => 1,
            'fluent_credit' => 1,
            'shop_upgrade_credit' => 1,
            'languages' => 1,
            'backup' => 1,
            'admin_settings' => 1,
            'tools_backup' => 1
        ],
        'agent' => [
            'users_list' => 1,
            'users_create' => 1,
            'users_profile' => 1,
            'users_settings' => 1,
            'users_report' => 1,
            'users_credit' => 0,
            'permissions' => 1,
            'lines' => 0,
            'lines_view' => 1,
            'news_create_list' => 1,
            'price_groups' => 0,
            'customization' => 1,
            'numbers_bank' => 0,
            'create_occupations' => 0,
            'create_postal_codes' => 0,
            'managing_modules' => 1,
            'managing_specials' => 1,
            'managing_plans' => 1,
            'managing_filterings' => 0,
            'create_faqs' => 1,
            'create_charges' => 1,
            'marketing_codes' => 1,
            'support_tickets' => 1,
            'support_online' => 1,
            'support_aboutUs' => 1,
            'support_contactUs' => 1,
            'support_ourServices' => 1,
            'support_faq' => 1,
            'support_marketing' => 1,
            'line_patterns' => 0,
            'shop_invoice' => 1,
            'shop_checkout' => 1,
            'fluent_credit' => 1,
            'shop_upgrade_credit' => 1,
            'languages' => 0,
            'backup' => 0,
            'admin_settings' => 1,
            'tools_backup' => 0
        ],
        'user' => [
            'users_list' => 0,
            'users_create' => 1,
            'users_profile' => 1,
            'users_settings' => 1,
            'users_report' => 1,
            'users_credit' => 0,
            'permissions' => 0,
            'lines' => 0,
            'lines_view' => 0,
            'news_create_list' => 0,
            'price_groups' => 0,
            'customization' => 0,
            'numbers_bank' => 0,
            'create_occupations' => 0,
            'create_postal_codes' => 0,
            'managing_modules' => 0,
            'managing_specials' => 0,
            'managing_plans' => 0,
            'managing_filterings' => 0,
            'create_faqs' => 0,
            'create_charges' => 0,
            'marketing_codes' => 0,
            'support_tickets' => 1,
            'support_online' => 1,
            'support_aboutUs' => 1,
            'support_contactUs' => 1,
            'support_ourServices' => 1,
            'support_faq' => 1,
            'support_marketing' => 1,
            'line_patterns' => 0,
            'shop_invoice' => 1,
            'shop_checkout' => 1,
            'fluent_credit' => 0,
            'shop_upgrade_credit' => 1,
            'languages' => 0,
            'backup' => 0,
            'admin_settings' => 0,
            'tools_backup' => 0
        ],

    ];

    public static function schedules(){
        return [
            trans('every_six_hours'),
            trans('every_12_hours'),
            trans('every_day'),
            trans('every_week'),
            trans('every_month'),
            trans('every_year')
        ];
    }

    public static function week_days(){
        return [
            trans('Saturday'),
            trans('Sunday'), 
            trans('Monday'),
            trans('Tuesday'),
            trans('Wednesday'),
            trans('Thursday'),
            trans('Friday')
        ];
    }

    public static $monthes = [
        'January',
        'February', 
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ];

}
