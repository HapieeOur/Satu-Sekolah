<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'category',
        'excerpt',
        'content',
        'featured_image',
        'event_date',
        'event_time',
        'event_location',
        'is_published',
        'published_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'event_date' => 'date',
        ];
    }

    /**
     * Boot the model to auto-generate slug.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Post $post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title).'-'.Str::random(5);
            }
        });
    }

    /**
     * Author relationship.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope only published posts that are active.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope by category.
     */
    public function scopeCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for news items.
     */
    public function scopeNews(Builder $query): Builder
    {
        return $query->category('berita');
    }

    /**
     * Scope for public announcements.
     */
    public function scopeAnnouncements(Builder $query): Builder
    {
        return $query->category('pengumuman');
    }

    /**
     * Scope for school events.
     */
    public function scopeEvents(Builder $query): Builder
    {
        return $query->category('acara');
    }

    /**
     * Scope for upcoming school events.
     */
    public function scopeUpcomingEvents(Builder $query): Builder
    {
        return $query->events()
            ->where(function (Builder $q) {
                $q->where('event_date', '>=', now()->toDateString())
                    ->orWhereNull('event_date');
            })
            ->orderBy('event_date', 'asc');
    }
}
