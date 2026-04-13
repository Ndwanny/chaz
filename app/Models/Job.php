<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Job extends Model {
    protected $table = 'jobs';
    protected $fillable = ['title','department','location','type','description','duties','qualifications','deadline','posted_at','status'];
    protected $casts = ['duties' => 'array', 'qualifications' => 'array', 'deadline' => 'date', 'posted_at' => 'date'];
    public function scopeOpen($q) { return $q->where('status','open'); }
}
