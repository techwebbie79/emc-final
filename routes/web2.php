<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NDoptorUserData;
use App\Http\Controllers\NIDVerification;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\CdapUserManagement;
use App\Http\Controllers\DayWiseCaseMapping;
use App\Http\Controllers\CauseListController;
use App\Http\Controllers\DummiDataController;
use App\Http\Controllers\JitsiMeetController;
use App\Http\Controllers\MyprofileController;
use App\Http\Controllers\NothiListController;
use App\Repositories\OnlineHearingRepository;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CaseMappingController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\FacebookLoginController;
use App\Http\Controllers\InvestigationController;
use App\Http\Controllers\LogManagementController;
use App\Http\Controllers\PeshkarManageController;
use App\Repositories\EmailNotificationRepository;
use App\Http\Controllers\AppealInitiateController;
use App\Http\Controllers\PeshkarSettingController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserExitsCheckController;
use App\Http\Controllers\NDoptorUserManagementAdmin;
use App\Http\Controllers\CdapUserManagementController;
use App\Http\Controllers\AppealInfo\AppealInfoController;

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

Route::middleware('auth')->group(function () {
    //Route::get('/support/center', [SupportController::class, 'support_form_page'])->name('support.center');

    Route::middleware(['doptor_user_active_middlewire'])->group(function () {

        //=======================Short Decision Peshkar===============//

        Route::middleware(['settings_protection_from_citizen_middlewire'])->group(function () {
            Route::get('peshkar-short-decision', [PeshkarSettingController::class, 'shortDecision'])->name('peshkar.short.decision');
            Route::get('peshkar-short-decision/create', [PeshkarSettingController::class, 'shortDecisionCreate'])->name('peshkar.short.decision.create');
            Route::post('peshkar-short-decision/store', [PeshkarSettingController::class, 'shortDecisionStore'])->name('peshkar.short.decision.store');
            Route::get('peshkar-short-decision/edit/{id}', [PeshkarSettingController::class, 'shortDecisionEdit'])->name('peshkar.short.decision.edit');
            Route::post('peshkar-short-decision/update/{id}', [PeshkarSettingController::class, 'shortDecisionUpdate'])->name('peshkar.short.decision.update');

            Route::get('peshkar-short-decision/details/create/{id}', [PeshkarSettingController::class, 'shortDecisionDetailsCreate'])->name('peshkar.short.decision.details.create');
            Route::post('peshkar-short-decision/details/store', [PeshkarSettingController::class, 'shortDecisionDetailsStore'])->name('peshkar.short.decision.details.store');
        });

        //=================== CASE MAPPING ================
        Route::middleware(['dm_settings_protection_middlewire'])->group(function () {
            Route::group(['prefix' => 'case-mapping/', 'as' => 'case-mapping.'], function () {
                Route::get('/index', [CaseMappingController::class, 'index'])->name('index');
                Route::post('/show_court', [CaseMappingController::class, 'show_court'])->name('show_court');
                Route::post('/store', [CaseMappingController::class, 'store'])->name('store');
            });
            /*** Day wise court mapping Start */
            Route::group(['prefix' => 'day/wise/case/mapping/', 'as' => 'day-wise-case-mapping.'], function () {
                Route::get('/index', [DayWiseCaseMapping::class, 'index'])->name('index');
                Route::post('/store', [DayWiseCaseMapping::class, 'store'])->name('store');
            });
            




            /**Day Wise Court Mapping End */
            
        });

        Route::middleware(['settings_protection_from_citizen_middlewire'])->group(function () {
            Route::group(['prefix' => 'role-permission/', 'as' => 'role-permission.'], function () {
                Route::get('/index', [RolePermissionController::class, 'index'])->name('index');
                Route::post('/show_permission', [RolePermissionController::class, 'show_permission'])->name('show_permission');
                Route::post('/store', [RolePermissionController::class, 'store'])->name('store');
            });
        });
        Route::get('/en2bn', function (Request $request) {
            return response()->json([
                'status' => 'success',
                'notify' => en2bn($request->notify),
            ]);
        })->name('en2bn');

        Route::get('/jisti/meet/{appeal_id}', [JitsiMeetController::class, 'index'])->name('jitsi.meet');

        Route::get('/investigator_doptor_check', [NDoptorUserData::class, 'index'])->name('investigator_doptor_check');

        Route::get('/peshkar/doptor/check', [NDoptorUserData::class, 'peshkar_doptor_check'])->name('peshkar.doptor.check');

        Route::get('/log_index', [LogManagementController::class, 'index'])->name('log.index');
        Route::get('/log_index_search', [LogManagementController::class, 'log_index_search'])->name('log_index_search');
        Route::get('/log_index_single/{id}', [LogManagementController::class, 'log_index_single'])->name('log_index_single');
        Route::get('/create_log_pdf/{id}', [LogManagementController::class, 'create_log_pdf'])->name('create_log_pdf');
        Route::get('/log/logid/details/{id}', [LogManagementController::class, 'log_details_single_by_id'])->name('log_details_single_by_id');

        //   */ ------------------NDoptorUserData CONTROLLER START---------------------------------- /*
        Route::middleware(['dm_settings_protection_middlewire'])->group(function () {
            Route::post('/doptor/user/management/user_list/store/adc/appeal_id', [NDoptorUserData::class, 'user_store_adc_appeal'])->name('doptor.user.management.store.adc.appeal_id');

            Route::get('/doptor/user/management/office_list', [NDoptorUserData::class, 'office_list'])->name('doptor.user.management.office_list');

            Route::get('/doptor/user/management/office_list/change/role', [NDoptorUserData::class, 'office_list_change_role'])->name('doptor.user.management.office_list.change.role');

            Route::get('/doptor/user/management/user_list/change/role/{office_id}', [NDoptorUserData::class, 'user_list_change_role'])->name('doptor.user.management.user_list.change.role');

            Route::get('/doptor/user/management/user_list/change/role/search/{office_id}', [NDoptorUserData::class, 'user_list_change_role_search'])->name('doptor.user.management.user_list.change.role.search');

            Route::get('/doptor/user/management/user_list/em/{office_id}', [NDoptorUserData::class, 'user_list_em'])->name('doptor.user.management.user_list.em');

            Route::get('/doptor/user/management/user_list/segmented/all/pick/em/dc/{office_id}', [NDoptorUserData::class, 'all_user_list_from_doptor_segmented_em_dc'])->name('doptor.user.management.user_list.segmented.all.pick.em.dc');

            Route::get('/doptor/user/management/user_list/segmented/all/search/pick/em/dc/{office_id}', [NDoptorUserData::class, 'all_user_list_from_doptor_segmented_em_dc_search'])->name('doptor.user.management.user_list.segmented.all.pick.em.dc.search');

            Route::get('/doptor/user/management/user_list/segmented/all/pick/em/uno/{office_id}', [NDoptorUserData::class, 'all_user_list_from_doptor_segmented_em_uno'])->name('doptor.user.management.user_list.segmented.all.pick.em.uno');

            Route::get('/doptor/user/management/user_list/segmented/all/search/pick/em/uno/{office_id}', [NDoptorUserData::class, 'all_user_list_from_doptor_segmented_em_uno_search'])->name('doptor.user.management.user_list.segmented.all.pick.em.uno.search');

            Route::post('/doptor/user/management/user_list/store', [NDoptorUserData::class, 'user_store_adm'])->name('doptor.user.management.store');

            Route::get('/doptor/user/management/user_list/segmented/all/pick/adm/{office_id}', [NDoptorUserData::class, 'all_user_list_from_doptor_segmented_adm'])->name('doptor.user.management.user_list.segmented.all.pick.adm');

            Route::get('/doptor/user/management/user_list/segmented/all/search/pick/adm/{office_id}', [NDoptorUserData::class, 'all_user_list_from_doptor_segmented_adm_search'])->name('doptor.user.management.user_list.segmented.all.pick.adm.search');

            Route::get('/doptor/user/management/user_list/{office_id}', [NDoptorUserData::class, 'user_list'])->name('doptor.user.management.user_list');

            Route::post('/doptor/user/management/user_list/store/em', [NDoptorUserData::class, 'user_store_em'])->name('doptor.user.management.store.em');

            Route::post('/doptor/user/management/user_list/store/em/dc', [NDoptorUserData::class, 'user_store_em_dc'])->name('doptor.user.management.store.em.dc');
           

            Route::get('/doptor/user/management/office_list', [NDoptorUserData::class, 'office_list'])->name('doptor.user.management.office_list');

            Route::get('/doptor/user/management/user_list/{office_id}', [NDoptorUserData::class, 'user_list'])->name('doptor.user.management.user_list');

            Route::post('/doptor/user/management/user_list/store', [NDoptorUserData::class, 'user_store_adm'])->name('doptor.user.management.store');

            Route::post('/doptor/user/management/user_list/store/em', [NDoptorUserData::class, 'user_store_em'])->name('doptor.user.management.store.em');
        });

        Route::get('/doptor/user/check', [NDoptorUserData::class, 'doptor_user_check']);

        //   */ ------------------ NDoptorUserData CONTROLLER END---------------------------------- /*

        //   */ ------------------ PeshkarManageController CONTROLLER END---------------------------------- /*

        Route::middleware(['em_dm_adm_settings_protection_middlewire'])->group(function () {
            Route::get('/peshkar/create/form', [PeshkarManageController::class, 'peshkar_create_form'])->name('peshkar.create.form');

            Route::get('/peshkar/update/form/{id}', [PeshkarManageController::class, 'peshkar_update_form'])->name('peshkar.update.form');
    
            Route::post('/peshkar/update/', [PeshkarManageController::class, 'peshkar_update'])->name('peshkar.update');
    
            Route::post('/peshkar/create/form/submit', [PeshkarManageController::class, 'peshkar_form_submit'])->name('peshkar.form.submit');
    
            Route::get('/peshkar/list/', [PeshkarManageController::class, 'peshkar_list'])->name('peshkar.adm.dm.list');
    
            Route::get('/peshkar/active/', [PeshkarManageController::class, 'peshkar_active'])->name('peshkar.active');
    
            Route::post('/doptor/user/management/user_list/store/peshkar/dm/adm', [PeshkarManageController::class, 'store_peshkar_dm_adm'])->name('doptor.user.management.store.peshkar.dm.adm');
    
            Route::get('/peshkar/create/adm/dm/form', [PeshkarManageController::class, 'peshkar_create_form'])->name('peshkar.create.adm.dm.form');
    
            Route::get('/peshkar/create/form/search', [PeshkarManageController::class, 'peshkar_create_form_search'])->name('peshkar.create.form.search');
    
            Route::get('/peshkar/create/form/manual', [PeshkarManageController::class, 'peshkar_create_form_manual'])->name('peshkar.create.manual.form');
    
            Route::post('/peshkar/create/form/manual/submit', [PeshkarManageController::class, 'peshkar_create_form_manual_submit'])->name('peshkar.create.manual.form.submit');
    
            Route::post('/doptor/user/management/user_list/store/peskar/em/uno', [PeshkarManageController::class, 'store_peskar_em_uno'])->name('doptor.user.management.store.peskar.em.uno');
    
            Route::post('/doptor/user/management/user_list/store/peskar/em/dc', [PeshkarManageController::class, 'store_peskar_em_dc'])->name('doptor.user.management.store.peskar.em.dc');
    
            Route::post('/doptor/user/management/user_list/store/peskar/adm/dc', [PeshkarManageController::class, 'store_peskar_adm_dc'])->name(' doptor.user.management.store.peskar.adm.dc');
    
            Route::get('/doptor/user/management/pick/role', function () {
                $data['title'] = 'অফিসার এর রোল নির্বাচন করুন';
    
                return view('doptor.pick_the_role')->with($data);
            })->name('doptor.user.management.pick.role');
        
        });

        

        /******                            User management BY admin                                       *******/

        Route::middleware(['settings_protection_from_citizen_middlewire'])->group(function () {
            Route::group(['prefix' => 'admin/doptor/management', 'as' => 'admin.doptor.management.'], function () {
                Route::post('/import/dortor/offices', [NDoptorUserData::class, 'import_doptor_office'])->name('import.offices');

                Route::get('/dropdownlist/getdependentdistrict/{id}', [NDoptorUserData::class, 'getDependentDistrictForDoptor']);
                Route::get('/dropdownlist/getdependentupazila/{id}', [NDoptorUserData::class, 'getDependentUpazilaForDoptor']);

                Route::get('/import/dortor/offices/search', [NDoptorUserData::class, 'imported_doptor_office_search'])->name('import.offices.search');

                Route::get('/user_list/segmented/all/{office_id}', [NDoptorUserManagementAdmin::class, 'all_user_list_from_doptor_segmented'])->name('user_list.segmented.all');

                Route::get('/search/user_list/segmented/all/{office_id}', [NDoptorUserManagementAdmin::class, 'all_user_list_from_doptor_segmented_search'])->name('search.all.members');

                Route::post('/divisional/commissioner/create', [NDoptorUserManagementAdmin::class, 'divisional_commissioner_create_by_admin'])->name('divisional.commissioner.create');

                Route::post('/district/commissioner/create', [NDoptorUserManagementAdmin::class, 'district_commissioner_create_by_admin'])->name('dictrict.commissioner.create');

                Route::post('/dc/office/em', [NDoptorUserManagementAdmin::class, 'em_dc_create_by_admin'])->name('em.dc.create');

                Route::post('/dc/office/em/peshkar', [NDoptorUserManagementAdmin::class, 'peskar_em_dc_create_by_admin'])->name('em.peshkar.dc.create');

                Route::post('/dc/office/adm', [NDoptorUserManagementAdmin::class, 'adm_create_by_admin'])->name('adm.create');

                Route::post('/dc/office/adm/peshkar', [NDoptorUserManagementAdmin::class, 'peskar_adm_dc_create_by_admin'])->name('adm.peshkar.dc.create');

                Route::post('/uno/office/em', [NDoptorUserManagementAdmin::class, 'em_uno_create_by_admin'])->name('em.uno.create');

                Route::post('/uno/office/em/peshkar', [NDoptorUserManagementAdmin::class, 'peskar_em_uno_create_by_admin'])->name('em.peshkar.uno.create');

            });
        });

    });

    Route::post('/paginate/causelist/auth/user', [CauseListController::class, 'paginate_causelist_auth_user'])->name('paginate.causelist.auth.user');
});

