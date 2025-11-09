<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Retailer extends Model
{
    use HasFactory, Notifiable;
    //

    protected $table = 'retailer';
    protected $primaryKey = 'id_retailer';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'retailer_name',
        'retailer_company',
        'retailer_phone',
        'retailer_email',
    ];
}
