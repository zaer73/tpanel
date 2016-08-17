<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use \App\User, \App\Permission;
use Auth;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }



    public function send_single_sms(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->send_single_sms);
    }


    public function send_group_sms(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->send_group_sms);
    }


    public function send_sms_by_city(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->send_sms_by_city);
    }


    public function send_sms_by_occupation(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->send_sms_by_occupation);
    }


    public function send_sms_by_postal_code(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->send_sms_by_postal_code);
    }


    public function send_sms_by_gender(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->send_sms_by_gender);
    }


    public function send_sms_by_map(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->send_sms_by_map);
    }


    public function send_sms_by_brand(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->send_sms_by_brand);
    }


    public function send_international_sms(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->send_international_sms);
    }


    public function report_for_sms(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->report_for_sms);
    }


    public function receive_sms(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->receive_sms);
    }


    public function deleted_sms(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->deleted_sms);
    }


    public function contacts_group(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->contacts_group);
    }


    public function contacts_contacts(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->contacts_contacts);
    }


    public function contacts_contacts_list(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->contacts_contacts_list);
    }


    public function contacts_removed(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->contacts_removed);
    }


    public function tools_send_from_mobile(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->tools_send_from_mobile);
    }


    public function tools_poll(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->tools_poll);
    }


    public function tools_polls_list(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->tools_polls_list);
    }


    public function tools_auto_answer(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->tools_auto_answer);
    }


    public function tools_auto_answer_list(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->tools_auto_answer_list);
    }


    public function tools_barcode(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->tools_barcode);
    }


    public function tools_pretext(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->tools_pretext);
    }


    public function tools_blacklist(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->tools_blacklist);
    }


    public function tools_backup(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->tools_backup);
    }


    public function tools_send_to_email(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->tools_send_to_email);
    }


    public function tools_recieve_setting(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->tools_recieve_setting);
    }


    public function financial_charge(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->financial_charge);
    }


    public function financial_receipt(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->financial_receipt);
    }


    public function financial_transactions(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->financial_transactions);
    }


    public function financial_credit_report(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->financial_credit_report);
    }


    public function shop_buy_lines(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->shop_buy_lines);
    }


    public function shop_buy_modules(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->shop_buy_modules);
    }


    public function shop_extend_lines(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->shop_extend_lines);
    }


    public function shop_special_plans(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->shop_special_plans);
    }


    public function support_ticket(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->support_ticket);
    }


    public function support_online_backup(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->support_online_backup);
    }


    public function support_about_us(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->support_about_us);
    }


    public function support_contact_us(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->support_contact_us);
    }


    public function support_our_services(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->support_our_services);
    }


    public function support_faq(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->support_faq);
    }


    public function support_marketing(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->support_marketing);
    }


    public function user_profile(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->user_profile);
    }


    public function user_webservice(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->user_webservice);
    }


    public function user_security_report(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->user_security_report);
    }


    public function user_create_user(User $user, Permission $permission){
        return (userRole($user) == 'admin' || $permission->user_create_user);
    }
}
