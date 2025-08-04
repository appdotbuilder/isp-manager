<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ServicePackage
 *
 * @property int $id
 * @property string $name
 * @property string $speed
 * @property float $price
 * @property string|null $description
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer[] $customers
 * @property-read int|null $customers_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePackage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePackage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePackage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePackage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePackage whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePackage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePackage wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePackage whereSpeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePackage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePackage active()
 * @method static \Database\Factories\ServicePackageFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class ServicePackage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'speed',
        'price',
        'description',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all customers using this service package.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Scope a query to only include active packages.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}