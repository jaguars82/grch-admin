<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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

/* Change Lang */
Route::get('lang/{locale}', function ($locale) {
    // Available languages
    $availableLangs = [
        'en' => 'en',
        'ru' => 'ru',
    ];
    if (array_key_exists($locale, $availableLangs)) {
        session()->put('locale', $locale);
    }
    return redirect()->back();


})->name('lang');
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    })->name('/');


    /*They are the required pages for the system, don't delete it*/
    Route::prefix('settings')->group(function () {

        /*Settings Summary*/
        Route::get('/', function () {
            return Inertia::render('Settings/Index', [
                'users_count' => count(\App\Models\User::all('id')),
                'roles_count' => count(Role::all()),
                'permissions_count' => count(Permission::all())
            ]);
        })->name('settings');

        /*Get Routes*/
        Route::get('system', function () {
            return Inertia::render('Settings/System');
        })->name('settings-system');

        /*Resource Routes*/
        Route::resources([
            'settings-user'=> \App\Http\Controllers\Settings\UserController::class,
            'settings-role' => \App\Http\Controllers\Settings\RoleController::class,
            'settings-permission' => \App\Http\Controllers\Settings\PermissionController::class
        ]);

        /*Search Routes for Resource Routes*/
        Route::post('settings-user', [\App\Http\Controllers\Settings\UserController::class, 'index'])->name('settings-user.search');
        Route::post('settings-role', [\App\Http\Controllers\Settings\RoleController::class, 'index'])->name('settings-role.search');
        Route::post('settings-permission', [\App\Http\Controllers\Settings\PermissionController::class, 'index'])->name('settings-permission.search');

    });

    /* Admin Panel Pages */

    // Company Section
    // Developer
    Route::get('/company/developer', [\App\Http\Controllers\DeveloperController::class, 'index'])->name('developer-index');
    Route::get('/company/developer/create', [\App\Http\Controllers\DeveloperController::class, 'create'])->name('developer-create');
    Route::post('/company/developer/store', [\App\Http\Controllers\DeveloperController::class, 'store'])->name('developer-store');
    Route::get('/company/developer/{id}/edit', [\App\Http\Controllers\DeveloperController::class, 'edit'])->name('developer-edit');
    Route::post('/company/developer/update', [\App\Http\Controllers\DeveloperController::class, 'update'])->name('developer-update');
    Route::delete('/company/developer/{id}/delete', [\App\Http\Controllers\DeveloperController::class, 'delete'])->name('developer-delete');
    Route::post('/company/developer/{id}/logo-delete', [\App\Http\Controllers\DeveloperController::class, 'deleteLogo']);

    // Info Section
    // Tutorial
    Route::get('/information/tutorial', [\App\Http\Controllers\TutorialController::class, 'index'])->name('tutorial-index');
    Route::match(['get', 'post'], '/information/tutorial/lesson/create', [\App\Http\Controllers\TutorialController::class, 'createLesson'])->name('tutorial-lesson-create');
    Route::match(['get', 'post'], '/information/tutorial/lesson/update', [\App\Http\Controllers\TutorialController::class, 'updateLesson'])->name('tutorial-lesson-update');
    Route::post('/information/tutorial/lesson/delete', [\App\Http\Controllers\TutorialController::class, 'deleteLesson'])->name('tutorial-lesson-delete');
    Route::post('/information/tutorial/lesson/reoder', [\App\Http\Controllers\TutorialController::class, 'reoderLessons'])->name('tutorial-lesson-reoder');

    // Tariff
    Route::get('tariff', [\App\Http\Controllers\TariffController::class, 'edit'])->name('tariff-edit');
    Route::post('tariff', [\App\Http\Controllers\TariffController::class, 'update'])->name('tariff-update');
    //Route::match(['get', 'post'], 'tariff', [\App\Http\Controllers\TariffController::class, 'edit'])->name('tariff-edit');


    // Statistics Section
    // Booking
    Route::get('/stats/booking', [\App\Http\Controllers\Stats\BookingController::class, 'index'])->name('stats-booking');
    
    // Update Newbuilding Complexes from Feed
    Route::get('/stats/feed-update', [\App\Http\Controllers\Stats\FeedUpdateController::class, 'index'])->name('stats-feed-update');

    /*This pages for example, you can delete when you design the your system*/
    //Example Pages
    /*
    Route::get('login-app', function () {
        return Inertia::render('Samples/Examples/Login');
    })->name('login-app');
    Route::get('lock-app-3', function () {
        return Inertia::render('Samples/Examples/Auth/Lock3');
    })->name('lock-app-3');
    Route::get('profile', function () {
        return Inertia::render('Samples/Examples/Profile');
    })->name('profile');
    Route::get('table', function () {
        return Inertia::render('Samples/Components/Table', [
            'users' => \App\Models\User::all()
        ]);
    })->name('table');
    Route::match(['get', 'post'], 'back-end-table', [\App\Http\Controllers\DemoContentController::class, 'index'])->name('back-end-table');

    Route::resource('product', \App\Http\Controllers\DemoContentController::class);
    Route::post('product', [\App\Http\Controllers\DemoContentController::class, 'index'])->name('product.search');
    */

    /*TODO: Toastr Feature
    Route::get('toastr',function (){return Inertia::render('Samples/Components/Toastr');})->name('toastr');*/
    /*
    Route::get('tooltip', function () {
        return Inertia::render('Samples/Components/Tooltip');
    })->name('tooltip');
    // Layout Pages
    Route::get('layout-structure', function () {
        return Inertia::render('Samples/Layouts/LayoutStructure');
    })->name('layout-structure');
    Route::get('layout-grid', function () {
        return Inertia::render('Samples/Layouts/Grid');
    })->name('layout-grid');
    Route::get('layout-statistic-widget', function () {
        return Inertia::render('Samples/Layouts/StatisticWidget');
    })->name('layout-statistic-widget');
    Route::get('test', function () {
        return Inertia::render('Samples/Test');
    })->name('test');
    // Form Pages
    Route::get('form-structure', function () {
        return Inertia::render('Samples/FormElements/FormStructure');
    })->name('form-structure');
    Route::get('form-input-group', function () {
        return Inertia::render('Samples/FormElements/InputGroup');
    })->name('form-input-group');

    Route::get('form-select-input', function () {
        return Inertia::render('Samples/FormElements/SelectInput', [
            'users' => \App\Models\User::all()
        ]);
    })->name('form-select-input');
    */

});



