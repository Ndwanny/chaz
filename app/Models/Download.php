<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Download extends Model {
    protected $fillable = ['title','category','type','year','issue','file_path','file_size','pages','description','published_at'];
    protected $casts = ['published_at' => 'date'];
}
