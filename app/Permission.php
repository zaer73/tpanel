<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cons;

class Permission extends Model
{
    protected $guarded = ['title', 'description', 'user_id', 'id', 'created_at', 'updated_at'];

    protected $hidden = ['created_at', 'updated_at', 'status', 'user_id'];

    protected $fillable = [
        'user_id',
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
        'tools_backup',
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
        'agent_limit',
        'user_limit',
        'lawyer_limit',
    ];
}
