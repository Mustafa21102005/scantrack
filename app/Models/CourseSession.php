<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $qr_token
 * @property string $expires_at
 * @property int $is_active
 * @property int $course_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $attendances
 * @property-read int|null $attendances_count
 * @property-read \App\Models\Course $course
 * @method static \Database\Factories\CourseSessionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSession query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSession whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSession whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSession whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSession whereQrToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSession whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CourseSession extends Model
{
    /** @use HasFactory<\Database\Factories\CourseSessionFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'qr_token',
        'expires_at',
        'is_active',
        'course_id',
    ];

    /**
     * Get the course that this session belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the attendances for the course session.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