Route::get('/investigator/verify', [InvestigationController::class, 'investigator_verify'])->name('investigator.verify');

Route::post('/investigator/verify/form', [InvestigationController::class, 'investigator_verify_form_submit'])->name('investigator.verify.form');

Route::get('/investigation/report/{id}/{mobile_no}/{investigator_id}', [InvestigationController::class, 'investigation_report'])->name('investigation.report');

Route::post('/investigator/form/submit', [InvestigationController::class, 'investigator_form_submit'])->name('investigator.form.submit');

Route::get('/investigation/approve/', [InvestigationController::class, 'investigation_approve'])->name('investigation.approve');
Route::get('/investigation/delete/', [InvestigationController::class, 'investigation_delete'])->name('investigation.delete');

Route::get('/investigator/details/single/{id}', [InvestigationController::class, 'investigation_details_single'])->name('investigation.details.single');

Route::get('/disable/doptor/user/{id}', function ($id) {
    if ($id == 37) {
        $data['title'] = 'Disabled Doptor User';
        $data['message1'] = 'আপনাকে ডিজেবল করে রাখা হয়েছে';
        $data['message2'] = 'আপনি আনুগ্রহ করে আপনি A2I , System Admin অথবা জনপ্রশাসন মন্ত্রণালয় এর সাথে যোগাযোগ করুন';
    } else {
        $data['title'] = 'Disabled Doptor User';
        $data['message1'] = 'আপনাকে ডিজেবল করে রাখা হয়েছে';
        $data['message2'] = 'আপনি আনুগ্রহ করে আপনার জেলার , জেলা প্রশাসক মহোদয় এর সাথে যোগাযোগ করুন';
    }
    $callbackurl = url('/');
    $zoom_join_url = DOPTOR_ENDPOINT().'/logout?' . 'referer=' . base64_encode($callbackurl);
    
    $data['callbackurl']=$zoom_join_url; 
    return view('doptor.disable_doptor_user')->with($data);
});

