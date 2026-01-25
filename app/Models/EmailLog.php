<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'project_id',
        'client_id',
        'feedback_link_id',
        'to_email',
        'subject',
        'sent_at',
        'opened_at',
        'resent_count',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
            'opened_at' => 'datetime',
            'resent_count' => 'integer',
        ];
    }

    /**
     * Get the project that owns the email log.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the client that owns the email log.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the feedback link that owns the email log.
     */
    public function feedbackLink(): BelongsTo
    {
        return $this->belongsTo(FeedbackLink::class);
    }

    /**
     * Get EmailLogs eligible for automatic resend: feedback_link.used_at null,
     * resent_count < 3, sent_at older than 3 days.
     *
     * @return \Illuminate\Support\Collection<int, EmailLog>
     */
    public static function eligibleForResend(): \Illuminate\Support\Collection
    {
        return self::query()
            ->whereHas('feedbackLink', fn ($q) => $q->whereNull('used_at'))
            ->where('resent_count', '<', 3)
            ->where('sent_at', '<', now()->subDays(3))
            ->get();
    }
}
