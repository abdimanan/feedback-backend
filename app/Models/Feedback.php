<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'feedbacks';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'created_at';

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'project_id',
        'overall_satisfaction',
        'timeliness_delivery',
        'communication_coordination',
        'quality_final_outputs',
        'professionalism_team',
        'understanding_requirements',
        'nps_score',
        'deliverables_met_expectations',
        'issues_resolved_quickly',
        'comment',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'overall_satisfaction' => 'integer',
            'timeliness_delivery' => 'integer',
            'communication_coordination' => 'integer',
            'quality_final_outputs' => 'integer',
            'professionalism_team' => 'integer',
            'understanding_requirements' => 'integer',
            'nps_score' => 'integer',
            'created_at' => 'datetime',
        ];
    }

    /**
     * Get the project that owns the feedback.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