Route::get('/disable/peshkar/{id}', function ($id) {
    if ($id == 28) {
        $data['title'] = 'Disabled Peskar User';
        $data['message1'] = 'আপনাকে ডিজেবল করে রাখা হয়েছে';
        $data['message2'] = 'আপনি আনুগ্রহ করে আপনার উপজেলার , উপজেলা নির্বাহী মহোদয় এর সাথে যোগাযোগ করুন';
    } elseif ($id == 39) {
        $data['title'] = 'Disabled Peskar User';
        $data['message1'] = 'আপনাকে ডিজেবল করে রাখা হয়েছে';
        $data['message2'] = 'আপনি আনুগ্রহ করে আপনার জেলার , অতিরিক্ত জেলা ম্যাজিস্ট্রেট অথবা জেলা ম্যাজিস্ট্রেট / প্রশাসক মহোদয় এর সাথে যোগাযোগ করুন';
    }
    $callbackurl = url('/');
    $zoom_join_url = DOPTOR_ENDPOINT().'/logout?' . 'referer=' . base64_encode($callbackurl);
    
    $data['callbackurl']=$zoom_join_url;

    return view('peshkar.disable_peshkar')->with($data);
});

Route::post('/username/exits', [UserExitsCheckController::class, 'index'])->name('username.exits');




