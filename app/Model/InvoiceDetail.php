<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    protected $fillable = ['invoice_id', 'product_id', 'quantity', 'status'];

    /**
     * attach product to a detail order
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
