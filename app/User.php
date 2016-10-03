<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Query\Builder as Builder;
use Auth;
use App\Toolbox\DataTable;

class User extends Authenticatable
{

    use DataTable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'name', 'username', 'email', 'password', 'mobile', 'national_code', 'link_first_name', 'link_last_name', 'submit_code', 'role', 'domain', 'type', 'credit', 'price_groups_id', 'fluent_group_id', 'parent', 'birth_day', 'birth_year', 'birth_month'
    ];
    protected $visible = [
        'first_name', 'last_name', 'name', 'username', 'email', 'mobile', 'national_code', 'link_first_name', 'link_last_name', 'submit_code', 'role', 'domain', 'parentUser', 'last_logout', 'last_login', 'id', 'permissions', 'price_groups_id', 'fluent_group_id', 'status', 'parent', 'plan', 'date_of_birth', 'birth_day', 'birth_year', 'birth_month', 'credit'
    ];


    public function setPasswordAttribute($password){
        $this->attributes['password'] = bcrypt($password);
    }

    public function setRoleAttribute($role){
        if(is_int($role)) {
            return $role;
        }
        if($role == 'admin') {
            $roleToSave = 2;
        } elseif($role == 'agent'){
            $roleToSave = 1;
        } else {
            $roleToSave = 0;
        }
        $this->attributes['role'] = $roleToSave;
    }


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'password', 'remember_token',
    ];


    public function secureLogin(){ // make connection between users and secure logins
        return $this->hasOne('App\SecureLogin');
    }

    public function parentUser(){
        return $this->hasOne('\App\User', 'id', 'parent');
    }

    public function settings(){
        return $this->hasOne('\App\Setting');
    }

    public function permissions(){
        return $this->hasOne('\App\Permission');
    }

    public function permission_groups(){
        return $this->hasMany('App\PermissionGroup');
    }

    public function price_groups(){
        return $this->hasMany('\App\PriceGroup');
    }

    public function news(){
        return $this->hasMany('\App\News');
    }

    public function customization(){
        return $this->hasOne('\App\Customization');
    }

    public function pre_texts(){
        return $this->hasMany('\App\PreText');
    }

    public function pre_text_groups(){
        return $this->hasMany('\App\PreTextGroup');
    }

    public function sms(){
        return $this->hasMany('\App\SMS')->selectRAW('*, COUNT(*) as count')->groupBy('group_hash');
    }

    public function inGroupSMS(){
        return $this->hasMany('\App\SMS');
    }

    public function received(){
        return $this->hasMany('\App\ReceivedSMS')->orderBy('id', 'desc');
    }

    public function trashed(){
        return $this->hasMany('\App\TrashedSMS');
    }

    public function contact_groups(){
        return $this->hasMany('\App\ContactGroup');
    }

    public function contacts(){
        return $this->hasMany('\App\Contact');
    }

    public function deleted_contacts(){
        return $this->hasMany('App\Contact')->where('trashed', 1);
    }

    public function polls(){
        return $this->hasMany('\App\Poll');
    }

    public function lines($noGeneral=false){
        if(isAgent(Auth::user())){
            $lines = $this->hasMany('App\Line', 'agent_id', 'id')
                ->where(function($query){
                    $query->where('user_id', 0)
                        ->whereRaw('agent_expires_at > NOW()');
                });
            if($noGeneral) {
                $lines = $lines->where('general', 0);
            } else {
                $lines = $lines->orWhere('general', 1);
            }
            return $lines;
        }
        $lines = $this->hasMany('App\Line')->whereRaw('user_expires_at > NOW()');
        if($noGeneral) {
            $lines = $lines->where('general', 0);
        } else {
            $lines = $lines->orWhere('general', 1);
        }
        return $lines;
    }

    public function autoreplies(){
        return $this->hasMany('App\Autoreply');
    }

    public function codereaders(){
        return $this->hasMany('App\CodeReader');
    }

    public function blacklists(){
        return $this->hasMany('App\BlackList');
    }

    public function transfers(){
        return $this->hasMany('App\TransferToEmail');
    }

    public function specials(){
        return $this->hasMany('App\Special');
    }

    public function plans(){
        return $this->hasMany('App\Plan');
    }

    public function plan(){
        return $this->hasOne('App\UserPlan')->orderBy('id', 'desc');
    }

    public function filterings(){
        return $this->hasMany('App\Filtering');
    }

    public function faqs(){
        return $this->hasMany('App\Faq');
    }

    public function charges(){
        return $this->hasMany('App\Charge');
    }

    public function marketingCodes(){
        return $this->hasOne('App\MarketingCode');
    }

    public function marketingCodePolicies(){
        return $this->hasOne('App\MarketingCodePolicy');
    }

    public function children(){
        return $this->hasMany('App\User', 'parent', 'id');
    }

    public function tickets(){
        return $this->hasMany('App\Ticket');
    }

    public function priceGroup(){
        return $this->hasOne('App\PriceGroup', 'id', 'price_groups_id');
    }

    public function transactions(){
        return $this->hasMany('App\Transaction');
    }

    public function smsTransactions(){
        return $this->hasMany('App\SMSTransaction');
    }

    public function invoices(){
        return $this->hasMany('App\Invoice');
    }

    public function invoiceTransactionConnection(){
        return $this->hasMany('\App\InvoiceTransactionConnection');
    }

    public function invoice(){
        return $this->hasOne('App\Invoice')->whereStatus(0);
    }

    public function successfulInvoice(){
        return $this->hasOne('App\Invoice')->whereStatus(1)->orderBy('id', 'desc');
    }

    public function payments(){
        return $this->hasMany('App\Payment');
    }

    public function fluentCredits(){
        return $this->hasMany('App\FluentCredit')->whereStatus(0);
    }

    public function schedules(){
        return $this->hasMany('App\Schedule');
    }

    public function defaultMessages(){
        return $this->hasMany('App\DefaultMessage');
    }

    public function apikey(){
        return $this->hasOne('App\APIKey');
    }

    public function bills(){
        return $this->hasMany('App\Bill');
    }

    public function genderSMS(){
        return $this->hasMany('App\GenderSMS');
    }

    public function sendFromMobiles(){
        return $this->hasMany('\App\SendFromMobile');
    }

    public function logins(){
        return $this->hasMany('App\Login')->orderBy('id', 'desc');
    }

    public function fluentCreditGroups(){
        return $this->hasMany('\App\FluentCreditGroup');
    }

    public function userFluentCredit(){
        return $this->hasOne('App\FluentCreditGroup', 'id', 'fluent_group_id');
    }

    public function userCustomFluentCredit(){
        return $this->hasMany('App\FluentCreditUser');
    }

    public function creditUpgrades(){
        return $this->hasMany('App\CreditUpgrade');
    }

    public function generalLines(){
        return $this->hasMany('App\GeneralLine');
    }

    public function modules(){
        return $this->hasMany('App\Module');
    }

    public function registration_payment(){
        return $this->hasOne('App\RegistrationPayment');
    }

    public function lawyers()
    {
        return $this->hasMany('App\Lawyer', 'parent_id', 'id')
            ->with('App\User');
    }

    public function getCreditAttribute($credit)
    {
        return intval($credit);
    }

}
