<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubRecipientAdvert extends Model
{
    protected $table = 'sub_recipient_adverts';
    
    protected $fillable = [
        'reference', 'title', 'grant', 'funder', 'type', 
        'description', 'eligibility_criteria', 'successful_applicants', 
        'issued', 'status', 'document'
    ];

    protected $casts = [
        'eligibility_criteria' => 'array',
        'successful_applicants' => 'array',
    ];

    public function scopeOpen($q)
    {
        return $q->where('status', 'open');
    }
}
