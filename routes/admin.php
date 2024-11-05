
<?php

use App\Http\Controllers\Admin\AdminProfileSettingController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\BasicControlController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmailConfigController;
use App\Http\Controllers\Admin\FirebaseConfigController;
use App\Http\Controllers\Admin\KycController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\MaintenanceModeController;
use App\Http\Controllers\Admin\ManageMenuController;
use App\Http\Controllers\Admin\ManualGatewayController;
use App\Http\Controllers\Admin\NotificationTemplateController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PaymentLogController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\PluginController;
use App\Http\Controllers\Admin\PusherConfigController;
use App\Http\Controllers\Admin\SmsConfigController;
use App\Http\Controllers\Admin\StorageController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\SupportTicketController;
use App\Http\Controllers\Admin\TransactionLogController;
use App\Http\Controllers\Admin\TranslateAPISettingController;
use App\Http\Controllers\Admin\TxnSummaryController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\InAppNotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\BanksController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\VirtualCardController;
use App\Http\Controllers\Admin\MoneyTransferController;
use App\Http\Controllers\Admin\SocialiteController;

Route::get('queue-work', function () {
    return Illuminate\Support\Facades\Artisan::call('queue:work', ['--stop-when-empty' => true]);
})->name('queue.work');

Route::get('schedule-run', function () {
    return Illuminate\Support\Facades\Artisan::call('schedule:run');
})->name('schedule:run');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::any('two-fa/check', [BasicControlController::class, 'twoFaCheck'])->name('twoFaCheck');
    Route::get('/themeMode/{themeType?}', function ($themeType = 'true') {
        session()->put('themeMode', $themeType);
        return $themeType;
    })->name('themeMode');

    /*== Authentication Routes ==*/
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest:admin');
    Route::post('login', [LoginController::class, 'login'])->name('login.submit');
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request')
        ->middleware('guest:admin');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset')->middleware('guest:admin');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])
        ->name('admin.password.reset.update');


    Route::middleware(['auth:admin','verifyAdmin','demo'])->group(function () {

        Route::any('two-fa-control', [BasicControlController::class, 'twoFaControl'])->name('twoFa.control');
        Route::post('two-fa/disable', [BasicControlController::class, 'twoFaDisable'])->name('twoFa.Disable');
        Route::post('two-fa/enable', [BasicControlController::class, 'twoFaEnable'])->name('twoFa.Enable');
        Route::post('two-fa/re-generate', [BasicControlController::class, 'twoFaRegenerate'])->name('twoFaRegenerate');

        Route::get('profile', [AdminProfileSettingController::class, 'profile'])->name('profile');
        Route::put('profile', [AdminProfileSettingController::class, 'profileUpdate'])->name('profile.update');
        Route::put('password', [AdminProfileSettingController::class, 'passwordUpdate'])->name('password.update');
        Route::post('notification-permission', [AdminProfileSettingController::class, 'notificationPermission'])->name('notification.permission');

        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('save-token', [DashboardController::class, 'saveToken'])->name('save.token');

        Route::get('dashboard/card-order-history', [DashboardController::class, 'yearlyCardOrder'])->name('card.order.history');
        Route::get('dashboard/monthly-deposit-withdraw', [DashboardController::class, 'monthlyDepositWithdraw'])->name('monthly.deposit.withdraw');
        Route::get('dashboard/chartUserRecords', [DashboardController::class, 'chartUserRecords'])->name('chartUserRecords');
        Route::get('dashboard/chartTicketRecords', [DashboardController::class, 'chartTicketRecords'])->name('chartTicketRecords');
        Route::get('dashboard/chartKycRecords', [DashboardController::class, 'chartKycRecords'])->name('chartKycRecords');
        Route::get('dashboard/chartTransactionRecords', [DashboardController::class, 'chartTransactionRecords'])->name('chartTransactionRecords');
        Route::get('dashboard/chartLoginHistory', [DashboardController::class, 'chartLoginHistory'])->name('chartLoginHistory');

        /*== Transaction Summary ==*/
        Route::get('transaction-summary', [TxnSummaryController::class, 'index'])->name('txnSummary');
        Route::get('transaction-summary/{code}', [TxnSummaryController::class, 'details'])->name('txnSummary.details');
        Route::get('monthly-transaction/{code?}', [TxnSummaryController::class, 'monthlyTransaction'])->name('monthly.transaction');
        Route::get('txn-summary-list/{code}', [TxnSummaryController::class, 'transactionSearch'])->name('txnSummary.list');

        /*== Control Panel ==*/
        Route::get('settings/{settings?}', [BasicControlController::class, 'index'])->name('settings');
        Route::get('basic-control', [BasicControlController::class, 'basicControl'])->name('basic.control');
        Route::post('basic-control-update', [BasicControlController::class, 'basicControlUpdate'])->name('basic.control.update');
        Route::post('basic-control-activity-update', [BasicControlController::class, 'basicControlActivityUpdate'])->name('basic.control.activity.update');
        Route::get('currency-exchange-api-config', [BasicControlController::class, 'currencyExchangeApiConfig'])->name('currency.exchange.api.config');
        Route::post('currency-exchange-api-config/update', [BasicControlController::class, 'currencyExchangeApiConfigUpdate'])->name('currency.exchange.api.config.update');

        Route::match(['get', 'post'], 'cookie-control', [BasicControlController::class, 'cookieControl'])->name('cookie.control');

        /* ===== ADMIN SOCIALITE ===== */
        Route::get('socialite', [SocialiteController::class, 'index'])->name('socialite.index');
        Route::match(['get', 'post'], 'google-config', [SocialiteController::class, 'googleConfig'])->name('google.control');
        Route::match(['get', 'post'], 'facebook-config', [SocialiteController::class, 'facebookConfig'])->name('facebook.control');
        Route::match(['get', 'post'], 'github-config', [SocialiteController::class, 'githubConfig'])->name('github.control');


        /* ===== Virtual Card Settings ===== */
        Route::match(['get', 'post'], 'virtual-card.settings', [BasicControlController::class, 'virtualCardSettings'])->name('virtual-card.settings');
        Route::match(['get', 'post'], 'money-transfer.settings', [BasicControlController::class, 'moneyTransferSettings'])->name('money-transfer.settings');
        Route::match(['get', 'post'], 'refer-user.settings', [BasicControlController::class, 'referUserSettings'])->name('refer-user.settings');


        /* ===== STORAGE ===== */
        Route::get('storage', [StorageController::class, 'index'])->name('storage.index');
        Route::any('storage/edit/{id}', [StorageController::class, 'edit'])->name('storage.edit');
        Route::any('storage/update/{id}', [StorageController::class, 'update'])->name('storage.update');
        Route::post('storage/set-default/{id}', [StorageController::class, 'setDefault'])->name('storage.setDefault');

        /* ===== Maintenance Mode ===== */
        Route::get('maintenance-mode', [MaintenanceModeController::class, 'index'])->name('maintenance.index');
        Route::post('maintenance-mode/update', [MaintenanceModeController::class, 'maintenanceModeUpdate'])->name('maintenance.mode.update');

        /* ===== LOGO, FAVICON UPDATE ===== */
        Route::get('logo-setting', [LogoController::class, 'logoSetting'])->name('logo.settings');
        Route::post('logo-update', [LogoController::class, 'logoUpdate'])->name('logo.update');


        /* ===== FIREBASE CONFIG ===== */
        Route::get('firebase-config', [FirebaseConfigController::class, 'firebaseConfig'])->name('firebase.config');
        Route::post('firebase-config-update', [FirebaseConfigController::class, 'firebaseConfigUpdate'])->name('firebase.config.update');

        /* ===== PUSHER CONFIG ===== */
        Route::get('pusher-config', [PusherConfigController::class, 'pusherConfig'])->name('pusher.config');
        Route::post('pusher-config-update', [PusherConfigController::class, 'pusherConfigUpdate'])->name('pusher.config.update');

        /* ===== EMAIL CONFIG ===== */
        Route::get('email-controls', [EmailConfigController::class, 'emailControls'])->name('email.control');
        Route::get('email-config/edit/{method}', [EmailConfigController::class, 'emailConfigEdit'])->name('email.config.edit');
        Route::post('email-config/update/{method}', [EmailConfigController::class, 'emailConfigUpdate'])->name('email.config.update');
        Route::post('email-config/set-as-default/{method}', [EmailConfigController::class, 'emailSetAsDefault'])->name('email.set.default');
        Route::post('test.email', [EmailConfigController::class, 'testEmail'])->name('test.email');


        /* Notification Templates Routes */
        Route::match(['get', 'post'], 'default-template', [NotificationTemplateController::class, 'defaultTemplate'])->name('email.template.default');
        Route::get('email-templates', [NotificationTemplateController::class, 'emailTemplates'])->name('email.templates');
        Route::get('email-template/edit/{id}', [NotificationTemplateController::class, 'editEmailTemplate'])->name('email.template.edit');
        Route::put('email-template/{id?}/{language_id}', [NotificationTemplateController::class, 'updateEmailTemplate'])->name('email.template.update');

        Route::get('sms-templates', [NotificationTemplateController::class, 'smsTemplates'])->name('sms.templates');
        Route::get('sms-template/edit/{id}', [NotificationTemplateController::class, 'editSmsTemplate'])->name('sms.template.edit');
        Route::put('sms-template/{id?}/{language_id}', [NotificationTemplateController::class, 'updateSmsTemplate'])->name('sms.template.update');

        Route::get('in-app-notification-templates', [NotificationTemplateController::class, 'inAppNotificationTemplates'])
            ->name('in.app.notification.templates');
        Route::get('in-app-notification-template/edit/{id}', [NotificationTemplateController::class, 'editInAppNotificationTemplate'])
            ->name('in.app.notification.template.edit');
        Route::put('in-app-notification-template/{id?}/{language_id}', [NotificationTemplateController::class, 'updateInAppNotificationTemplate'])
            ->name('in.app.notification.template.update');
        Route::get('push-notification-templates', [NotificationTemplateController::class, 'pushNotificationTemplates'])->name('push.notification.templates');
        Route::get('push-notification-template/edit/{id}', [NotificationTemplateController::class, 'editPushNotificationTemplate'])->name('push.notification.template.edit');
        Route::put('push-notification-template/{id?}/{language_id}', [NotificationTemplateController::class, 'updatePushNotificationTemplate'])->name('push.notification.template.update');


        /* ===== EMAIL CONFIG ===== */
        Route::get('sms-configuration', [SmsConfigController::class, 'index'])->name('sms.controls');
        Route::get('sms-config-edit/{method}', [SmsConfigController::class, 'smsConfigEdit'])->name('sms.config.edit');
        Route::post('sms-config-update/{method}', [SmsConfigController::class, 'smsConfigUpdate'])->name('sms.config.update');
        Route::post('sms-method-update/{method}', [SmsConfigController::class, 'manualSmsMethodUpdate'])->name('manual.sms.method.update');
        Route::post('sms-config/set-as-default/{method}', [SmsConfigController::class, 'smsSetAsDefault'])->name('sms.set.default');

        /* ===== PLUGIN CONFIG ===== */
        Route::get('plugin', [PluginController::class, 'pluginConfig'])->name('plugin.config');
        Route::get('plugin/tawk', [PluginController::class, 'tawkConfiguration'])->name('tawk.configuration');
        Route::post('plugin/tawk/Configuration/update', [PluginController::class, 'tawkConfigurationUpdate'])->name('tawk.configuration.update');
        Route::get('plugin/fb-messenger-configuration', [PluginController::class, 'fbMessengerConfiguration'])->name('fb.messenger.configuration');
        Route::post('plugin/fb-messenger-configuration/update', [PluginController::class, 'fbMessengerConfigurationUpdate'])->name('fb.messenger.configuration.update');
        Route::get('plugin/google-recaptcha', [PluginController::class, 'googleRecaptchaConfiguration'])->name('google.recaptcha.configuration');
        Route::post('plugin/google-recaptcha/update', [PluginController::class, 'googleRecaptchaConfigurationUpdate'])->name('google.recaptcha.Configuration.update');
        Route::get('plugin/google-analytics', [PluginController::class, 'googleAnalyticsConfiguration'])->name('google.analytics.configuration');
        Route::post('plugin/google-analytics', [PluginController::class, 'googleAnalyticsConfigurationUpdate'])->name('google.analytics.configuration.update');
        Route::get('plugin/manual-recaptcha', [PluginController::class, 'manualRecaptcha'])->name('manual.recaptcha');
        Route::post('plugin/manual-recaptcha/update', [PluginController::class, 'manualRecaptchaUpdate'])->name('manual.recaptcha.update');
        Route::post('plugin/active-recaptcha', [PluginController::class, 'activeRecaptcha'])->name('active.recaptcha');

        /* ===== ADMIN GOOGLE API SETTING ===== */
        Route::get('translate-api-setting', [TranslateAPISettingController::class, 'translateAPISetting'])->name('translate.api.setting');
        Route::get('translate-api-config/edit/{method}', [TranslateAPISettingController::class, 'translateAPISettingEdit'])->name('translate.api.config.edit');
        Route::post('translate-api-setting/update/{method}', [TranslateAPISettingController::class, 'translateAPISettingUpdate'])->name('translate.api.setting.update');
        Route::post('translate-api-setting/set-as-default/{method}', [TranslateAPISettingController::class, 'translateSetAsDefault'])->name('translate.set.default');


        /* ===== ADMIN LANGUAGE SETTINGS ===== */
        Route::get('languages', [LanguageController::class, 'index'])->name('language.index');
        Route::get('language/create', [LanguageController::class, 'create'])->name('language.create');
        Route::post('language/store', [LanguageController::class, 'store'])->name('language.store');
        Route::get('language/edit/{id}', [LanguageController::class, 'edit'])->name('language.edit');
        Route::put('language/update/{id}', [LanguageController::class, 'update'])->name('language.update');
        Route::delete('language-delete/{id}', [LanguageController::class, 'destroy'])->name('language.delete');
        Route::put('change-language-status/{id}', [LanguageController::class, 'changeStatus'])->name('change.language.status');


        Route::get('{short_name}/keywords', [LanguageController::class, 'keywords'])->name('language.keywords');
        Route::post('language-keyword/{short_name}', [LanguageController::class, 'addKeyword'])->name('add.language.keyword');
        Route::put('language-keyword/{short_name}/{key}', [LanguageController::class, 'updateKeyword'])->name('update.language.keyword');
        Route::delete('language-keyword/{short_name}/{key}', [LanguageController::class, 'deleteKeyword'])->name('delete.language.keyword');
        Route::post('language-import-json', [LanguageController::class, 'importJson'])->name('language.import.json');
        Route::put('update-key/{language}', [LanguageController::class, 'updateKey'])->name('language.update.key');
        Route::post('language/keyword/translate', [LanguageController::class, 'singleKeywordTranslate'])->name('single.keyword.translate');
        Route::post('language/all-keyword/translate/{shortName}', [LanguageController::class, 'allKeywordTranslate'])->name('all.keyword.translate');


        /* ===== ADMIN SUPPORT TICKET ===== */
        Route::get('tickets/{status?}', [SupportTicketController::class, 'tickets'])->name('ticket');
        Route::get('tickets-search/{status}', [SupportTicketController::class, 'ticketSearch'])->name('ticket.search');
        Route::get('tickets-view/{id}', [SupportTicketController::class, 'ticketView'])->name('ticket.view');
        Route::put('ticket-reply/{id}', [SupportTicketController::class, 'ticketReplySend'])->name('ticket.reply');
        Route::get('ticket-download/{ticket}', [SupportTicketController::class, 'ticketDownload'])->name('ticket.download');
        Route::post('ticket-closed/{id}', [SupportTicketController::class, 'ticketClosed'])->name('ticket.closed');
        Route::post('ticket-delete', [SupportTicketController::class, 'ticketDelete'])->name('ticket.delete');

        /* ===== InAppNotificationController SETTINGS ===== */
        Route::get('push-notification-show', [InAppNotificationController::class, 'showByAdmin'])->name('push.notification.show');
        Route::get('push.notification.readAll', [InAppNotificationController::class, 'readAllByAdmin'])->name('push.notification.readAll');
        Route::get('push-notification-readAt/{id}', [InAppNotificationController::class, 'readAt'])->name('push.notification.readAt');

        /* PAYMENT METHOD MANAGE BY ADMIN*/
        Route::get('payment-methods', [PaymentMethodController::class, 'index'])->name('payment.methods');
        Route::get('edit-payment-methods/{id}', [PaymentMethodController::class, 'edit'])->name('edit.payment.methods');
        Route::put('update-payment-methods/{id}', [PaymentMethodController::class, 'update'])->name('update.payment.methods');
        Route::post('sort-payment-methods', [PaymentMethodController::class, 'sortPaymentMethods'])->name('sort.payment.methods');
        Route::post('payment-methods/deactivate', [PaymentMethodController::class, 'deactivate'])->name('payment.methods.deactivate');
        Route::post('payment-methods/auto-update/{id}', [PaymentMethodController::class, 'autoUpdate'])->name('payment.method.auto.update');


        /*=* MANUAL METHOD MANAGE BY ADMIN *=*/
        Route::get('payment-methods/manual', [ManualGatewayController::class, 'index'])->name('deposit.manual.index');
        Route::get('payment-methods/manual/create', [ManualGatewayController::class, 'create'])->name('deposit.manual.create');
        Route::post('payment-methods/manual/store', [ManualGatewayController::class, 'store'])->name('deposit.manual.store');
        Route::get('payment-methods/manual/edit/{id}', [ManualGatewayController::class, 'edit'])->name('deposit.manual.edit');
        Route::put('payment-methods/manual/update/{id}', [ManualGatewayController::class, 'update'])->name('deposit.manual.update');

        /*= MANAGE KYC =*/
        Route::get('kyc-setting/list', [KycController::class, 'index'])->name('kyc.form.list');
        Route::get('kyc-setting/create', [KycController::class, 'create'])->name('kyc.create');
        Route::post('manage-kyc/store', [KycController::class, 'store'])->name('kyc.store');
        Route::get('manage-kyc/edit/{id}', [KycController::class, 'edit'])->name('kyc.edit');
        Route::post('manage-kyc/update/{id}', [KycController::class, 'update'])->name('kyc.update');
        Route::get('kyc/{status?}', [KycController::class, 'userKycList'])->name('kyc.list');
        Route::get('kyc/search/{status?}', [KycController::class, 'userKycSearch'])->name('kyc.search');
        Route::get('kyc/view/{id}', [KycController::class, 'view'])->name('kyc.view');
        Route::post('user/kyc/action/{id}', [KycController::class, 'action'])->name('kyc.action');
        Route::get('user/kyc-search', [KycController::class, 'searchKyc'])->name('userKyc.search');
        /*= Frontend Manage =*/
        Route::get('frontend/pages/{theme}', [PageController::class, 'index'])->name('page.index');
        Route::get('frontend/create-page/{theme}', [PageController::class, 'create'])->name('create.page');
        Route::post('frontend/create-page/store/{theme}', [PageController::class, 'store'])->name('create.page.store');
        Route::get('frontend/edit-page/{id}/{theme}/{language?}', [PageController::class, 'edit'])->name('edit.page');
        Route::post('frontend/update-page/{id}/{theme}', [PageController::class, 'update'])->name('update.page');
        Route::post('frontend/page/update-slug', [PageController::class, 'updateSlug'])->name('update.slug');
        Route::delete('frontend/page/delete/{id}', [PageController::class, 'delete'])->name('page.delete');

        Route::get('frontend/edit-static-page/{id}/{theme}/{language?}', [PageController::class, 'editStaticPage'])->name('edit.static.page');
        Route::post('frontend/update-static-page/{id}/{theme}', [PageController::class, 'updateStaticPage'])->name('update.static.page');

        Route::get('frontend/page/seo/{id}', [PageController::class, 'pageSEO'])->name('page.seo');
        Route::post('frontend/page/seo/update/{id}', [PageController::class, 'pageSeoUpdate'])->name('page.seo.update');

        Route::get('frontend/manage-menu', [ManageMenuController::class, 'manageMenu'])->name('manage.menu');
        Route::post('frontend/header-menu-item/store', [ManageMenuController::class, 'headerMenuItemStore'])->name('header.menu.item.store');
        Route::post('frontend/footer-menu-item/store', [ManageMenuController::class, 'footerMenuItemStore'])->name('footer.menu.item.store');
        Route::post('frontend/manage-menu/add-custom-link', [ManageMenuController::class, 'addCustomLink'])->name('add.custom.link');
        Route::get('frontend/manage-menu/edit-custom-link/{pageId}', [ManageMenuController::class, 'editCustomLink'])->name('edit.custom.link');
        Route::post('frontend/manage-menu/update-custom-link/{pageId}', [ManageMenuController::class, 'updateCustomLink'])->name('update.custom.link');
        Route::delete('frontend/manage-menu/delete-custom-link/{pageId}', [ManageMenuController::class, 'deleteCustomLink'])->name('delete.custom.link');
        Route::get('frontend/manage-menu/get-custom-link-data', [ManageMenuController::class, 'getCustomLinkData'])->name('get.custom.link');

        Route::get('frontend/contents/{name}', [ContentController::class, 'index'])->name('manage.content');
        Route::post('frontend/contents/store/{name}/{language}', [ContentController::class, 'store'])->name('content.store');
        Route::get('frontend/contents/item/{name}', [ContentController::class, 'manageContentMultiple'])->name('manage.content.multiple');
        Route::post('frontend/contents/item/store/{name}/{language}', [ContentController::class, 'manageContentMultipleStore'])->name('content.multiple.store');
        Route::get('frontend/contents/item/edit/{name}/{id}', [ContentController::class, 'multipleContentItemEdit'])->name('content.item.edit');
        Route::post('frontend/contents/item/update/{name}/{id}/{language}', [ContentController::class, 'multipleContentItemUpdate'])->name('multiple.content.item.update');
        Route::delete('frontend/contents/delete/{id}', [ContentController::class, 'ContentDelete'])->name('content.item.delete');

        /*====Manage Users ====*/
        Route::get('login/as/user/{id}', [UsersController::class, 'loginAsUser'])->name('login.as.user');
        Route::post('block-profile/{id}', [UsersController::class, 'blockProfile'])->name('block.profile');
        Route::get('users', [UsersController::class, 'index'])->name('users');
        Route::get('users/search', [UsersController::class, 'search'])->name('users.search');
        Route::post('users-delete-multiple', [UsersController::class, 'deleteMultiple'])->name('user.delete.multiple');
        Route::get('user/edit/{id}', [UsersController::class, 'userEdit'])->name('user.edit');
        Route::post('user/update/{id}', [UsersController::class, 'userUpdate'])->name('user.update');
        Route::post('user/email/{id}', [UsersController::class, 'EmailUpdate'])->name('user.email.update');
        Route::post('user/username/{id}', [UsersController::class, 'usernameUpdate'])->name('user.username.update');
        Route::post('user/update-balance/{uuid}', [UsersController::class, 'updateBalanceUpdate'])->name('user.update.balance');
        Route::post('user/password/{id}', [UsersController::class, 'passwordUpdate'])->name('user.password.update');
        Route::post('user/preferences/{id}', [UsersController::class, 'preferencesUpdate'])->name('user.preferences.update');
        Route::post('user/two-fa-security/{id}', [UsersController::class, 'userTwoFaUpdate'])->name('user.twoFa.update');
        Route::post('user/balance-update/{id}', [UsersController::class, 'userBalanceUpdate'])->name('user-balance-update');

        Route::get('user/send-email/{id}', [UsersController::class, 'sendEmail'])->name('send.email');
        Route::post('user/send-email/{id?}', [UsersController::class, 'sendMailUser'])->name('user.email.send');
        Route::get('mail-all-user', [UsersController::class, 'mailAllUser'])->name('mail.all.user');

        Route::get('/email-send', [UsersController::class, 'emailToUsers'])->name('email-send');
        Route::post('/email-send', [UsersController::class, 'sendEmailToUsers'])->name('email-send.store');
        Route::delete('user/delete/{id}', [UsersController::class, 'userDelete'])->name('user.delete');

        Route::get('users/add', [UsersController::class, 'userAdd'])->name('users.add');
        Route::post('users/store', [UsersController::class, 'userStore'])->name('user.store');
        Route::get('users/added-successfully/{id}', [UsersController::class, 'userCreateSuccessMessage'])
            ->name('user.create.success.message');

        Route::get('user/view-profile/{id}', [UsersController::class, 'userViewProfile'])->name('user.view.profile');
        Route::get('user/transaction/{id}', [UsersController::class, 'transaction'])->name('user.transaction');
        Route::get('user/transaction/search/{id}', [UsersController::class, 'userTransactionSearch'])->name('user.transaction.search');
        Route::get('user/payment/{id}', [UsersController::class, 'payment'])->name('user.payment');
        Route::get('user/payment/search/{id}', [UsersController::class, 'userPaymentSearch'])->name('user.payment.search');
        Route::get('user/kyc/{id}', [UsersController::class, 'userKyc'])->name('user.kyc.list');
        Route::get('user/kyc/search/{id}', [UsersController::class, 'KycSearch'])->name('user.kyc.search');
        Route::get('user/wallets/{id}', [UsersController::class, 'userWallets'])->name('user.wallets');
        Route::post('user/w-status-change/{id}', [UsersController::class, 'changeWalletStatus'])->name('user.changeWalletStatus');
        Route::get('user/w-transactions/{uuid}', [UsersController::class, 'walletTransaction'])->name('user.walletTransactions');
        Route::get('user/w-transaction-search/{uuid}', [UsersController::class, 'uwtSearch'])->name('user.walletTransaction');



        /* ====== Transaction Log =====*/
        Route::get('transaction', [TransactionLogController::class, 'transaction'])->name('transaction');
        Route::get('transaction/search', [TransactionLogController::class, 'transactionSearch'])->name('transaction.search');

        /* ====== Payment Log =====*/
        Route::get('payment/log', [PaymentLogController::class, 'index'])->name('payment.log');
        Route::get('payment/search', [PaymentLogController::class, 'search'])->name('payment.search');
        Route::get('payment/pending', [PaymentLogController::class, 'pending'])->name('payment.pending');
        Route::get('payment/pending/request', [PaymentLogController::class, 'paymentRequest'])->name('payment.request');
        Route::put('payment/action/{id}', [PaymentLogController::class, 'action'])->name('payment.action');


        /* ====== Blog Category =====*/
        Route::resource('blog-categories', BlogCategoryController::class)
            ->names(['index' => 'blogCatList', 'store' => 'blogCatStore', 'update' => 'blogCatUpdate', 'destroy' => 'blogCatDelete',]);

        Route::resource('blogs', BlogController::class);
        Route::get('blogs/edit/{id}/{language}', [BlogController::class, 'blogEdit'])->name('blog.edit');
        Route::post('blogs/update/{id}/{language}', [BlogController::class, 'blogUpdate'])->name('blog.update');
        Route::post('blogs/slug/update', [BlogController::class, 'slugUpdate'])->name('slug.update');
        Route::get('blogs/seo-page/{id}', [BlogController::class, 'blogSeo'])->name('blog.seo');
        Route::post('blogs/seo-update/{id}', [BlogController::class, 'blogSeoUpdate'])->name('blog.seo.update');


        /* ====== Subscriber =====*/
        Route::resource('subscriber', SubscriberController::class);
        Route::get('send-mail', [SubscriberController::class,'sendEmailForm'])->name('subscriber.mail');
        Route::post('send-email', [SubscriberController::class,'sendEmail'])->name('subscriber.email');

        /* ====== Country =====*/
        Route::any('importCountries', [CountryController::class, 'importCountries'])->name('importCountries');

        Route::resource('country', CountryController::class);
        Route::get('country-list', [CountryController::class, 'countryList'])->name('country.list');
        Route::post('country-delete-multiple', [CountryController::class, 'deleteMultiple'])->name('country.delete.multiple');
        Route::post('country-active-multiple', [CountryController::class, 'activeMultiple'])->name('country.active.multiple');
        Route::post('country-inactive-multiple', [CountryController::class, 'inactiveMultiple'])->name('country.inactive.multiple');
        Route::post('country-send-multiple', [CountryController::class, 'sendMultiple'])->name('country.send.multiple');
        Route::post('country-receive-multiple', [CountryController::class, 'receiveMultiple'])->name('country.receive.multiple');
        Route::get('update-currency-rate', [CountryController::class, 'updateRates'])->name('update.rate');
        Route::get('update-currency-rate-single/{code}', [CountryController::class, 'singleRateUpdate'])->name('country.singleRateUpdate');

        /* ====== State =====*/
        Route::get('country/{country}/states', [CountryController::class, 'countryState'])->name('countryState');
        Route::get('state-list/{country}', [StateController::class, 'stateList'])->name('state.list');
        Route::get('country/{country}/state-create', [StateController::class, 'create'])->name('state.create');
        Route::post('state-store', [StateController::class, 'store'])->name('state.store');
        Route::get('country/{country}/state/{state}/edit', [StateController::class, 'edit'])->name('state.edit');
        Route::put('state-update/{state}', [StateController::class, 'update'])->name('state.update');
        Route::post('state-delete-multiple', [StateController::class, 'deleteMultiple'])->name('state.delete.multiple');
        Route::post('state-active-multiple', [StateController::class, 'activeMultiple'])->name('state.active.multiple');
        Route::post('state-inactive-multiple', [StateController::class, 'inactiveMultiple'])->name('state.inactive.multiple');

        /* ====== City =====*/
        Route::get('country/{country}/states/{state}/cities', [StateController::class, 'stateCity'])->name('stateCity');
        Route::get('country/{country}/states/{state}/city-list', [CityController::class, 'cityList'])->name('city.list');
        Route::get('country/{country}/states/{state}/cities/create', [CityController::class, 'create'])->name('city.create');
        Route::post('country/{country}/states/{state}/city-store', [CityController::class, 'store'])->name('city.store');
        Route::get('country/{country}/states/{state}/city/{city}/edit', [CityController::class, 'edit'])->name('city.edit');
        Route::patch('country/{country}/states/{state}/city/{city}', [CityController::class, 'update'])->name('city.update');

        Route::post('city-delete-multiple', [CityController::class, 'deleteMultiple'])->name('city.delete.multiple');
        Route::post('city-active-multiple', [CityController::class, 'activeMultiple'])->name('city.active.multiple');
        Route::post('city-inactive-multiple', [CityController::class, 'inactiveMultiple'])->name('city.inactive.multiple');

        /* ====== Banks =====*/
        Route::get('country/{country}/banks', [CountryController::class, 'countryBank'])->name('countryBank');
        Route::get('country/{country}/banks-list', [BanksController::class, 'bankList'])->name('bank.list');
        Route::get('country/{country}/bank-create', [BanksController::class, 'create'])->name('bank.create');
        Route::post('bank-store', [BanksController::class, 'store'])->name('bank.store');
        Route::get('country/{country}/bank/{bank}/edit', [BanksController::class, 'edit'])->name('bank.edit');
        Route::put('bank-update/{bank}', [BanksController::class, 'update'])->name('bank.update');
        Route::post('bank-delete-multiple', [BanksController::class, 'deleteMultiple'])->name('bank.delete.multiple');
        Route::post('bank-active-multiple', [BanksController::class, 'activeMultiple'])->name('bank.active.multiple');
        Route::post('bank-inactive-multiple', [BanksController::class, 'inactiveMultiple'])->name('bank.inactive.multiple');

        /* ====== Services =====*/
        Route::get('services', [ServiceController::class, 'index'])->name('service.index');
        Route::get('service-list', [ServiceController::class, 'serviceList'])->name('service.list');
        Route::get('service-create', [ServiceController::class, 'create'])->name('service.create');
        Route::get('service/{service}/edit', [ServiceController::class, 'edit'])->name('service.edit');
        Route::post('service-store', [ServiceController::class, 'store'])->name('service.store');
        Route::put('service-update/{service}', [ServiceController::class, 'update'])->name('service.update');
        Route::post('service-delete-multiple', [ServiceController::class, 'deleteMultiple'])->name('service.delete.multiple');
        Route::post('service-active-multiple', [ServiceController::class, 'activeMultiple'])->name('service.active.multiple');
        Route::post('service-inactive-multiple', [ServiceController::class, 'inactiveMultiple'])->name('service.inactive.multiple');

        /*==== Virtual Card ===*/
        Route::get('virtual-card', [VirtualCardController::class, 'index'])->name('virtual.card');
        Route::get('virtual-card/edit/{id}', [VirtualCardController::class, 'edit'])->name('virtual.cardEdit');
        Route::put('virtual-card/update/{id}', [VirtualCardController::class, 'update'])->name('virtual.cardUpdate');
        Route::post('virtual-card/status-change/{id}', [VirtualCardController::class, 'statusChange'])->name('virtual.cardStatusCng');

        Route::get('virtual-card/order', [VirtualCardController::class, 'cardOrder'])->name('virtual.cardOrder');
        Route::get('virtual-card/order/detail/{id}', [VirtualCardController::class, 'cardOrderDetail'])->name('virtual.cardOrderDetail');
        Route::post('virtual-card/order/rejected/{id}', [VirtualCardController::class, 'cardOrderRejected'])->name('virtual.cardOrderRejected');
        Route::get('virtual-card/order/approve/{id}', [VirtualCardController::class, 'cardOrderApprove'])->name('virtual.cardOrderApprove');

        Route::get('virtual-card/list/{type?}', [VirtualCardController::class, 'cardList'])->name('virtual.cardList');
        Route::get('virtual-card/list/view/{id}', [VirtualCardController::class, 'cardView'])->name('virtual.cardView');
        Route::get('virtual-card/transaction/{id}', [VirtualCardController::class, 'cardTransaction'])->name('virtual.cardTransaction');
        Route::post('virtual-card/block/{id}', [VirtualCardController::class, 'cardBlock'])->name('virtual.cardBlock');
        Route::post('virtual-card/un-block/{id}', [VirtualCardController::class, 'cardUnBlock'])->name('virtual.cardUnBlock');
        Route::post('virtual-card/fund-approve/{id}', [VirtualCardController::class, 'cardFundApprove'])->name('virtual.cardFundApprove');
        Route::post('virtual-card/fund-return/{id}', [VirtualCardController::class, 'cardFundReturn'])->name('virtual.cardFundReturn');


        /*=== Money Transfer ===*/
        Route::get('money-transfer', [MoneyTransferController::class, 'transferList'])->name('transferList');
        Route::get('money-transfer-search', [MoneyTransferController::class, 'transferSearch'])->name('transferSearch');
        Route::get('money-transfer-details/{uuid}', [MoneyTransferController::class, 'transferView'])->name('transferView');

        Route::get('money-transfer/approve/{id}', [MoneyTransferController::class, 'approve'])->name('transferApprove');
        Route::post('money-transfer/rejected/{id}', [MoneyTransferController::class, 'reject'])->name('transferRejected');

    });

});


