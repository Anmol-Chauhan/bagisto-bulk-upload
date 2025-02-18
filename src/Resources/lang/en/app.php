<?php

return [
    'admin' => [
        'system'    => [
            'bulkupload'    => 'Bulk-Upload Product',
            'settings'      => 'Settings',
            'general'       => 'General',
            'status'        => 'Status',
        ],

        'bulk-upload' => [
            'index' => 'Bulkupload',
            'manage-bulk-upload' => 'Manage Bulk Upload',

            'data-flow-profile' => [
                'index' => 'Data Flow Profile',
                'add-profile' => 'Add Profile',
                'grid' => 'Profile Grid',
                'name' => 'Name',
                'edit-profile' => 'Edit Profile',
                'update-profile' => 'Update',

                'data-grid' => [
                    'created-at' => 'Created At',
                    'locale_code' => 'Locale code'
                ]
            ],

            'run-profile' => [
                'index' => 'Run Profile',
                'select-file' => 'Select File',
                'please-select' => 'Please Select',
                'run' => 'Run',
                'profile-execution' => 'Starting profile execution, please wait...',
                'error-count' => 'Number of errors while product uploading',
                'error-in-product' => 'Error while product uploading',
                'warning' => 'Warning: Please do not close the window during importing data',
                'products-uploaded' => 'Products Uploaded',
                'finish' => 'Finished Profile Execution',
            ],

            'upload-files' => [
                'index' => 'Upload Files',
                'download-sample' => 'Download Samples',
                'download' => 'Download',
                'csv-file' => 'Sample :filetype CSV File',
                'xls-file' => 'Sample :filetype XLS File',
                'import-products' => 'Import Products',
                'is-downloadable' => 'Is downloadable have files',
                'sample-links' => 'Is Links have samples',
                'sample-available' => 'Is Samples available',
                'upload-link-files' => 'Upload Link Files',
                'upload-link-sample-files' => 'Upload Link Sample Files',
                'upload-sample-files' => 'Upload Sample Files',
                'file' => 'CSV/XLS/XLSX file',
                'image' => 'Image Zip file',
                'save' => 'Save'
            ],

            'messages' => [
                'profile-saved' => 'Profile added successfully',
                'profile-deleted' => 'Profile deleted successfully',
                'all-profile-deleted' => 'All the selected profiles have been deleted successfully',
                'file-format-error' => 'Invalid File Extension',
                'update-profile' => 'Profile updated successfully',
                'data-profile-not-selected' => 'Data Flow Profile not selected',
            ]
        ],
    ],
];
