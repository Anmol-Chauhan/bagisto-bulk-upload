<?php

namespace Webkul\Bulkupload\Repositories;

use Webkul\Core\Eloquent\Repository;

class ImportProductRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webkul\Bulkupload\Contracts\ImportProduct';
    }
}
