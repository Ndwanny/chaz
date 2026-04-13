<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerformanceReview extends Model
{
    protected $fillable = ['employee_id', 'reviewer_id', 'review_period', 'period_start', 'period_end', 'kpi_score', 'overall_rating', 'strengths', 'areas_for_improvement', 'goals_next_period', 'employee_comments', 'reviewer_comments', 'status', 'signed_off_at'];
    protected $casts    = ['period_start' => 'date', 'period_end' => 'date', 'signed_off_at' => 'datetime', 'kpi_score' => 'decimal:2'];

    public function employee(): BelongsTo { return $this->belongsTo(Employee::class); }
    public function reviewer(): BelongsTo  { return $this->belongsTo(Admin::class, 'reviewer_id'); }

    public function getRatingColorAttribute(): string
    {
        return match($this->overall_rating) {
            'excellent'          => 'green',
            'good'               => 'blue',
            'satisfactory'       => 'gold',
            'needs_improvement'  => 'red',
            'unsatisfactory'     => 'red',
            default              => 'grey',
        };
    }
}