Route::get('/my-profile/new/change-password/', [MyprofileController::class, 'new_change_password'])->name('change.new.password');

Route::post('/my-profile/update-password', [MyprofileController::class, 'new_update_password'])->name('update.new.password');

Route::get('/login/cdap', [CdapUserManagement::class, 'cdap_user_login'])->name('cdap.user.login');

// Route::post('/cdap/user/verify/login', [CdapUserManagement::class, 'cdap_user_login_verify'])->name('cdap.user.verify.login');

Route::get('/news/single/{id}', [NewsController::class, 'news_single'])->name('news.single');

Route::post('/nid/verify/appeal/create', [NIDVerification::class, 'nid_verification'])->name('nid.verify.appeal.create');

Route::get('/appeal/View/citizen/pdf/create/{appeal_id}', [NIDVerification::class, 'citizen_appeal_view_pdf'])->name('appeal.view.citizen.pdf.create');

Route::get('/appeal/View/citizen/new/pdf/create/{appeal_id}', [NIDVerification::class, 'citizen_appeal_new_view_pdf'])->name('appeal.new.view.citizen.pdf.create');

Route::get('/appeal/View/citizen/new/pdf/create/shortOrder/{appeal_id}', [NIDVerification::class, 'citizen_appeal_new_view_pdf_short_order'])->name('appeal.view.citizen.pdf.create.shortOrder');

