<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRating extends Model
{
    use HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
    ];

    public function casts()
    {

        return [
            'rating_datetime' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
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