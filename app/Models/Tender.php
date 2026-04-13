<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Tender extends Model {
    protected $fillable = ['reference','title','category','description','issued_at','deadline','status','document'];
    protected $casts = ['issued_at' => 'date', 'deadline' => 'date'];
    public function scopeOpen($q) { return $q->where('status','open'); }
}
