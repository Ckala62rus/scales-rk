<?php

use App\Http\Controllers\BackupController;
use App\Http\Controllers\BackupDayController;
use App\Http\Controllers\BackupObjectController;
use App\Http\Controllers\BackupPriorityController;
use App\Http\Controllers\BackupToolController;
use App\Http\Controllers\ChannelTypeController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\InternetServiceProviderController;
use App\Http\Controllers\InternetSpeedController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\ScaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
//
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function () {
        return Inertia::render('admin/dashboard');
    })->name('www');

    Route::get('admin/profile', [ProfileController::class, 'profilePage'])->name('metronic.profile');

    Route::group(['prefix' => 'admin'], function () {

        // User
        Route::get('user', [UserController::class, 'index'])->name('metronic.user.index')->middleware(['permission:read user']);
        Route::get('user/paginate', [UserController::class, 'getAllUsersWithPaginate']);
        Route::post('user', [UserController::class, 'store'])->middleware(['permission:create user']);
        Route::get('user/create', [UserController::class, 'create'])->name('metronic.user.create')->middleware(['permission:create user']);
        Route::get('user/{id}', [UserController::class, 'show'])->middleware(['permission:read user']);
        Route::put('user/{id}', [UserController::class, 'update'])->name('metronic.user.update')->middleware(['permission:update user']);
        Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('metronic.user.edit')->middleware(['permission:update user']);
        Route::delete('user/{id}', [UserController::class, 'destroy'])->middleware(['permission:delete user']);

        // Role
        Route::get('role', [RolePermissionController::class, 'index'])->name('metronic.role.index');
        Route::get('role/paginate', [RolePermissionController::class, 'getAllUsersWithPaginate']);
        Route::get('role/create', [RolePermissionController::class, 'create'])->name('metronic.role.create');
        Route::post('role', [RolePermissionController::class, 'store']);
        Route::get('role/all', [RolePermissionController::class, 'getRolesCollection']);
        Route::get('role/{id}', [RolePermissionController::class, 'show']);
        Route::put('role/{id}', [RolePermissionController::class, 'update']);
        Route::get('role/{id}/edit', [RolePermissionController::class, 'edit'])->name('metronic.role.edit');
        Route::delete('role/{id}', [RolePermissionController::class, 'destroy']);

        // Organization
        Route::resource('organizations', OrganizationController::class);
        Route::get('organization-all-paginate', [OrganizationController::class, 'getAllOrganizationsWithPagination']);
        Route::get('organization-all-collection', [OrganizationController::class, 'getOrganizationsCollection']);

        // Equipment
        Route::resource('equipments', EquipmentController::class);
        Route::get('equipments-all-paginate', [EquipmentController::class, 'getAllEquipmentsWithPagination']);
        Route::get('equipments-all-collection', [EquipmentController::class, 'getAllEquipmentsCollection']);

        // Device
        Route::resource('devices', DeviceController::class);
        Route::get('devices-all-paginate', [DeviceController::class, 'getAllDeviceWithPagination']);

        // Export Excel
        Route::get('export', [ExcelController::class, 'exportDevice']);
        Route::get('export-backup', [ExcelController::class, 'exportBackup']);

        // Backup
        Route::resource('backups', BackupController::class);
        Route::get('backups-all-paginate', [BackupController::class, 'getAllBackupWithPagination']);

        // BackupObject
        Route::resource('backup-objects', BackupObjectController::class);
        Route::get('backup-objects-all-paginate', [BackupObjectController::class, 'getAllBackupObjectsWithPagination']);
        Route::get('backup-objects-all-collection', [BackupObjectController::class, 'getAllBackupObjectCollection']);

        // BackupTool
        Route::resource('backup-tools', BackupToolController::class);
        Route::get('backup-tools-all-paginate', [BackupToolController::class, 'getAllBackupObjectsWithPagination']);
        Route::get('backup-tools-all-collection', [BackupToolController::class, 'getAllBackupToolCollection']);

        // BackupDay
        Route::resource('backup-days', BackupDayController::class);
        Route::get('backup-days-all-paginate', [BackupDayController::class, 'getAllBackupDaysWithPagination']);
        Route::get('backup-days-all-collection', [BackupDayController::class, 'getAllBackupDayCollection']);

        // InternetSpeed
        Route::resource('internet-speed', InternetSpeedController::class);
        Route::get('internet-speed-all-paginate', [InternetSpeedController::class, 'getAllInternetSpeedWithPagination']);
        Route::get('internet-speed-all-collection', [InternetSpeedController::class, 'getAllInternetSpeedCollection']);

        // ChannelType
        Route::resource('channel-types', ChannelTypeController::class);
        Route::get('channel-types-all-paginate', [ChannelTypeController::class, 'getAllChannelTypeWithPagination']);
        Route::get('channel-types-all-collection', [ChannelTypeController::class, 'getAllChannelTypeCollection']);

        // InternetServiceProvider (ISP)
        Route::resource('isp', InternetServiceProviderController::class);
        Route::get('isp-all-paginate', [InternetServiceProviderController::class, 'getAllIspWithPagination']);

        // BackupPriority
        Route::resource('backup-priorities', BackupPriorityController::class);
        Route::get('backup-priorities-all-paginate', [BackupPriorityController::class, 'getAllBackupPriorityWithPagination']);
        Route::get('backup-priorities-all-collection', [BackupPriorityController::class, 'getAllBackupPriorityCollection']);

        Route::resource('scales', ScaleController::class);
        Route::get('scales-all-paginate', [ScaleController::class, 'getAllScalesWithPagination']);
    });

    // Permission
    Route::get('admin/permission', [RolePermissionController::class, 'getPermissions']);

    //Avatar
    Route::post('avatar/set', [UserController::class, 'setAvatar']);
    Route::get('avatar/get', [UserController::class, 'getAvatar']);
});

require __DIR__.'/auth.php';


Route::get('job', [UserController::class, 'test_supervisor']);
Route::get('info', [UserController::class, 'info']);