Route::get('/cdap/new/test/user', [CdapUserManagement::class, 'create_token']);

Route::get('/voice_to_tex', function () {
    return view('_voice_to_text_ours');
})->name('voice_to_tex');


Route::get('cdap/v2/login', [CdapUserManagementController::class, 'cdap_v2_login'])->name('cdap.v2.login');
Route::match(array('GET', 'POST'), '/cdap/v2/callback/url', [CdapUserManagementController::class, 'call_back_function_from_mygov'])->name('authsso');
Route::get('/cdap/nid/error', [LandingPageController::class, 'crawling'])->name('cdap.nid.error');
Route::get('/cdap/user/select/role',[CdapUserManagementController::class, 'cdap_user_select_role'])->name('cdap.user.select.role');
Route::get('cdap/user/create/citizen', [CdapUserManagementController::class, 'cdap_user_create_citizen'])->name('cdap.user.create.citizen');
Route::get('/cdap/user/create/advocate',[CdapUserManagementController::class, 'cdap_user_create_advocate'])->name('cdap.user.create.advocate');






Route::get('/citizenRegister/google/sso', [GoogleLoginController::class, 'create_citizen_google_sso']);
Route::get('/citizen/nid/check/google/sso', [GoogleLoginController::class, 'nid_check_citizen_google_sso'])->name('citizen.nid_check.google.sso');
Route::post('/citizen/nid/verify/google/sso', [GoogleLoginController::class, 'nid_verify_citizen_google_sso'])->name('citizen.nid_verify.google.sso');

