<?php

Auth::routes();

Route::middleware(['auth', 'banned'])->group(function () {
    Route::resource('user', 'UserController');
    Route::get('user/cities/{id}', 'UserController@citiesList')->name('cities_list');
    Route::get('user/{id}/change_password', 'Auth\ChangePasswordController@edit')->name('edit_change_password');
    Route::put('change_password', 'Auth\ChangePasswordController@changePassword')->name('change_password');

    Route::any('/admin/telegram_forced', 'AdminUserController@telegramForced')->name('telegram_forced');
    Route::get('api', 'ApiController')->name('api');
});

Route::middleware(['auth', 'lead.info', 'banned'])->group(function () {

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('ajax/home_page', 'Ajax\HomeController@index');
    Route::put('ajax/lead/take_on_check', 'Ajax\LeadController@takeOnCheck')->middleware('takeLeadOnCHeck')->name('take_on_check');
    Route::get('ajax/lead/get', 'Ajax\LeadController@get')->middleware('takeLeadOnCHeck')->name('get_lead');

    Route::resource('lead', 'LeadController')->only(['store', 'show', 'edit', 'update', 'index']);
    Route::resource('lead_image', 'LeadImageController');
    Route::post('invite_user', 'inviteUserController@invite')->name('invite_user');
    Route::get('report', 'ReportsController@index')->name('reports');
    Route::get('report/moth/{data}', 'ReportsController@month')->name('report_month');
    Route::get('report/underwriter_report_taken_on_check_leads/{id}', 'ReportsController@underwriterTakeOnCheckLeads')->name('underwriter_report_taken_on_check_leads');
    Route::get('report/underwriter_report_invite_leads/{id}', 'ReportsController@underwriterReportInviteLeads')->name('underwriter_report_invite_leads');
    Route::get('user/{id}/change_email', 'Auth\ChangeEmailController@edit')->name('edit_change_email');
    Route::put('change_email', 'Auth\ChangeEmailController@changeEmail')->name('change_email');
    Route::get('change_email/{code}', 'Auth\ChangeEmailController@confirmChangeEmail')->name('confirm_change_email');
    Route::get('save_new_email/{code}', 'Auth\ChangeEmailController@saveNewEmail')->name('save_new_email');
    Route::get('history/{id}', 'AdminUserController@history')->name('user_history');

    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
        Route::get('user', 'AdminUserController@index')->name('admin_user');
        Route::get('user/search/{type}', 'AdminUserController@indexCustom')->name('admin_user_custom');
        Route::get('user/city/{city}', 'AdminUserController@searchByCities')->name('search_by_cities');
        Route::get('user/{user}', 'AdminUserController@edit')->name('admin_user_edit');
        Route::put('user/{user}', 'AdminUserController@update')->name('admin_user_update');
        Route::put('user_role/{user}', 'AdminUserController@updateRole')->name('admin_user_role_update');
        Route::get('user/{user}/leads', 'AdminUserController@showLeads')->name('admin_show_leads');
        Route::get('admin_add_cities', 'AdminUserController@admin_add_cities')->name('admin_add_cities');
        Route::any('change_city_name', 'AdminUserController@change_city_name')->name('change_city_name');
        Route::any('add_new_city', 'AdminUserController@add_new_city')->name('add_new_city');
        Route::any('check_city', 'AdminUserController@check_city')->name('check_city');
        Route::any('delete_city', 'AdminUserController@delete_city')->name('delete_city');
        Route::any('update_type', 'AdminUserController@update_type')->name('update_type');
        Route::any('update_cities', 'AdminUserController@update_cities')->name('update_cities');
        Route::any('get_user_cities', 'AdminUserController@get_user_cities')->name('get_user_cities');

        Route::get('statistic/{id}', 'LeadStatisticController')->name('admin_lead_statistic');
        Route::group(['prefix' => 'ajax', 'namespace' => 'Ajax'], function () {
            Route::post('user_fine_update/{id}', 'UserFineController@update');
        });
    });
    Route::get('report/pay/{date}', 'ReportsController@pay')->name('report_pay');
    Route::get('report/pay/leadgen_details/{data?}/{id?}', 'ReportsController@leadgen_details')->name('leadgen_details');
    Route::any('update', 'HomeController@update')->name('update');
    Route::any('report/pay/payment/{date}', 'ReportsController@payment')->name('report_payment');
    Route::any('report/pay/delete_ticket/{date}/{id}', 'ReportsController@delete')->name('delete_ticket');
    Route::any('select_view', 'HomeController@select_view')->name('select_view');
    Route::any('change_telegram_id', 'NotificationController@changeTelegramId')->name('change_telegram_id');
    Route::any('notification_ajax', 'NotificationController@notificationAjax')->name('notification_ajax')->middleware('CheckAjaxTelegramId');
    Route::put('toggle_notification/{user_id}', 'NotificationController@toggleNotification')->name('toggle_notification')->middleware('CheckTelegramId');

    Route::middleware('admin')->group(function () {
        Route::get('assign_underwriters/{city_id}', 'AssignUnderwriterController@worksInTheCity');
        Route::get('assign_underwriters', 'AssignUnderwriterController@all');
        Route::post('assign_underwriters/{lead_id}', 'AssignUnderwriterController@assign');
        Route::match(['get', 'post'], 'admin_search_name', 'AdminUserController@adminSearchName')->name('admin_search_name');
    });
    Route::get('sendTestMessageToTelegram', 'SendTestMessageToTelegramController')->middleware('telegramConnected');

});
Route::get('banned', function () {
    return view('banned');
})->name('banned');

Route::get('telegram_id', function () {
    return view('telegram_id');
})->name('telegram_id');

Route::get('personal_data_processing', function () {
    return view('personal_data_processing');
})->name('personal_data_processing');


Route::get('test', 'TestController@api')->middleware('telegramLogs');

Route::post(Telegram::getAccessToken(), 'TelegramController@webhook')->middleware('telegramLogs');