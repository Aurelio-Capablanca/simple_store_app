<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use HasFactory, Notifiable;
    //

    protected $table = 'product';
    protected $primaryKey = 'id_product';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'product_name',
        'product_description',
        'product_price',
        'has_discount',
        'has_stock',
        'is_available',        
        'expiring_date',
        'id_category',
    ];
}
