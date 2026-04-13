<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Member extends Model {
    protected $fillable = ['name','type','province','denomination','district','contact','active'];
    protected $casts = ['active' => 'boolean'];
}