Route::get('/advocateRegister/google/sso', [GoogleLoginController::class, 'create_advocate_google_sso']);
Route::get('/advocate/nid/check/google/sso', [GoogleLoginController::class, 'nid_check_advocate_google_sso'])->name('advocate.nid_check.google.sso');
Route::post('/advocate/nid/verify/google/sso', [GoogleLoginController::class, 'nid_verify_advocate_google_sso'])->name('advocate.nid_verify.google.sso');

Route::get('/test-zoom', function () {

    OnlineHearingRepository::storeHearingKey(65, 1, '15/11/2022', '13:45');
});

Route::get('/custom/logout', [LandingPageController::class, 'logout'])->name('custom_logout');
Route::get('/crpc/home/page', [LandingPageController::class, 'cprc_home_page'])->name('cprc.home.page');
Route::get('/process/map/view', [LandingPageController::class, 'process_map_view'])->name('process_map_view');

Route::get('/facebook/sso/auth', [FacebookLoginController::class, 'redirectToFacebook'])->name('facebook.sso.auth');
Route::get('/login/facebook/callback', [FacebookLoginController::class, 'redirectFromFaceboookSSO'])->name('login.facebook.callback');

Route::get('/support/center', [SupportController::class, 'support_form_page'])->name('support.center');
Route::get('/support/user/create', [SupportController::class, 'support_user_create'])->name('support.user.create');

Route::post('/support/center/post', [SupportController::class, 'support_form_post'])->name('support.form.post');

Route::post('/support/center/post/no/auth', [SupportController::class, 'support_form_post_no_auth'])->name('support.form.post.no.auth');

Route::post('/number/field/check', [AppealInitiateController::class, 'number_field_check'])->name('number.field.check');

Route::get('appeal/orderSheetDetails/{id}', [NothiListController::class, 'nothiViewOrderSheetDetails'])->name('appeal.nothiViewOrderSheetDetails');

Route::get('appeal/get/shortOrderSheets/{id}', [AppealInfoController::class, 'getAppealShortOrderSheets'])->name('appeal.getShortOrderSheets');

Route::get('/test/dammi/case/no', [DummiDataController::class, 'dammi_case_no']);
Route::get('/test/dami/nid/create', [DummiDataController::class, 'dummi_nid_create']);
Route::get('/update/citizen/email', [DummiDataController::class, 'update_citizen_email']);
Route::get('/update/nid/phone', [DummiDataController::class, 'update_nid_phone']);
Route::get('/test/court/name', [NIDVerification::class, 'getNidPdfList']);


Route::get('test_nothi',[LoginController::class, 'ndoptor_sso'])->name('nothi.v2.login');
Route::get('test/nothi/callback',[LoginController::class, 'ndoptor_sso_callback']);
Route::get('test/nothi/nothi_issus',[LoginController::class, 'ndoptor_sso_nothi_issus'])->name('nothi_issus');