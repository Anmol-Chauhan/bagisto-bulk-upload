<?php

namespace Webkul\Bulkupload\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\Bulkupload\Contracts\ImportProduct as ImportProductContract;

class ImportProduct extends Model implements ImportProductContract
{
    protected $table = "import_products";

    protected $guarded = [];

    /**
     * Get the profiler files.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profiler(): BelongsTo
    {
        return $this->belongsTo(BulkProductImporter::class, 'bulk_product_importer_id', 'id');
    }
}
