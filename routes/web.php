<?php
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\Products\OrderController;
use App\Http\Controllers\User\AddressController;
use App\Http\Controllers\Products\ReviewController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Products\CategoryController;
use App\Http\Controllers\Gallery\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Products\CartController;

Auth::routes();

Route::prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/update-password', [ProfileController::class, 'updatePassword'])
    ->name('profile.updatePassword');
    
    Route::post('/address', [ProfileController::class, 'addAddress'])->name('address.add');
    Route::delete('/address/{address}', [ProfileController::class, 'deleteAddress'])->name('address.delete');
    Route::post('/address/{address}/set-default', [ProfileController::class, 'setDefaultAddress'])->name('address.set-default');
});
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/orders/from-cart', [OrderController::class, 'store'])->name('orders.storeFromCart');
});

Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::delete('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])
    ->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'userManagement'])->name('admin.users');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/products/pending', [AdminController::class, 'pendingProducts'])->name('admin.products.pending');
    Route::post('/products/{product}/approve', [AdminController::class, 'approveProduct'])->name('admin.products.approve');
    Route::delete('/products/{product}/reject', [AdminController::class, 'rejectProduct'])->name('admin.products.reject');
    Route::get('/gallery/pending', [AdminController::class, 'pendingGalleries'])->name('admin.gallery.pending');
    Route::post('/gallery/{gallery}/approve', [AdminController::class, 'approveGallery'])->name('admin.gallery.approve');
    Route::post('/gallery/{gallery}/reject', [AdminController::class, 'rejectGallery'])->name('admin.gallery.reject');
});
Route::middleware(['auth', 'role:it_commercial'])->group(function () {
    Route::get('/Commerciale/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/Commerciale/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/Commerciale/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/Commerciale/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/Commerciale/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/Commerciale/gallery/create', [GalleryController::class, 'create'])->name('gallery.create');
    Route::post('/Commerciale/gallery', [GalleryController::class, 'store'])->name('gallery.store');
    Route::delete('/Commerciale/gallery/remove/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

});
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ProductController::class, 'shop'])->name('shop.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{gallery}', [GalleryController::class, 'show'])->name('gallery.show');