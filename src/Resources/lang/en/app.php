<?php

return [
    'admin' => [
        'system'      => [
            'bulkupload' => 'Bulk-Upload Product',
            'settings'   => 'Settings',
            'general'    => 'General',
            'status'     => 'Status',
        ],

        'bulk-upload' => [
            'index'              => 'Bulk-Upload',
            'manage-bulk-upload' => 'Manage Bulk Upload',

            'bulk-product-importer' => [
                'grid'           => 'Profile Grid',
                'name'           => 'Name',
                'family'         => 'Attribute Family',
                'locale'         => 'Default Locale',
                'index'          => 'Bulk Product Importer',
                'add-profile'    => 'Add Profile',
                'edit-profile'   => 'Edit Profile',
                'update-profile' => 'Update',

                'data-grid' => [
                    'created-at'  => 'Created At',
                    'locale_code' => 'Locale code',
                ],
            ],

            'run-profile' => [
                'run'                => 'Import Products',
                'index'              => 'Run Profile',
                'error'              => 'Products which are not uploaded',
                'finish'             => 'Finished Profile Execution',
                'warning'            => 'Warning: Please do not close the window during importing data',
                'run-command'        => 'Import Products In BackGround',
                'error-count'        => 'Number of errors while product uploading',
                'select-file'        => 'Select File',
                'please-select'      => 'Please Select',
                'error-in-product'   => 'Error while product uploading',
                'uploaded-product'   => 'Products which are uploaded',
                'profile-execution'  => 'Starting profile execution, please wait...',
                'products-uploaded'  => 'Products Uploaded',
                'delete-csv-btn'     => 'Delete CSV',
                'errors'             => 'Errors',
                'error-files'        => 'Error Files',
                'file-not-found'     => 'Selected File not found.',
                'csv-data-not-found' => 'No CSV Data to Import',
                'success'            => 'CSV Product Successfully Imported',
            ],

            'upload-file' => [
                'delete'        => 'Delete File',
                'download-file' => 'Download CSV',
            ],

            'upload-files' => [
                'file'                     => 'CSV/XLS/XLSX file',
                'save'                     => 'Save',
                'index'                    => 'Upload Files',
                'image'                    => 'Image Zip file',
                'download'                 => 'Download',
                'csv-file'                 => 'Sample :filetype CSV File',
                'xls-file'                 => 'Sample :filetype XLS File',
                'sample-links'             => 'Is Links have samples',
                'download-sample'          => 'Download Sample',
                'sample-file'              => 'Sample Files',
                'import-products'          => 'Import Products',
                'is-downloadable'          => 'Is downloadable have files',
                'sample-available'         => 'Is Samples available',
                'upload-link-files'        => 'Upload Link Files',
                'upload-sample-files'      => 'Upload Sample Files',
                'upload-link-sample-files' => 'Upload Link Sample Files',
                'upload-product-time'      => 'Time Taken',
                'uploaded-product'         => 'Uploaded Product',
                'not-uploaded-product'     => 'Not Uploaded Product',
                'profiler-name'            => 'Profiler Name',
                'csv-link'                 => 'CSV Link',
                'date-and-time'            => 'Date & Time',
                'delete-file'              => 'Delete File',
            ],

            'messages' => [
                'profile-saved'             => 'Profile added successfully',
                'update-profile'            => 'Profile updated successfully',
                'product-not-supported'     => 'Booking product not supported this module',
                'profile-deleted'           => 'Profile deleted successfully',
                'file-format-error'         => 'Invalid File Extension',
                'all-profile-deleted'       => 'All the selected profiles have been deleted successfully',
                'data-profile-not-selected' => 'Bulk Product Importer not selected',
            ],
        ],
    ],
];
