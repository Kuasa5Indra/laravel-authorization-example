<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'user_id', 'amount', 'total_price'];

    protected $hidden = [
        'product_id',
        'user_id',
    ];

    public $with = ['product', 'user'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function user() {
        return $this->belongsTo(User::class)->select(['id', 'name']);
    }
}
