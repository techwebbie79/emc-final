<?php

use App\Http\Controllers\ActionController;
use App\Http\Controllers\AdvocateRegisterController;
use App\Http\Controllers\ApiCitizenCheckController;
use App\Http\Controllers\AppealController;
use App\Http\Controllers\AppealInfo\AppealInfoController;
use App\Http\Controllers\AppealInfo\AppealViewController;
use App\Http\Controllers\AppealInitiateController;
use App\Http\Controllers\AppealListController;
use App\Http\Controllers\AppealTrialController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CaseActivityLogController;
use App\Http\Controllers\CaseAssignDoptorUserController;
use App\Http\Controllers\CauseListController;
use App\Http\Controllers\CitizenAppealController;
use App\Http\Controllers\CitizenAppealListController;
use App\Http\Controllers\CitizenRegisterController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontHomeController;
use App\Http\Controllers\HearingTimeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MyprofileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NothiListController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\Office_ULOController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewAppealController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\UserNotificationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();
Auth::routes([
    'login' => true,
    'logout' => true,
    'register' => true,
    'reset' => true, // for resetting passwords
    'confirm' => false, // for additional password confirmations
    'verify' => false, // for email verification
]);
// https://github.com/laravel/ui/blob/2.x/src/AuthRouteMethods.php
Route::get('/publicHome', function () {
    return view('public_home');
});

Route::get('/landing', function () {
    return view('landing_landing');
});

/*Route::get('/', function () {
return view('publicHomeH');
})->name('home');*/
Route::get('/', [LandingPageController::class, 'index'])->name('home');

Route::get('/login/page', [LandingPageController::class, 'show_log_in_page'])->name('show_log_in_page');
Route::get('/login/page/test', [LandingPageController::class, 'show_log_in_page_test'])->name('show_log_in_page_test');

Route::get('/txt', [CitizenRegisterController::class, 'txt']);
Route::get('/citizenRegister', [CitizenRegisterController::class, 'create']);
Route::get('/citizen/nid/check', [CitizenRegisterController::class, 'nid_check'])->name('citizen.nid_check');
Route::post('/citizen/nid/verify', [CitizenRegisterController::class, 'nid_verify'])->name('citizen.nid_verify');
Route::get('/citizen/mobile/check/{user_id}', [CitizenRegisterController::class, 'mobile_check'])->name('citizen.mobile_check');
Route::post('/citizen/mobile/verify', [CitizenRegisterController::class, 'mobile_verify'])->name('citizen.mobile_verify');
Route::post('/citizenRegister/store', [CitizenRegisterController::class, 'store'])->name('citizenRegister.store');

Route::get('/citizen/reg/opt/resend/{user_id}', [CitizenRegisterController::class, 'citizen_registration_otp_resend'])->name('citizen.reg.otp.resend');

Route::get('/advocateRegister', [AdvocateRegisterController::class, 'create']);
Route::get('/advocate/nid/check', [AdvocateRegisterController::class, 'nid_check'])->name('advocate.nid_check');
Route::post('/advocate/nid/verify', [AdvocateRegisterController::class, 'nid_verify'])->name('advocate.nid_verify');

Route::get('/advocate/mobile/check/{user_id}', [AdvocateRegisterController::class, 'mobile_check'])->name('advocate.mobile_check');

Route::post('/advocate/mobile/verify', [AdvocateRegisterController::class, 'mobile_verify'])->name('advocate.mobile_verify');
Route::post('/advocateRegister/store', [AdvocateRegisterController::class, 'store'])->name('advocateRegister.store');

Route::get('/advocate/reg/opt/resend/{user_id}', [AdvocateRegisterController::class, 'advocate_registration_otp_resend'])->name('advocate.reg.otp.resend');

Route::post('/csLogin', [LoginController::class, 'csLogin']);

Route::post('/cdap/user/verify/login', [LoginController::class, 'cdap_user_login_verify'])->name('cdap.user.verify.login');

Route::get('/logincheck', [DashboardController::class, 'logincheck']);
Route::get('/registration', [RegistrationController::class, 'index'])->name('registration');

