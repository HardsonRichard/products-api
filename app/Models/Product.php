<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    public function user_ratings(): HasMany
    {
        return $this->hasMany(UserRating::class);
    }

    public function scopeSort(Builder $query, $sort_by, $sort_order)
    {
        return $query->orderBy($sort_by, $sort_order);
    }

    public function scopeSearch(Builder $query, $search, array $attributes): Builder
    {
        return $query->where(function ($q) use ($search, $attributes) {
            foreach ($attributes as $attribute) {
                $q->orWhere($attribute, 'like', '%' . $search . '%');
            }
        });
    }

    public function scopeFilter(Builder $query, array $filters, array $searchableAttributes = [])
    {
        $query
            ->when(
                $filters['sort_by'] ??= null,
                function ($query) use ($filters) {
                    $query->sort($filters['sort_by'], $filters['sort_order'] ?? 'asc');
                }
            )
            ->when(
                $filters['search'] ?? null,
                function ($query)  use ($filters, $searchableAttributes) {
                    $query->search($filters['search'], $searchableAttributes);
                }
            );
    }
}