<?php

use App\Http\Controllers\AcademicLevelController;
use App\Http\Controllers\AcademicSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\SiteAdminController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\CustomExceptionController;
use App\Http\Controllers\OrganizationTypeController;
use App\Http\Controllers\OrganizationLevelController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SchoolLevelController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\WelcomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/unsubscribe/{token}', function () {
    return view('components.front-end.unsubscribe');
})->name('unsubscribe');

Route::post('/unsubscribe/confirm', [SubscriptionController::class, 'confirmUnsubscribe'])->name('unsubscribe.confirm');
Route::get('/callback', [CalendarController::class, 'calendarCallback'])->name('calendar-callback');

##forgotPassword
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

##Auth
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('/login-user', [AuthController::class, 'loginUser'])->name('login.user');
Route::get('/register', [AuthController::class, 'create'])->name('auth.create');
Route::post('/signup', [AuthController::class, 'signup'])->name('auth.signup');

Route::resource('/user', UserController::class);

Route::post('/delete-all-data', [CustomExceptionController::class, 'deleteAllData'])->name('delete.all.data');
Route::resource('subscriptions', SubscriptionController::class);

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::resource('visitors', VisitorController::class)->only('store');




Route::resource('contact-us', ContactUsController::class)->only('store');
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::prefix('admin')->group(function () {
        Route::name('admin.')->group(function () {
            Route::resource('users', UserController::class);
            Route::resource('organization-types', OrganizationTypeController::class);
            Route::resource('organization-levels', OrganizationLevelController::class);
            Route::resource('organizations', OrganizationController::class);
            Route::resource('helps', HelpController::class);
            Route::resource('emails', EmailController::class);
            Route::resource('regions', RegionController::class);

            Route::resource('school-levels', SchoolLevelController::class);
            Route::resource('schools', SchoolController::class);
            Route::resource('academic-levels', AcademicLevelController::class);
            Route::resource('departments', DepartmentController::class);
            Route::resource('lecturers', LecturerController::class);
            Route::resource('students', StudentController::class);
            Route::resource('courses', CourseController::class);
            Route::resource('academic-sessions', AcademicSessionController::class);
            Route::resource('visitors', VisitorController::class)->except('store');

            Route::resource('zones', ZoneController::class);
            Route::resource('custom-exceptions', CustomExceptionController::class);
            Route::resource('audit', AuditController::class);
            Route::resource('settings', SettingController::class);
            Route::resource('contact-us', ContactUsController::class)->except('store');
            Route::post('contact-message', [ContactUsController::class, 'storeReply'])->name('contact-message.storeReply');
            Route::post('update-address/{id}', [SiteAdminController::class, 'update'])->name('updateaddress');
            Route::get('/site-admin', [SiteAdminController::class, 'index'])->name('siteAdmins.index');
            Route::resource('roles', RoleController::class);
            Route::resource('permissions', PermissionController::class);
            Route::get('/change-password', [AuthController::class, 'changePassword'])->name('changePassword');
            Route::get('/reset', [AuditController::class, 'reset'])->name('reset');
            Route::post('/change-password', [AuthController::class, 'changePasswordSave'])->name('postChangePassword');

            Route::put('/organizations/authorize/{organization}', [OrganizationController::class, 'authorizeOrganization'])->name('organizations.authorize');
            Route::put('/organizations/unauthorize/{organization}', [OrganizationController::class, 'unAuthorizeOrganization'])->name('organizations.unauthorize');
            Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
            Route::post('/change-profile', [ProfileController::class, 'changeProfile'])->name('postProfile');
            Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
            Route::get('/analysis', [AnalysisController::class, 'visualize'])->name('analysis');


        });
    });
});

