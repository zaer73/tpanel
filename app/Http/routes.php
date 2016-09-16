<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'web'], function(){

	Route::get('/', ['middleware' => 'auth', function(){
		return view('pages.homepage');
	}])->name('homepage');

	// Users Area START
	Route::group(['prefix' => 'users'], function(){
		Route::get('login', 'GuestController@getLogin')->name('users.login');
		Route::post('login', 'GuestController@postLogin');


		Route::get('registration-payment', 'UserController@RegistrationPayment')->name('users.registrationPayment');
		Route::get('signup/{domain?}', 'GuestController@getSignup')->name('users.signup');
		Route::post('signup/{domain?}', 'GuestController@postSignup');
		Route::post('choose-plan/{domain?}', 'GuestController@postChoosePlan')->name('users.choosePlan');
		Route::get('change-plan/{domain?}', 'GuestController@changePlan')->name('users.changePlan');

		Route::get('reset-password', 'GuestController@getResetPassword')->name('users.resetPassword');
		Route::post('reset-password', 'GuestController@postResetPassword');
		Route::post('reset-password/mobile', 'GuestController@postResetPasswordByMobile')->name('users.resetPassword.mobile');

		Route::get('secure-login', 'GuestController@getSecureLogin')->name('users.secureLogin');
		Route::post('secure-login', 'GuestController@postSecureLogin');
		Route::get('secure-login/form', 'GuestController@getSecureLoginForm')->name('users.secureLogin.form');
		Route::post('secure-login/form', 'GuestController@postSecureLoginForm');

		Route::get('login-by/{user}', 'UserController@loginBy')->name('users.loginBy')->where('user', '[0-9]+');

		Route::put('toggle-status/{id}', 'UserController@toggleStatus')->where('user', '[0-9]+');
		Route::put('toggle-role/{id}', 'UserController@toggleRole')->where('user', '[0-9]+');

		Route::get('logout', 'UserController@getLogOut')->name('users.logout');

		Route::put('profile/{id?}', 'ProfileController@editProfile');
		Route::put('profile/{id}/{type}', 'ProfileController@updateProfile');
		Route::resource('profile', 'ProfileController'); // profile controller 

		Route::resource('setting/gateway', 'BankGatewayController');
		Route::resource('setting', 'SettingController'); // setting controller 

		Route::resource('report', 'UserReportController'); // report controller 

		Route::resource('credit', 'CreditController'); // credit controller

		Route::resource('lawyer', 'LawyerController'); // lawyer controller

	});
	Route::resource('users', 'UserController'); // define RESTful users/ path
	//Users Area END
	
	Route::group(['middleware' => '\App\Http\Middleware\API'], function(){

		Route::group(['prefix' => 'api'], function(){
			Route::get('info', 'APIController@getInfo');
			Route::group(['prefix' => 'users'], function(){
				Route::post('user-info', 'APIController@getUserInfo');
				Route::post('birth-info', 'APIController@getBirthInfo');
				Route::post('settings', 'SettingController@api');
				Route::post('report', 'UserReportController@api');
				Route::post('credit/{id}', 'CreditController@api')->where('id', '[0-9]+');
				Route::post('role', 'APIController@getUserRole');
				Route::get('agents', 'APIController@getAgents');
				Route::get('users', 'APIController@getUsers');
				Route::get('available-to-parent/{id}', 'APIController@getAvailableParents');
				Route::post('change-parent', 'APIController@postChangeParent');
			});
			Route::group(['prefix' => 'permissions'], function(){
				Route::post('groups', 'PermissionGroupController@api');
			});
			Route::group(['prefix' => 'rahyabbulk'], function(){
				Route::get('provinces', 'APIController@getProvinces');
				Route::get('cities', 'APIController@getCities');
				Route::post('count', 'APIController@getCount');
			});
			Route::post('operators', 'APIController@getOperators');
		});	

		//Permission Groups
		Route::resource('permissions/groups', 'PermissionGroupController');

		//single user permission 
		Route::resource('permissions/user', 'PermissionController');
		Route::put('permissions/user/{id}/group', 'PermissionController@groupToUser')->name('permissions.user.group')->where('id', '[0-9]+');

		//Lines
		
		Route::group(['prefix' => 'lines'], function(){
			Route::get('to-user/{user}', 'LineController@getToUser')->name('lines.toUser')->where('user', '[0-9]+');
			Route::post('to-user/{user}', 'LineController@postToUser')->where('user', '[0-9]+');
			Route::get('to-user', 'LineController@giftToUser');
			Route::get('import', 'LineController@getImport')->name('lines.import');
			Route::post('import', 'LineController@postImport');
			Route::get('to-send', 'LineController@toSend');
			Route::put('toggle-general', 'LineController@toggleGeneral');
			Route::put('toggle-shoppable', 'LineController@toggleShoppable');
			Route::put('toggle-notifier', 'LineController@toggleNotifier');
			Route::put('toggle-owner/{type}', 'LineController@toggleOwner');
		});
		Route::resource('lines', 'LineController');
		

		//News
		Route::resource('news', 'NewsController');

		// SMS Routes
		Route::group(['prefix' => 'sms'], function(){
			Route::post('send/to', 'SMSController@sendSingle')->name('sms.send.single');
			Route::post('send/to/group', 'SMSController@sendGroup')->name('sms.send.group');
			Route::post('send/to/city', 'SMSController@sendCity');
			Route::post('send/to/occupation', 'SMSController@sendOccupation');
			Route::post('send/to/postal-code', 'SMSController@sendPostalCode');
			Route::post('send/to/gender', 'SMSController@sendGender');
			Route::get('list/gender', 'SMSController@genderList');
			Route::delete('gender/remove/{id}', 'SMSController@removeGender');
			Route::post('send/to/brand', 'SMSController@sendBrand');
			Route::post('send/to/map', 'SMSController@sendMap');
			Route::post('send/to/international', 'SMSController@sendInternational');
			Route::post('test', 'SMSController@sendTest');
			Route::post('retry', 'SMSController@retry');

			Route::post('resend', 'SMSController@resend')->name('sms.resend');

			Route::group(['prefix' => 'delete'], function(){
				Route::delete('sent/{msg}', 'SMSController@deleteSent')->name('sms.delete.sent');
				Route::delete('destroy/{msg}', 'SMSController@destroy')->name('sms.destroy');
			});

			Route::post('restore/{msg}', 'SMSController@restore')->name('sms.restore');
			
			Route::group(['prefix' => 'report'], function(){
				Route::get('/', 'SMSReportController@index')->name('sms.report.index');
				Route::get('group/{id}', 'SMSReportController@getGroup')->name('sms.report.group');
				Route::get('received', 'SMSReportController@received')->name('sms.report.received');
				Route::get('trash', 'SMSReportController@trash')->name('sms.report.trash');
				Route::delete('received/{id}', 'SMSReportController@deleteReceived');
			});

			Route::post('schedules/enable', 'ScheduleController@enable');
			Route::post('schedules/disable', 'ScheduleController@disable');
			Route::resource('schedules', 'ScheduleController');

			Route::post('import-contacts', 'SMSController@importGroupSMSContacts');

			Route::resource('default-messages', 'DefaultMessageController');

			Route::get('input/{id}', 'SMSController@getInfo');

			Route::controller('map', 'MapController');
		});

		//price group
		Route::get('price-group/api', 'PriceGroupController@api');
		Route::put('price-group/user/{id}', 'PriceGroupController@toUser');
		Route::resource('price-group', 'PriceGroupController');

		// customization
		
		// Route::get('customization/about-us', 'CustomizationController@getAboutUs');
		// Route::get('customization/contact-us', 'CustomizationController@getContactUs');
		Route::post('customization/logo/upload', 'CustomizationController@uploadLogo');
		Route::resource('customization', 'CustomizationController');

		// pre-defined text groups
		Route::resource('pre-texts/group', 'PreTextGroupController');
		// pre-defined texts
		Route::get('pre-texts/api', 'PreTextController@api');
		Route::resource('pre-texts', 'PreTextController');

		// numbers bank
		Route::group(['prefix' => 'numbers-bank'], function(){
			Route::get('define', 'NumberBankController@getDefine')->name('numbersBank.define.cities');
			Route::post('define', 'NumberBankController@postDefine');
			Route::get('count/{id}', 'NumberBankController@getCount');
			Route::get('{id}/edit', 'NumberBankController@edit');
			Route::post('import', 'NumberBankController@import');

			Route::post('cities', 'NumberBankController@apiCities');

			// Route::get('define/occupation', 'NumberBankController@getOccupation')->name('numbersBank.define.occupation');
			// Route::post('define/occupation', 'NumberBankController@postOccupation');
		});

		Route::resource('numbers-bank', 'NumberBankController');

		Route::get('occupations/api', 'OccupationController@api');
		Route::get('occupations/count/{id}', 'OccupationController@getCount');
		Route::resource('occupations', 'OccupationController');

		Route::get('postal-code/api', 'PostalCodeController@api');
		Route::resource('postal-code', 'PostalCodeController');

		Route::resource('brands', 'BrandController');

		Route::resource('nations', 'NationController');



		Route::group(['prefix' => 'contacts'], function(){
			Route::group(['prefix' => 'trash'], function(){
				Route::get('/', 'ContactController@getTrashed')->name('contacts.trashed');
				Route::post('restore/{contact}', 'ContactController@restore')->name('contacts.trash.restore');
				Route::post('explode/{contact}', 'ContactController@explode')->name('contacts.trash.explode');
			});
			Route::post('import', 'ContactController@import');
			Route::resource('groups', 'ContactGroupController');
			Route::resource('contact', 'ContactController');
		});


		Route::resource('polls', 'PollController');

		Route::put('autoreplies/enable/{id}', 'AutoreplyController@enable')->name('autoreplies.enable');
		Route::delete('autoreplies/trash/{id}', 'AutoreplyController@trash')->name('autoreplies.trash');
		Route::resource('autoreplies', 'AutoreplyController');

		// code reader
		Route::put('codereaders/enable/{id}', 'CodeReaderController@enable')->name('codereaders.enable');
		Route::delete('codereaders/trash/{id}', 'CodeReaderController@trash')->name('codereaders.trash');
		Route::resource('codereaders', 'CodeReaderController');

		// send from mobile
		Route::resource('send-from-mobile', 'SendFromMobileController');

		// black list
		Route::resource('blacklist', 'BlackListController');

		// receive sms
		Route::get('receive-sms', 'LineController@getReceivers');
		Route::get('receive-sms/{id}', 'LineController@getReceiver');
		Route::put('receive-sms/{id}', 'LineController@putReceivers');
		Route::delete('receive-sms/{id}', 'LineController@deleteReceivers');

		//transfer to email
		Route::resource('transfer-to-email', 'TransferToEmailController');

		Route::get('modules/api', 'ModuleController@api');
		Route::put('modules/enable/{id}', 'ModuleController@enable');
		Route::resource('modules', 'ModuleController');

		Route::put('specials/enable/{id}', 'SpecialController@enable');
		Route::delete('specials/disable/{id}', 'SpecialController@disable');
		Route::resource('specials', 'SpecialController');

		Route::put('plans/enable/{id}', 'PlanController@enable');
		Route::delete('plans/disable/{id}', 'PlanController@disable');
		Route::resource('plans', 'PlanController');

		Route::resource('filterings', 'FilteringController');

		Route::resource('faqs', 'FaqController');

		Route::resource('charges', 'ChargeController');

		Route::resource('fluent-credits/groups', 'FluentCreditGroupController');
		Route::resource('fluent-credits', 'FluentCreditController');

		Route::resource('marketing-codes', 'MarketingCodeController');

		Route::resource('languages', 'LanguageController');

		Route::resource('backup', 'BackupController');


		Route::group(['prefix' => 'shop'], function(){
			Route::group(['prefix' => 'lines'], function(){
				Route::get('list', 'ShopController@getLineList');
				Route::get('extension/list', 'ShopController@getExtensionList');
				Route::post('add-to-invoice', 'ShopController@addLineToInvoice');
			});
			Route::group(['prefix' => 'modules'], function(){
				Route::get('list', 'ShopController@getModulesList');
				Route::post('add-to-invoice', 'ShopController@addModuleToInvoice');
				Route::delete('remove-from-invoice/{id}', 'ShopController@removeModuleFromInvoice');
			});
			Route::group(['prefix' => 'specials'], function(){
				Route::get('list', 'ShopController@getSpecialsList');
			});
			Route::group(['prefix' => 'charge'], function(){
				Route::group(['prefix' => 'upgrade'], function(){
					Route::post('code', 'ShopController@upgradeByCode');
					Route::get('fluent-credits', 'FluentCreditController@getForUser');
					Route::post('cash', 'ShopController@upgradeByCash');
				});
			});
		});

		Route::group(['prefix' => 'financial'], function(){
			Route::group(['prefix' => 'invoice'], function(){
				Route::get('/', 'FinancialController@getInvoice');
				Route::post('offline-checkout', 'FinancialController@offlineCheckout');
			});
			Route::group(['prefix' => 'checkout'], function(){
				Route::get('gateways', 'FinancialController@getGateways');
				Route::any('moving-to-gateway', 'FinancialController@movingToGateway');
				Route::get('unsuccessful/{error}', 'FinancialController@unsuccessful')->name('checkout.unsuccessful');
				Route::get('successful', 'FinancialController@successful')->name('checkout.successful');
				Route::post('callback', 'FinancialController@callback')->name('checkout.callback');
			});
			Route::get('transactions', 'FinancialController@getTransactions');
			Route::get('report', 'FinancialController@getReport');
			Route::group(['prefix' => 'bill'], function(){
				Route::post('create', 'FinancialController@postBill');
				Route::get('report', 'FinancialController@getBillReport');
			});
		});

		Route::group(['prefix' => 'support'], function(){
			Route::delete('tickets/cancel/{id}', 'TicketController@cancel');
			Route::get('tickets/dashboard', 'TicketController@getDashboard');
			Route::resource('tickets', 'TicketController');

			Route::post('chat/new-message', 'ChatController@postNewMessage')->name('chat.newMessage');
			Route::get('chat/with/{id}', 'ChatController@getChat');
			Route::get('chat/chats', 'ChatController@getChats');
		});

		Route::resource('line-patterns', 'LinePatternController');

		Route::group(['prefix' => 'dashboard'], function(){
			Route::get('/', 'DashboardController@index');
		});

		Route::group(['prefix' => 'admin'], function(){
			Route::post('logo/upload', 'AdminController@uploadLogo');
			Route::get('info', 'AdminController@getInfo');
			Route::put('update', 'AdminController@update');
		});

	});

	Route::group(['prefix' => 'financial'], function(){
		Route::group(['prefix' => 'checkout'], function(){
			Route::get('gateways', 'FinancialController@getGateways');
			Route::any('moving-to-gateway', 'FinancialController@movingToGateway');
			Route::get('unsuccessful/{error}', 'FinancialController@unsuccessful')->name('checkout.unsuccessful');
			Route::get('successful', 'FinancialController@successful')->name('checkout.successful');
			Route::post('callback', 'FinancialController@callback')->name('checkout.callback');
		});
	});

	Route::get('admin/loginToUser/{id}', 'AdminController@getLoginToUser');
	Route::get('admin/loginGoBack', 'AdminController@getGoBack');

	Route::get('sms/send/from/lumen', 'APIController@sendAutoreply');

	Route::get('polls/export/{id}', 'PollController@export');

});



