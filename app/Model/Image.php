<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;

    protected $fillable = ['url', 'created_user', 'product_id'];

    /**
     * attach images to product
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product() {
        return $this->belongsTo(Product::class, 'product_id','id');
    }

    /**
     * attach images to user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class, 'created_user', 'id');
    }
}
