<?php
namespace App;


use Illuminate\Database\Eloquent\Model;


class Item extends Model
{
     protected $fillable = ['brand_name','model_name','price','description','image'];

}
?>