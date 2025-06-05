<?php

use App\Http\Controllers\Cabinet\ProfileController as CabinetProfileController;
use App\Http\Controllers\Cabinet\CabinetController;
use App\Http\Controllers\Cabinet\OrderController as CabinetOrderController;
use App\Http\Controllers\Cabinet\ReservationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Store\StoreController;
use App\Http\Controllers\Store\BucketController as StoreBucketController;
use App\Http\Controllers\Store\OrderController as StoreOrderController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\TourController as AdminTourController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\ReservationTypeController;
use App\Http\Controllers\Admin\ReservationStepTemplateController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\BlockController as AdminBlockController;
use App\Http\Controllers\Api\ReservationTypeApiController;
use App\Http\Controllers\PageController;




// ---------------- Публичные страницы ----------------

Route::get('/', [HomeController::class, 'index'])->name('home');
// routes/web.php
Route::get('/tours/pfwt', function () {
    return view('tour');
});
Route::get('/events/pfw', function () {
    return view('event');
});

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', function () { return view('services'); })->name('services');
Route::get('/services/{slug}', [ServiceController::class, 'show']);
Route::get('/tours', function () { return view('tours'); })->name('tours');
Route::get('/tours/{slug}', [TourController::class, 'show']);
Route::get('/events', function () { return view('events'); })->name('events');
Route::get('/events/{slug}', [AdminEventController::class, 'show']);
Route::get('/store', [StoreController::class, 'index'])->name('store.index');
Route::get('/store/{slug}', [StoreController::class, 'show']);
Route::get('/contacts', function () { return view('contacts'); })->name('contacts');

Route::get('/service/personal-styling', function () {
    return view('service');
});
Route::get('/instagram', function () {
    return view('instagram');
});

Route::get('/set-lang/{lang}', function($lang) {
    if (in_array($lang, ['ru','en'])) {
        session(['locale' => $lang]);
        app()->setLocale($lang); // для немедленного применения
    }
    return back();
})->name('setlang');



Route::prefix('store')->group(function () {
    Route::get('/bucket', [StoreBucketController::class, 'index'])->name('store.bucket.index');
    Route::post('/bucket/add/{productId}', [StoreBucketController::class, 'add'])->name('store.bucket.add');
    Route::delete('/bucket/remove/{productId}', [StoreBucketController::class, 'remove'])->name('store.bucket.remove');
    Route::get('/', [StoreController::class, 'index'])->name('store.index');
    Route::get('/{slug}', [StoreController::class, 'show'])->name('store.show');
    Route::post('/checkout', [StoreOrderController::class, 'store'])->name('store.checkout.store');
});

Route::resource('/reservation-types', ReservationTypeController::class)
    ->except(['show'])
    ->names('reservation-types');
Route::get('/reservation-type/{id}/items', [ReservationTypeApiController::class, 'items']);


// ---------------- Аутентификация ----------------
require __DIR__.'/auth.php';

// ---------------- Кабинет пользователя ----------------

Route::middleware(['auth'])->prefix('cabinet')->group(function () {
    Route::get('/', [CabinetController::class, 'index'])->name('cabinet');
    Route::get('/orders', [CabinetOrderController::class, 'index'])->name('cabinet.orders.index');
Route::get('/orders/{order}', [CabinetOrderController::class, 'show'])->name('cabinet.orders.show');
Route::get('/orders/{order}/invoice', [CabinetOrderController::class, 'invoice'])->name('cabinet.orders.invoice');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::get('/orders/{order}/invoice', [CabinetOrderController::class, 'invoice'])->name('cabinet.orders.invoice');
    // Создание новой резервации (по выбору тура или услуги)
Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::patch('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('cabinet.reservations.cancel');
    // Профиль пользователя внутри кабинета
    Route::get('/profile', [CabinetProfileController::class, 'edit'])->name('cabinet.profile.edit');
    Route::patch('/profile', [CabinetProfileController::class, 'update'])->name('cabinet.profile.update');
    Route::delete('/profile', [CabinetProfileController::class, 'destroy'])->name('cabinet.profile.destroy');
});

// Пользовательский маршрут отображения и отправки формы для шага резервации
Route::middleware(['auth'])->group(function () {
    Route::get('reservations/{reservation}/steps/{step}/form', [\App\Http\Controllers\ReservationStepFormController::class, 'show'])
        ->name('reservations.steps.form.show');
    Route::post('reservations/{reservation}/steps/{step}/form', [\App\Http\Controllers\ReservationStepFormController::class, 'submit'])
        ->name('reservations.steps.form.submit');
});



// ---------------- Админка ----------------

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('/services', AdminServiceController::class);
    Route::resource('/tours', AdminTourController::class);
    Route::resource('/products', AdminProductController::class);
    Route::resource('/events', AdminEventController::class);
    Route::resource('/reservations', \App\Http\Controllers\Admin\ReservationController::class)->only(['index', 'edit', 'update']);
    // Типы резерваций
Route::resource('/reservation-types', ReservationTypeController::class)->except(['show']);
// Шаблоны шагов для типа резервации
Route::resource('/reservation-types/{type}/steps', ReservationStepTemplateController::class)->except(['show']);
Route::resource('pages', AdminPageController::class)->except(['show']);
Route::resource('blocks', AdminBlockController::class)->except(['show']);
Route::patch('/tours/{tour}/toggle-status', [TourController::class, 'toggleStatus'])->name('tours.toggleStatus');
// Формы (CRUD)
Route::resource('forms', \App\Http\Controllers\Admin\FormController::class);
Route::resource('forms.fields', \App\Http\Controllers\Admin\FormFieldController::class);
// Поля формы (CRUD только внутри формы)
Route::post('forms/{form}/fields', [\App\Http\Controllers\Admin\FormFieldController::class, 'store'])->name('forms.fields.store');
Route::put('forms/{form}/fields/{field}', [\App\Http\Controllers\Admin\FormFieldController::class, 'update'])->name('forms.fields.update');
Route::delete('forms/{form}/fields/{field}', [\App\Http\Controllers\Admin\FormFieldController::class, 'destroy'])->name('forms.fields.destroy');
Route::get('forms/{form}/fields/create', [\App\Http\Controllers\Admin\FormFieldController::class, 'create'])->name('forms.fields.create');
Route::get('forms/{form}/fields/{field}/edit', [\App\Http\Controllers\Admin\FormFieldController::class, 'edit'])->name('forms.fields.edit');

// Ответы на формы
Route::get('form-responses', [\App\Http\Controllers\Admin\FormResponseController::class, 'index'])->name('form_responses.index');
Route::get('form-responses/{response}', [\App\Http\Controllers\Admin\FormResponseController::class, 'show'])->name('form_responses.show');
});

Route::prefix('reservation-types/{type}/steps')->name('reservation-types.steps.')->group(function () {
    Route::get('/', [ReservationStepTemplateController::class, 'index'])->name('index');
    Route::get('/create', [ReservationStepTemplateController::class, 'create'])->name('create');
    Route::post('/', [ReservationStepTemplateController::class, 'store'])->name('store');
    Route::get('/{step}/edit', [ReservationStepTemplateController::class, 'edit'])->name('edit');
    Route::put('/{step}', [ReservationStepTemplateController::class, 'update'])->name('update');
    Route::delete('/{step}', [ReservationStepTemplateController::class, 'destroy'])->name('destroy');
});

Route::get('/auth/{provider}', [SocialAuthController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback']);
Route::get('/{slug}', [AdminPageController::class, 'show'])->name('page.show');