Route::group(['middleware' => 'api', 'prefix' => 'api'], function(){
	Route::post('send-sms', '\App\Http\Controllers\IncomingAPIController@postSendSMS');
	Route::post('get-credit', '\App\Http\Controllers\IncomingAPIController@getCredit');
	Route::post('receive', '\App\Http\Controllers\IncomingAPIController@receive');
	Route::post('send-group-sms', '\App\Http\Controllers\IncomingAPIController@postSendGroupSMS');
	Route::post('gender/send', '\App\Http\Controllers\IncomingAPIController@postSendGenderSMS');
	Route::post('gender/count', '\App\Http\Controllers\IncomingAPIController@genderCount');
	Route::post('gender/provinces', '\App\Http\Controllers\IncomingAPIController@genderProvince');
	Route::post('gender/cities', '\App\Http\Controllers\IncomingAPIController@genderCities');

	Route::any('{any}', '\App\Http\Controllers\IncomingAPIController@notFound');
});

Route::get('make-api-call', function(){
	
	include('../app/API/Container/APIContainer.php');

	// Send_SMS('50001276145267', '09379010826', 'hello');
	// apiCredit();
	// apiReceive(375);
	// apiGenderCities(4);
});
 //    $ch = curl_init();
 //    curl_setopt($ch, CURLOPT_URL, $url);
 //    curl_setopt($ch, CURLOPT_HEADER, 0);
 //    curl_setopt($ch, CURLOPT_POST, 1); 
 //    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	// curl_exec($ch);
 //    curl_close($ch);


// DB::listen(function($query){
// 	echo '<br><br><br>';
// 	echo $query->sql;
// 	echo '<br><br><br>';
// 	dump($query->time);
// 	echo '<br><br><br>';
// 	dump($query->bindings);
// });