<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTermsToPermissionGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permission_groups', function (Blueprint $table) {
            $table->boolean('send_sms_by_city');
            $table->boolean('send_sms_by_occupation');
            $table->boolean('send_sms_by_postal_code');
            $table->boolean('send_sms_by_gender');
            $table->boolean('send_sms_by_map');
            $table->boolean('send_sms_by_brand');
            $table->boolean('send_international_sms');
            $table->boolean('report_for_sms');
            $table->boolean('receive_sms');
            $table->boolean('deleted_sms');
            $table->boolean('contacts_group');
            $table->boolean('contacts_contacts');
            $table->boolean('contacts_contacts_list');
            $table->boolean('contacts_removed');
            $table->boolean('tools_send_from_mobile');
            $table->boolean('tools_poll');
            $table->boolean('tools_polls_list');
            $table->boolean('tools_auto_answer');
            $table->boolean('tools_auto_answer_list');
            $table->boolean('tools_barcode');
            $table->boolean('tools_pretext');
            $table->boolean('tools_blacklist');
            $table->boolean('tools_backup');
            $table->boolean('tools_send_to_email');
            $table->boolean('tools_recieve_setting');
            $table->boolean('financial_charge');
            $table->boolean('financial_receipt');
            $table->boolean('financial_transactions');
            $table->boolean('financial_credit_report');
            $table->boolean('shop_buy_lines');
            $table->boolean('shop_buy_modules');
            $table->boolean('shop_extend_lines');
            $table->boolean('shop_special_plans');
            $table->boolean('support_ticket');
            $table->boolean('support_online_backup');
            $table->boolean('support_about_us');
            $table->boolean('support_contact_us');
            $table->boolean('support_our_services');
            $table->boolean('support_faq');
            $table->boolean('support_marketing');
            $table->boolean('user_profile');
            $table->boolean('user_webservice');
            $table->boolean('user_security_report');
            $table->boolean('user_create_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permission_groups', function (Blueprint $table) {
            $table->dropColumn('send_sms_by_city');
            $table->dropColumn('send_sms_by_occupation');
            $table->dropColumn('send_sms_by_postal_code');
            $table->dropColumn('send_sms_by_gender');
            $table->dropColumn('send_sms_by_map');
            $table->dropColumn('send_sms_by_brand');
            $table->dropColumn('send_international_sms');
            $table->dropColumn('report_for_sms');
            $table->dropColumn('receive_sms');
            $table->dropColumn('deleted_sms');
            $table->dropColumn('contacts_group');
            $table->dropColumn('contacts_contacts');
            $table->dropColumn('contacts_contacts_list');
            $table->dropColumn('contacts_removed');
            $table->dropColumn('tools_send_from_mobile');
            $table->dropColumn('tools_poll');
            $table->dropColumn('tools_polls_list');
            $table->dropColumn('tools_auto_answer');
            $table->dropColumn('tools_auto_answer_list');
            $table->dropColumn('tools_barcode');
            $table->dropColumn('tools_pretext');
            $table->dropColumn('tools_blacklist');
            $table->dropColumn('tools_backup');
            $table->dropColumn('tools_send_to_email');
            $table->dropColumn('tools_recieve_setting');
            $table->dropColumn('financial_charge');
            $table->dropColumn('financial_receipt');
            $table->dropColumn('financial_transactions');
            $table->dropColumn('financial_credit_report');
            $table->dropColumn('shop_buy_lines');
            $table->dropColumn('shop_buy_modules');
            $table->dropColumn('shop_extend_lines');
            $table->dropColumn('shop_special_plans');
            $table->dropColumn('support_ticket');
            $table->dropColumn('support_online_backup');
            $table->dropColumn('support_about_us');
            $table->dropColumn('support_contact_us');
            $table->dropColumn('support_our_services');
            $table->dropColumn('support_faq');
            $table->dropColumn('support_marketing');
            $table->dropColumn('user_profile');
            $table->dropColumn('user_webservice');
            $table->dropColumn('user_security_report');
            $table->dropColumn('user_create_user');
        });
    }
}
