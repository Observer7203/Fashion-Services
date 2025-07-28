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
use App\Http\Controllers\BucketController as StoreBucketController;
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
use App\Http\Controllers\Admin\HomepageController as HomepageController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Middleware\LocaleFromUrl;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;
use App\Http\Controllers\CheckoutController;




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
Route::get('/services', [\App\Http\Controllers\ServiceController::class, 'index'])->name('services');


Route::get('/tours/{slug}', [TourController::class, 'show'])->name('tours_2.show');
Route::get('/events', function () { return view('events'); })->name('events');
Route::get('/events/{slug}', [AdminEventController::class, 'show']);
Route::get('/store', [StoreController::class, 'index'])->name('store.index');
Route::get('/store/{slug}', [StoreController::class, 'show']);
Route::get('/contacts', function () { return view('contacts'); })->name('contacts');

Route::get('/tours/pfwt', function () {
    return view('tour');
})->name('tour.pfwt');

Route::get('/events/pfw', function () {
    return view('event');
})->name('event.pfw');


Route::get('/service/personal-styling', function () {
    return view('service');
});
Route::get('/instagram', function () {
    return view('instagram');
});

// routes/web.php
Route::prefix('{locale}')
    ->where(['locale' => 'ru|en'])
    ->middleware([LocaleFromUrl::class])
    ->group(function () {
        Route::get('/admin/services', [\App\Http\Controllers\Admin\ServiceController::class, 'index'])->name('services.index');
        Route::get('/services', [ServiceController::class, 'index'])->name('services');
        Route::get('/services/{slug}', [\App\Http\Controllers\ServiceController::class, 'show'])->name('services_2.show');
        Route::get('/tours/{slug}', [TourController::class, 'show'])->name('tours_2.show');
        Route::get('/tours', [TourController::class, 'index'])->name('tours_2.index');
        // ... и все остальные маршруты, где нужен язык в URL
    });


Route::get('/test-session', function () {
    session(['locale' => 'en']);
    return session()->get('locale');
});


Route::prefix('store')->group(function () {
    Route::get('/', [StoreController::class, 'index'])->name('store.index');
    Route::get('/{slug}', [StoreController::class, 'show'])->name('store.show');
//    Route::post('/checkout', [StoreOrderController::class, 'store'])->name('store.checkout.store');
});

Route::get('/bucket', [\App\Http\Controllers\BucketController::class, 'index'])->name('bucket.index');
Route::post('/bucket/add', [\App\Http\Controllers\BucketController::class, 'add'])->name('bucket.add');
Route::delete('/bucket/remove/{productId}', [\App\Http\Controllers\BucketController::class, 'remove'])->name('bucket.remove');

// Страница checkout
Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'show'])->name('checkout.show');
// Обработка заказа
// Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/thankyou/{order}', [\App\Http\Controllers\CheckoutController::class, 'thankyou'])->name('checkout.thankyou');
Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');


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
Route::delete('/tours/mass-destroy', [AdminTourController::class, 'massDestroy'])->name('tours.massDestroy');
Route::post('/media/upload', [AdminMediaController::class, 'upload'])->name('admin.media.upload');
Route::delete('/media/delete', [AdminMediaController::class, 'delete'])->name('admin.media.delete');
// Ответы на формы
Route::get('form-responses', [\App\Http\Controllers\Admin\FormResponseController::class, 'index'])->name('form_responses.index');
Route::get('form-responses/{response}', [\App\Http\Controllers\Admin\FormResponseController::class, 'show'])->name('form_responses.show');
Route::get('/homepage', [HomepageController::class, 'edit'])->name('admin.homepage.edit');
Route::post('/homepage', [HomepageController::class, 'update'])->name('admin.homepage.update');
Route::post('/homepage/upload', [HomepageController::class, 'upload'])->name('admin.upload');
Route::get('about/edit', [\App\Http\Controllers\Admin\AboutPageController::class, 'edit'])->name('admin.about.edit');
Route::post('about/update', [\App\Http\Controllers\Admin\AboutPageController::class, 'update'])->name('admin.about.update');


Route::get('/regen-products', function () {
    foreach (\App\Models\Service::all() as $s) {
        if (!\App\Models\Product::where('service_id', $s->id)->exists()) {
            \App\Models\Product::create([
                'title' => $s->title,
                'slug'  => \Illuminate\Support\Str::slug($s->title) . '-' . $s->id,
                'description' => $s->description,
                'price' => $s->price,
                'media' => $s->media,
                'category' => 'service',
                'type' => 'service',
                'stock' => 999,
                'status' => $s->status ?? 'active',
                'service_id' => $s->id
            ]);
        }
    }

    foreach (\App\Models\Tour::all() as $t) {
        if (!\App\Models\Product::where('tour_id', $t->id)->exists()) {
            \App\Models\Product::create([
                'title' => $t->title,
                'slug'  => \Illuminate\Support\Str::slug($t->title) . '-' . $t->id,
                'description' => $t->description,
                'price' => $t->price,
                'media' => $t->media,
                'category' => 'tour',
                'type' => 'tour',
                'stock' => 999,
                'status' => $t->status ?? 'active',
                'tour_id' => $t->id
            ]);
        }
    }

    return '✅ Продукты сгенерированы';
});

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


