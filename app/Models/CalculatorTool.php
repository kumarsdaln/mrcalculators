<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
    'slug',
    'title',
    'subtitle',
    'description',
    'short_description',
    'icon',
    'route',
    'category',
    'tag',
    'badge',
    'is_active',
    'is_featured',
    'is_recommended',
    'is_coming_soon',
    'requires_subscription',
    'display_order',
    'show_on_dashboard',
    'show_on_homepage',
    'content',
])]
class CalculatorTool extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_recommended' => 'boolean',
            'is_coming_soon' => 'boolean',
            'requires_subscription' => 'boolean',
            'display_order' => 'integer',
            'show_on_dashboard' => 'boolean',
            'show_on_homepage' => 'boolean',
            'content' => 'array',
        ];
    }

    /**
     * Scope a query to active tools.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Plans that include this calculator tool.
     */
    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class)->withTimestamps();
    }

    /**
     * Serialize the tool in the same shape the Vue calculators already expect.
     *
     * @return array<string, mixed>
     */
    public function toCatalogArray(): array
    {
        return array_merge($this->content ?? [], [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'icon' => $this->icon,
            'route' => $this->route,
            'category' => $this->category,
            'tag' => $this->tag,
            'badge' => $this->badge,
            'featured' => $this->is_featured,
            'recommended' => $this->is_recommended,
            'coming_soon' => $this->is_coming_soon,
            'access' => [
                'feature_slug' => $this->slug,
                'plan_required' => $this->requires_subscription,
            ],
            'display' => [
                'order' => $this->display_order,
                'show_on_dashboard' => $this->show_on_dashboard,
                'show_on_homepage' => $this->show_on_homepage,
            ],
        ]);
    }
}