Route::group(['prefix' => 'generalCertificate/'], function () {
    Route::get('appealCreate', [AppealController::class, 'create'])->name('appealCreate');
    route::get('/case/dropdownlist/getdependentdistrict/{id}', [AppealController::class, 'getDependentDistrict']);
    route::get('/case/dropdownlist/getdependentupazila/{id}', [AppealController::class, 'getDependentUpazila']);
    route::get('/case/dropdownlist/getdependentcourt/{id}', [AppealController::class, 'getDependentCourt']);
    route::get('/getdependentlawdetails/{id}', [CitizenAppealController::class, 'getDependentLawDetails']);
});

// Route::get('/', [DashboardController::class, 'logincheck']);
Route::get('public_home', [FrontHomeController::class, 'public_home']);
Route::get('hearing-case-list', [FrontHomeController::class, 'dateWaysCase'])->name('dateWaysCase');
Route::get('rm-case-hearing-list', [FrontHomeController::class, 'dateWaysRMCase'])->name('dateWaysRMCase');
Route::get('appeal_hearing_list', [FrontHomeController::class, 'appeal_hearing_list'])->name('appeal_hearing_list');
Route::get('citizen/appeal/cause_list', [CauseListController::class, 'index'])->name('citizen.appeal.cause_list');

Route::middleware('auth')->group(function () {

    Route::middleware(['doptor_user_active_middlewire'])->group(function () {
        Route::post('citizen_check', [ApiCitizenCheckController::class, 'citizen_check'])->name('citizen_check');
        // appeal
        Route::group(['prefix' => 'appeal/', 'as' => 'appeal.'], function () {

            Route::middleware(['accepted_trial_functionalities'])->group(function () {
                Route::get('create', [AppealInitiateController::class, 'create'])->name('create');
                Route::post('store', [AppealInitiateController::class, 'store'])->name('store');
                Route::get('edit/{id}', [AppealInitiateController::class, 'edit'])->name('edit');
                Route::post('deleteFile/{id}', [AppealInitiateController::class, 'fileDelete'])->name('fileDelete');

                Route::post('deleteAppealFile/{id}/{appeal_id}', [AppealInitiateController::class, 'deleteAppealFile'])->name('deleteAppealFile');

                Route::post('appealCitizenDelete/{id}', [AppealInitiateController::class, 'appealCitizenDelete'])->name('appealCitizenDelete');
                Route::get('delete/{id}', [AppealInitiateController::class, 'delete'])->name('delete');
                Route::get('trial/{id}', [AppealTrialController::class, 'showTrialPage'])->name('trial');
                Route::get('assign/{appeal_id}', [CaseAssignDoptorUserController::class, 'all_user_list_from_doptor_segmented_adm_case_assign'])->name('assign');
                Route::get('assign/search/{appeal_id}', [CaseAssignDoptorUserController::class, 'all_user_list_from_doptor_segmented_adm_case_assign_search'])->name('adc.case.assign.doptor.search');

                Route::post('assign/store', [AppealTrialController::class, 'caseAssignedADCstore'])->name('assignStore');
                Route::get('investigationReport/{id}', [AppealTrialController::class, 'investigationReportPage'])->name('investigationReport');
                Route::post('trial/report_add', [AppealTrialController::class, 'report_add'])->name('trial.report_add');
                Route::get('trial/attendance_print/{id}', [AppealTrialController::class, 'attendance_print'])->name('trial.attendance_print');
                Route::get('status_change/{id}', [AppealTrialController::class, 'status_change'])->name('status_change');
                Route::post('/appeal/store/ontrial', [AppealTrialController::class, 'storeOnTrialInfo'])->name('appealStoreOnTrial');
                Route::get('collectPaymentList', [AppealTrialController::class, 'collectPaymentList'])->name('collectPaymentList');
                Route::get('collectPayment/{id}', [AppealTrialController::class, 'collectPaymentAmount'])->name('collectPayment');
                Route::get('printCollectPayment/{id}', [AppealTrialController::class, 'printCollectPaymentAmount'])->name('printCollectPayment');
                Route::post('save/appealPayment', [AppealTrialController::class, 'storeAppealPaymentInfo'])->name('storeAppealPaymentInfo');
                Route::get('delete/appealPaymentDelete/{id}', [AppealTrialController::class, 'deletePaymentInfoById'])->name('deleteAppealPaymentInfo');

                Route::post('get/dynamic/name/defulter/applicant', [AppealTrialController::class, 'get_dynamic_name_defulter_applicant'])->name('get.dynamic.name.defulter.applicant');

            });

            Route::get('all/list', [AppealListController::class, 'all_case'])->name('all_case');
            Route::get('pending/list', [AppealListController::class, 'pending_case'])->name('pending_list');
            Route::get('pending/review/list', [AppealListController::class, 'pending_review_case'])->name('pending_review_list');
            Route::get('list', [AppealListController::class, 'index'])->name('index');
            Route::get('draft_list', [AppealListController::class, 'draft_list'])->name('draft_list');
            Route::get('rejected_list', [AppealListController::class, 'rejected_list'])->name('rejected_list');
            Route::get('closed_list', [AppealListController::class, 'closed_list'])->name('closed_list');
            Route::get('postponed_list', [AppealListController::class, 'postponed_list'])->name('postponed_list');

            Route::get('trial_date_list', [AppealListController::class, 'trial_date_list'])->name('trial_date_list');
            Route::get('with/investigation/report', [AppealListController::class, 'appeal_with_investigation_report'])->name('with_investigation_report');

            Route::get('with/case/by/em', [AppealListController::class, 'case_by_em'])->name('case_by_em');

            Route::get('with/action/required', [AppealListController::class, 'appeal_with_action_required'])->name('appeal_with_action_required');

            Route::get('pending_review_case', [AppealListController::class, 'pending_review_case'])->name('pending_review_case');
            Route::get('running_review_case', [AppealListController::class, 'running_review_case'])->name('running_review_case');
            Route::get('arrest_warrent_list', [AppealListController::class, 'arrest_warrent_list'])->name('arrest_warrent_list');
            Route::get('arrest_investigation_list', [AppealListController::class, 'arrest_investigation_list'])->name('arrest_investigation_list');
            Route::get('/hearing/time/update', [HearingTimeController::class, 'create'])->name('hearingTimeUpdate');
            Route::post('/hearing/time/update/store', [HearingTimeController::class, 'store'])->name('hearingTimeUpdateStore');

            // Route::get('trial/{id}', [AppealListController::class, 'show'])->name('details');
            //Route::get('assign/{id}', [AppealTrialController::class, 'caseAssignedADC'])->name('assign');
            // Route::get('/appeal/collectPaymentList/', [AppealTrialController::class, 'collectPaymentList'])->name('collectPaymentList');

            Route::get('/nothiView/{id}', [NothiListController::class, 'nothiViewPage'])->name('nothiView');

            Route::get('/pdfOrderSheet/{id}', [NothiListController::class, 'pdf_order_sheet'])->name('pdfOrderSheet');

            Route::post('/appeal/get/appealnama', 'AppealInfo\AppealInfoController@getAppealOrderSheets')->name('getAppealOrderLists');

            // Route::get('/appeal/get/appealnama', [NothiListController::class, 'nothiViewPage'])->name('nothiView');

            Route::get('/get/orderSheets/{id}', [AppealInfoController::class, 'getAppealOrderSheets'])->name('getOrderSheets');

            Route::get('view/{id}', [AppealViewController::class, 'showAppealViewPage'])->name('appealView');
            Route::get('case-traking/{id}', [AppealViewController::class, 'showAppealTrakingPage'])->name('appealTraking');
            Route::get('/get/warrentOrderSheets/{id}', [AppealInfoController::class, 'getAppealWarrentOrderSheet'])->name('getWarrentOrderSheets');
            Route::get('/get/investigationOrderSheets/{id}', [AppealInfoController::class, 'getAppealInvestigationOrderSheet'])->name('getInvestigationOrderSheets');

        });

        Route::group(['prefix' => 'citizen/', 'as' => 'citizen.'], function () {
            Route::get('appeal/create/old', [CitizenAppealController::class, 'create_old'])->name('appeal.create_old');
            Route::get('appeal/create', [CitizenAppealController::class, 'create'])->name('appeal.create');
            Route::get('appeal/edit/{id}', [CitizenAppealController::class, 'edit'])->name('appeal.edit');

            Route::post('appeal/nid/check', [CitizenAppealController::class, 'appeal_nid_check'])->name('appeal.nid.check');

            Route::post('appeal/store', [CitizenAppealController::class, 'store'])->name('appeal.store');

            Route::get('appeal/list', [CitizenAppealListController::class, 'index'])->name('appeal.index');
            Route::get('appeal/draft_list', [CitizenAppealListController::class, 'draft_list'])->name('appeal.draft_list');
            Route::get('appeal/rejected_list', [CitizenAppealListController::class, 'rejected_list'])->name('appeal.rejected_list');
            Route::get('appeal/closed_list', [CitizenAppealListController::class, 'closed_list'])->name('appeal.closed_list');
            Route::get('appeal/postponed_list', [CitizenAppealListController::class, 'postponed_list'])->name('appeal.postponed_list');
            Route::get('register', [CitizenRegisterController::class, 'create'])->name('register');
            Route::get('appeal/trial_date_list', [CitizenAppealListController::class, 'trial_date_list'])->name('appeal.trial_date_list');

            Route::get('appeal/review/create/{id}', [ReviewAppealController::class, 'create'])->name('appeal.review.create');
            Route::post('appeal/review/store', [ReviewAppealController::class, 'store'])->name('appeal.review.store');
        });

        Route::group(['prefix' => 'register/', 'as' => 'register.'], function () {
            Route::get('list', [RegisterController::class, 'index'])->name('list');
            Route::get('printPdf', [RegisterController::class, 'registerPrint'])->name('printPdf');
        });

        // Route::get('site_setting', [SiteSettingController::class, 'edit'])->name('app.setting.index');
        // Route::post('site_setting', [SiteSettingController::class, 'update'])->name('app.setting.update');

        // setting
        Route::get('site_setting', [SiteSettingController::class, 'edit'])->name('app.setting.index');
        Route::post('site_setting', [SiteSettingController::class, 'update'])->name('app.setting.update');

        // Route::get('/home', [HomeController::class, 'index']);
        Route::get('/databaseCaseCheck', [HomeController::class, 'databaseCaseCheck']);
        Route::get('/databaseDataUpdated', [HomeController::class, 'databaseDataUpdated']);

        /////****** Dashboard *******/////
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/hearing-case-details/{id}', [DashboardController::class, 'hearing_case_details'])->name('dashboard.hearing-case-details');
        Route::get('/dashboard/hearing-today', [DashboardController::class, 'hearing_date_today'])->name('dashboard.hearing-today');
        Route::get('/dashboard/hearing-tomorrow', [DashboardController::class, 'hearing_date_tomorrow'])->name('dashboard.hearing-tomorrow');
        Route::get('/dashboard/hearing-nextWeek', [DashboardController::class, 'hearing_date_nextWeek'])->name('dashboard.hearing-nextWeek');
        Route::get('/dashboard/hearing-nextMonth', [DashboardController::class, 'hearing_date_nextMonth'])->name('dashboard.hearing-nextMonth');

        // AJAX Report
        Route::post('/dashboard/ajax-crpc', [DashboardController::class, 'ajaxCrpc'])->name('dashboard.crpc-report');
        Route::post('/dashboard/ajax-case-status', [DashboardController::class, 'ajaxCaseStatus'])->name('dashboard.case-status-report');
        Route::post('/dashboard/ajax-case-statistics', [DashboardController::class, 'ajaxCaseStatistics'])->name('dashboard.ajax-case-statistics');
        Route::post('/dashboard/ajax-crpc-pie-chart', [DashboardController::class, 'ajaxPieChart'])->name('dashboard.crpc-pie-chart');
        Route::post('/dashboard/ajax-request', [DashboardController::class, 'testReport'])->name('dashboard.test-report');

        /////******* Action *******/////
        Route::get('/action/receive/{id}', [ActionController::class, 'receive'])->name('action.receive');
        Route::get('/action/details/{id}', [ActionController::class, 'details'])->name('action.details');
        Route::post('/action/forward', [ActionController::class, 'store'])->name('action.forward');
        Route::post('/action/createsf', [ActionController::class, 'create_sf'])->name('action.createsf');
        Route::post('/action/editsf', [ActionController::class, 'edit_sf'])->name('action.editsf');
        // Route::post('/action/hearingadd', [ActionController::class, 'hearing_add'])->name('action.hearingadd');
        // Route::get('/action/hearingadd', [ActionController::class, 'hearing_add']);
        Route::post('/action/hearingadd', [ActionController::class, 'hearing_store'])->name('action.hearingadd');
        Route::post('/action/file_store_hearing', [ActionController::class, 'file_store_hearing']);

        Route::post('/action/result_update', [ActionController::class, 'result_update'])->name('action.result_update');

        Route::get('/action/pdf_sf/{id}', [ActionController::class, 'pdf_sf'])->name('action.pdf_sf');
        Route::get('/action/testpdf', [ActionController::class, 'test_pdf'])->name('action.testpdf');

        // Route::get('ajax-file-upload-progress-bar', 'ProgressBarUploadFileController@index');
        Route::post('/action/file_store', [ActionController::class, 'file_store']);
        Route::post('/action/file_save', [ActionController::class, 'file_save']);
        Route::get('/action/getDependentCaseStatus/{id}', [ActionController::class, 'getDependentCaseStatus']);
        // Route::get('file', [FileController::class, 'index']);
        // Route::post('store-file', [FileController::class, 'store']);

        /////****** Report Module *****/////
        Route::get('/report', [ReportController::class, 'index'])->name('report');
        Route::get('/report/case', [ReportController::class, 'caselist'])->name('report.case');
        Route::post('/report/pdf', [ReportController::class, 'pdf_generate']);
        // Route::get('/report/old-case', [ReportController::class, 'old_case']);

        //============ News Route Start ==============//
        Route::get('/news/list', [NewsController::class, 'index'])->name('news.list');
        Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
        Route::post('/news/store', [NewsController::class, 'store'])->name('news.store');
        Route::get('/news/edit/{id}', [NewsController::class, 'edit'])->name('news.edit');
        Route::post('/news/update/{id}', [NewsController::class, 'update'])->name('news.update');
        Route::get('/news/delete/{id}', [NewsController::class, 'destroy'])->name('news.delete');
        Route::get('news/status/{status}/{id}', [NewsController::class, 'status'])->name('status.update');
        /*Route::get('/case_audit/details/{id}', [NewsController::class, 'show'])->name('case_audit.show');
        Route::get('/case_audit/pdf-Log/{id}', [NewsController::class, 'caseActivityPDFlog'])->name('case_audit.caseActivityPDFlog');
        Route::get('/case_audit/case_details/{id}', [NewsController::class, 'reg_case_details'])->name('case_audit.reg_case_details');
        Route::get('/case_audit/sf/details/{id}', [NewsController::class, 'sflog_details'])->name('case_audit.sf.details');*/
        //============ Case Activity Log End ==============//

        //============ Case Activity Log Start ==============//
        Route::get('/case_audit', [CaseActivityLogController::class, 'index'])->name('case_audit.index');
        Route::get('/case_audit/details/{id}', [CaseActivityLogController::class, 'show'])->name('case_audit.show');
        Route::get('/case_audit/pdf-Log/{id}', [CaseActivityLogController::class, 'caseActivityPDFlog'])->name('case_audit.caseActivityPDFlog');
        Route::get('/case_audit/case_details/{id}', [CaseActivityLogController::class, 'reg_case_details'])->name('case_audit.reg_case_details');
        Route::get('/case_audit/sf/details/{id}', [CaseActivityLogController::class, 'sflog_details'])->name('case_audit.sf.details');
        //============ Case Activity Log End ==============//

        /////***** User Management *****/////
        // Route::resource('user-management', UserManagementController::class);

        Route::group(['prefix' => 'user-management/', 'as' => 'user-management.'], function () {
            Route::get('/index', [UserManagementController::class, 'index'])->name('index');
            Route::get('/create', [UserManagementController::class, 'create'])->name('create');
            Route::post('/store', [UserManagementController::class, 'store'])->name('store');
            Route::get('/show/{id}', [UserManagementController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [UserManagementController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [UserManagementController::class, 'update'])->name('update');
            Route::get('/em-case-mapping/{id}', [UserManagementController::class, 'em_case_mapping'])->name('show_case_path');
            Route::post('/em-case-mapping-store', [UserManagementController::class, 'em_case_mapping_store'])->name('em-case-mapping-store');
        });

        /////***** MY Profile *****/////
        // Route::resource('my-profile', MyprofileController::class);
        Route::get('/my-profile', [MyprofileController::class, 'index'])->name('my-profile.index');
        Route::get('/my-profile/basic', [MyprofileController::class, 'basic_edit'])->name('my-profile.basic_edit');
        Route::post('/my-profile/basic/update', [MyprofileController::class, 'basic_update'])->name('my-profile.basic_update');
        Route::get('/my-profile/image', [MyprofileController::class, 'imageUpload'])->name('my-profile.imageUpload');
        Route::post('/my-profile/image/update', [MyprofileController::class, 'image_update'])->name('my-profile.image_update');
        Route::get('/my-profile/change/password/logged/in', [MyprofileController::class, 'change_password_lgged_in'])->name('change.password.logged.in');
        Route::post('/my-profile/update/password/logged/in', [MyprofileController::class, 'update_password_logged_in'])->name('update.password.logged.in');
        // Route::get('/my-profile', [MyprofileController::class, 'index'])->name('my-profile.index');
        /////***** Office Setting *****/////
        // Route::resource('office-setting', OfficeController::class);
        Route::get('/office', [OfficeController::class, 'index'])->name('office');
        route::get('/office/create', [OfficeController::class, 'create'])->name('office.create');
        Route::post('/office/save', [OfficeController::class, 'store'])->name('office.save');
        route::get('/office/edit/{id}', [OfficeController::class, 'edit'])->name('office.edit');
        route::post('/office/update/{id}', [OfficeController::class, 'update'])->name('office.update');
        route::get('/office/dropdownlist/getdependentdistrict/{id}', [OfficeController::class, 'getDependentDistrict']);
        route::get('/office/dropdownlist/getdependentupazila/{id}', [OfficeController::class, 'getDependentUpazila']);

        /////***** Office_ULO Setting *****/////
        // Route::resource('office_ulo-setting', Office_ULOController::class);
        Route::get('/ulo', [Office_ULOController::class, 'index'])->name('ulo');
        route::get('/ulo/create', [Office_ULOController::class, 'create'])->name('ulo.create');
        route::post('/ulo/save', [Office_ULOController::class, 'store'])->name('ulo.save');
        route::get('/ulo/edit/{id}', [Office_ULOController::class, 'edit'])->name('ulo.edit');
        route::post('/ulo/update/{id}', [Office_ULOController::class, 'update'])->name('ulo.update');
        route::get('/ulo/dropdownlist/getdependentdistrict/{id}', [Office_ULOController::class, 'getDependentDistrict']);
        route::get('/ulo/dropdownlist/getdependentupazila/{id}', [Office_ULOController::class, 'getDependentUpazila']);
        route::get('/ulo/dropdownlist/getdependentulo/{id}', [Office_ULOController::class, 'getDependentULO']);
        /////***** Court Setting *****/////
        // Route::resource('court-setting', CourtController::class);
        Route::middleware(['settings_protection_from_citizen_middlewire'])->group(function () {
            route::get('/court', [CourtController::class, 'index'])->name('court');
            route::get('/court/create', [CourtController::class, 'create'])->name('court.create');
            Route::post('/court/save', [CourtController::class, 'store'])->name('court.save');
            route::get('/court/edit/{id}', [CourtController::class, 'edit'])->name('court.edit');
            route::post('/court/update/{id}', [CourtController::class, 'update'])->name('court.update');
            route::get('/court-setting/dropdownlist/getdependentdistrict/{id}', [CourtController::class, 'getDependentDistrict']);
        });
        

        /////***** General Setting *****/////
        // Route::resource('setting', SettingController::class);
        Route::middleware(['settings_protection_from_citizen_middlewire'])->group(function () {
            Route::group(['prefix' => 'setting/', 'as' => 'setting.'], function () {
                //=======================Short Decision District===============//
                // Route::get('short-decision-district', [SettingController::class, 'shortDecisionDistrict'])->name('short-decision-district');
                // Route::get('short-decision-district/add', [SettingController::class, 'shortDecisionDistrictCreate'])->name('short-decision-district.add');

                //=======================Short Decision===============//
                Route::get('short-decision', [SettingController::class, 'shortDecision'])->name('short-decision');
                Route::get('short-decision/create', [SettingController::class, 'shortDecisionCreate'])->name('short-decision.create');
                Route::post('short-decision/store', [SettingController::class, 'shortDecisionStore'])->name('short-decision.store');
                Route::get('short-decision/edit/{id}', [SettingController::class, 'shortDecisionEdit'])->name('short-decision.edit');
                Route::post('short-decision/update/{id}', [SettingController::class, 'shortDecisionUpdate'])->name('short-decision.update');

                Route::get('short-decision/details/create/{id}', [SettingController::class, 'shortDecisionDetailsCreate'])->name('short-decision.details_create');
                Route::post('short-decision/details/store', [SettingController::class, 'shortDecisionDetailsStore'])->name('short-decision.details_store');
                //=======================CRPC Section===============//
                Route::get('crpc-section', [SettingController::class, 'crpcSections'])->name('crpcsection');
                Route::get('crpc-section/add', [SettingController::class, 'crpcSectionsCreate'])->name('crpcsection.add');
                Route::post('crpc-section/save', [SettingController::class, 'crpcSectionsSave'])->name('crpcsection.save');
                Route::get('crpc-section/edit/{id}', [SettingController::class, 'crpcSectionsEdit'])->name('crpcsection.edit');
                Route::post('crpc-section/update/{id}', [SettingController::class, 'crpcSectionsUpdate'])->name('crpcsection.update');

                //=======================division===============//
                Route::get('division', [SettingController::class, 'division_list'])->name('division');
                Route::get('division/edit/{id}', [SettingController::class, 'division_edit'])->name('division.edit');
                Route::post('division/update/{id}', [SettingController::class, 'division_update'])->name('division.update');

                //=======================court===============//
                Route::get('court-form', [SettingController::class, 'court_form'])->name('code.form');
            });
        });

        //======================= //division===============//
        Route::get('/settings/district', [SettingController::class, 'district_list'])->name('district');
        Route::get('/settings/district/edit/{id}', [SettingController::class, 'district_edit'])->name('district.edit');
        Route::post('/settings/district/update/{id}', [SettingController::class, 'district_update'])->name('district.update');
        Route::get('/settings/upazila', [SettingController::class, 'upazila_list'])->name('upazila');
        Route::get('/settings/upazila/edit/{id}', [SettingController::class, 'upazila_edit'])->name('upazila.edit');
        Route::post('/settings/upazila/update/{id}', [SettingController::class, 'upazila_update'])->name('upazila.update');
        Route::get('/settings/mouja', [SettingController::class, 'mouja_list'])->name('mouja');
        Route::get('/settings/mouja/add', [SettingController::class, 'mouja_add'])->name('mouja-add');
        Route::get('/settings/mouja/edit/{id}', [SettingController::class, 'mouja_edit'])->name('mouja.edit');
        Route::post('/settings/mouja/save', [SettingController::class, 'mouja_save'])->name('mouja.save');
        Route::post('/settings/mouja/update/{id}', [SettingController::class, 'mouja_update'])->name('mouja.update');
        Route::get('/settings/survey', [SettingController::class, 'survey_type_list'])->name('survey');
        /*Route::get('/survey/edit/{id}', [SettingController::class, 'survey_edit'])->name('survey.edit');
        Route::post('/survey/update/{id}', [SettingController::class, 'survey_update'])->name('survey.update');*/
        Route::get('/case_type', [SettingController::class, 'case_type_list'])->name('case-type');
        Route::get('/case_status', [SettingController::class, 'case_status_list'])->name('case-status');
        Route::get('/case_status/add', [SettingController::class, 'case_status_add'])->name('case-status.add');
        Route::get('/case_status/details/{id}', [SettingController::class, 'case_status_details'])->name('case-status.details');
        Route::post('/case_status/store', [SettingController::class, 'case_status_store'])->name('case-status.store');
        Route::get('/case_status/edit/{id}', [SettingController::class, 'case_status_edit'])->name('case-status.edit');
        Route::post('/case_status/update/{id}', [SettingController::class, 'case_status_update'])->name('case-status.update');
        /*Route::get('/case_type/edit/{id}', [SettingController::class, 'case_type_edit'])->name('case_type.edit');
        Route::post('/case_type/update/{id}', [SettingController::class, 'case_type_update'])->name('case_type.update');*/
        Route::get('/court_type', [SettingController::class, 'court_type_list'])->name('court-type');
        /*Route::get('/court_type/edit/{id}', [SettingController::class, 'court_type_edit'])->name('court_type.edit');
        Route::post('/court_type/update/{id}', [SettingController::class, 'court_type_update'])->name('court_type.update');*/

        /////***** //General Setting *****/////
        Route::resource('projects', ProjectController::class);
        Route::get('/form-layout', function () {
            return view('form_layout');
        });
        Route::get('/list', function () {
            return view('list');
        });

        //=================== Notification Start ================
        Route::get('/results_completed', [UserNotificationController::class, 'results_completed'])->name('results_completed');
        Route::get('/hearing_date', [UserNotificationController::class, 'hearing_date'])->name('hearing_date');
        Route::get('/rmcase/hearing_date', [UserNotificationController::class, 'rm_hearing_date'])->name('rm_hearing_date');
        Route::get('/new_sf_list', [UserNotificationController::class, 'newSFlist'])->name('newSFlist');
        Route::get('/new_sf_details/{id}', [UserNotificationController::class, 'newSFdetails'])->name('newSFdetails');
        //=================== Notification End ==================

        //=================== Message Start ================
        Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
        //=================== Message End ================
        Route::get('/messages', [MessageController::class, 'messages'])->name('messages');
        Route::get('/messages_recent', [MessageController::class, 'messages_recent'])->name('messages_recent');
        Route::get('/messages_request', [MessageController::class, 'messages_request'])->name('messages_request');
        Route::get('/messages/{id}', [MessageController::class, 'messages_single'])->name('messages_single');
        Route::get('/messages_remove/{id}', [MessageController::class, 'messages_remove'])->name('messages_remove');
        Route::post('/messages/send', [MessageController::class, 'messages_send'])->name('messages_send');
        Route::get('/messages_group', [MessageController::class, 'messages_group'])->name('messages_group');
        // Route::get('/hearing_date', [MessageController::class, 'hearing_date'])->name('hearing_date');
        // Route::get('/new_sf_list', [MessageController::class, 'newSFlist'])->name('newSFlist');
        // Route::get('/new_sf_details/{id}', [MessageController::class, 'newSFdetails'])->name('newSFdetails');
        //=================== Message End ==================
        Route::get('/script', [MessageController::class, 'script']);

        //=================== CASE MAPPING ================

        Route::get('test_notification', function () {

            $CaseTrialCount = DB::table('em_appeal_citizens')
                ->join('em_appeals', 'em_appeals.id', '=', 'em_appeal_citizens.appeal_id')
                ->where('em_appeals.next_date', date('Y-m-d', strtotime(now())))
                ->whereIn('em_appeal_citizens.citizen_type_id', [1, 2, 4])
                ->where('em_appeal_citizens.citizen_id', globalUserInfo()->citizen_id)
                ->count();
            dd($CaseTrialCount);
        });
    });
});

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function () {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function () {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function () {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});
