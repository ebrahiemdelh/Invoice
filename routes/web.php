<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\InvoiceAttachmentController;
use App\Http\Controllers\InvoiceDetailController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::resource('invoices', InvoicesController::class);
Route::get('/section/{id}', [InvoicesController::class, 'getproducts'])->name('getproducts');
Route::get('status_show/{id}',[InvoicesController::class,'status_show'])->name('status_show');
Route::put('status_update/{id}',[InvoicesController::class,'status_update'])->name('status_update');
Route::get('invoices/{value_status}',[InvoicesController::class,'show']);

Route::resource('invoicesdetails', InvoiceDetailController::class);
Route::get('view_file/{invoice_number}/{file_name}',[InvoiceDetailController::class,'show_file']);
Route::get('download/{invoice_number}/{file_name}',[InvoiceDetailController::class,'get_file']);
Route::delete('delete_file',[InvoiceDetailController::class,'destroy'])->name('delete_file');
Route::get('print_invoice/{id}',[InvoicesController::class,'print']);


Route::resource('invoiceAttachments',InvoiceAttachmentController::class);


Route::resource('archive_invoices',ArchiveController::class);

// Route::resource('sections', SectionController::class);
Route::get('sections', [SectionController::class, 'index'])->name('sections.index');
Route::get('sections/create', [SectionController::class, 'create'])->name('sections.create');
Route::get('sections{id}/edit', [SectionController::class, 'edit'])->name('sections.edit');
Route::post('sections', [SectionController::class, 'store'])->name('sections.store');
Route::put('sections/{id}', [SectionController::class, 'update'])->name('sections.update');
Route::delete('sections/{id}', [SectionController::class, 'destroy'])->name('sections.destroy');


// Route::resource('products', ProductController::class);
Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('products', [ProductController::class, 'store'])->name('products.store');
Route::put('products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

//Deal With Attachments



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('pages/{page}', [AdminController::class, 'index']);
