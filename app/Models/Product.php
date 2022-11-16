<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['id_product', 'name', 'url_segment', 'priceMin', 'priceMax', 'spek', 'categoryid', 'tofront'];
}
