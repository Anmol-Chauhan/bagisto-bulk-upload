<?php

use Illuminate\Support\Facades\Route;
use Webkul\Bulkupload\Http\Controllers\Admin\BulkProductImporterController;
use Webkul\Bulkupload\Http\Controllers\Admin\UploadFileController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => config('app.admin_url')], function () {
        Route::prefix('bulkupload')->group(function () {
            /**
             * Bulk Product Importer routes.
             */
            Route::controller(BulkProductImporterController::class)->prefix('bulk-product-importer')->group(function () {
                Route::get('', 'index')->name('admin.bulk-upload.bulk-product-importer.index');

                Route::post('addprofile', 'store')->name('admin.bulk-upload.bulk-product-importer.add');

                Route::get('edit/{id}', 'edit')->name('admin.bulk-upload.bulk-product-importer.edit');

                Route::put('update', 'update')->name('admin.bulk-upload.bulk-product-importer.update');

                Route::post('delete/{id}', 'destroy')->name('admin.bulk-upload.bulk-product-importer.delete');

                Route::post('massdestroy', 'massDestroy')->name('admin.bulk-upload.bulk-product-importer.massDelete');

                Route::post('get-attribute', 'getAttributeFamilyByImporterId')->name('admin.bulk-upload.bulk-product-importer.get-attribute-family');
            });

            /**
             * CSV File upload routes.
             */
            Route::controller(UploadFileController::class)->prefix('upload-file')->group(function () {
                // Route to display the index page for uploading files
                Route::get('', 'index')->name('admin.bulk-upload.upload-file.index');

                // Route to handle downloading sample files
                Route::post('download-sample-file', 'downloadSampleFile')->name('admin.bulk-upload.upload-file.download-sample-files');

                // Route to fetch bulk product importer profiles
                Route::get('get-profiles', 'getBulkProductImporter')->name('admin.bulk-upload.upload-file.get-all-profile');

                // Route to import products from uploaded files
                Route::post('import-products-file', 'storeProductsFile')->name('admin.bulk-upload.upload-file.import-products-file');
            });

            /**
             * Impport CSV File routes.
             */
            Route::controller(UploadFileController::class)->prefix('import-product-file')->group(function () {
                // Get attribut family when uploading bulk-product
                Route::get('', 'getFamilyAttributesToUploadFile')->name('admin.bulk-upload.import-file.run-profile.index');

                // Get product importer records while product is uploading
                Route::get('get-importer', 'getProductImporter')->name('admin.bulk-upload.upload-file.get-importar');

                // Delete importer file while uploading bulk-produuct
                Route::post('delete-file', 'deleteProductFile')->name('admin.bulk-upload.upload-file.delete');

                // Read csv file and exicute the uploading product
                Route::post('read-csv', 'readCSVData')->name('admin.bulk-upload.upload-file.run-profile.read-csv');

                // get error after product uploading
                Route::get('download-csv', 'downloadCsv')->name('admin.bulk-upload.upload-file.run-profile.download-csv');

                // Delete the csv error file
                Route::post('delete-csv', 'deleteCSV')->name('admin.bulk-upload.upload-file.run-profile.delete-csv-file');

                // Get uploaded and not uploaded product records
                Route::post('get-uploaded-product', 'getUploadedProductOrNotUploadedProduct')->name('admin.bulk-upload.upload-file.get-uploaded-and-not-uploaded-product');

                // Get profile detail
                Route::get('get-profiler', 'getProfiler')->name('admin.bulk-upload.upload-file.run-profile.get-profiler-name');

                // Read error CSV file while bulk-product uploads
                Route::get('read-error-file', 'readErrorFile')->name('admin.bulk-upload.upload-file.run-profile.read-error-file');

                // Destroy session
                Route::post('remove-details', 'forgetProductUploadedSessionDetails')->name('admin.bulk-upload.upload-file.run-profile.remove-details');
            });
        });
    });

