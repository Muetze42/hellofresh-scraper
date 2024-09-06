<?php

namespace NormanHuth\HellofreshScraper\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use NormanHuth\HellofreshScraper\Models\Concerns\HasPrimaryKeyTrait;

class AbstractModel
{
    use HasAttributes;

    /**
     * The primary key for the model.
     */
    protected string $primaryKey = 'id';

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(array $attributes)
    {
        if (in_array(HasPrimaryKeyTrait::class, class_uses_recursive($this))) {
            $this->casts[$this->primaryKey] = 'string';
        }

        $this->attributes = $attributes;
        collect($this->casts)->each(function (mixed $value, string $key) {
            if (! isset($this->attributes[$key])) {
                return;
            }
            $this->attributes[$key] = $this->castAttribute($key, $this->attributes[$key]);
        });
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * Get an attribute from the model.
     */
    public function getAttribute(string $key): mixed
    {
        return data_get($this->attributes, $key);
    }

    /**
     * Get the number of minutes as integer equivalent form a time string.
     */
    protected function toMinutes(string $attribute): ?int
    {
        $value = $this->getAttribute($attribute);

        if (! is_string($value) || empty($value)) {
            return null;
        }

        return (int) CarbonInterval::make($value)?->totalMinutes;
    }

    protected function bool(string $attribute): bool
    {
        $value = $this->getAttribute($attribute);

        return is_bool($value) ? $value : false;
    }

    /**
     * Return a one-to-one relationship.
     *
     * @todo: phpstan
     */
    protected function hasOne(string $attribute)
    {
        $value = $this->getAttribute($attribute);

        if (! is_array($value) || empty($value)) {
            return null;
        }

        $class = __NAMESPACE__ . '\\' . ucfirst($attribute);

        if (! class_exists($class)) {
            return null;
        }

        return new $class($value);
    }

    /**
     * Return a one-to-many relationship.
     *
     * @todo: phpstan
     */
    protected function hasMany(string $attribute): Collection
    {
        $value = $this->getAttribute($attribute);

        if (! is_array($value) || empty($value)) {
            return collect();
        }

        $class = __NAMESPACE__ . '\\' . Str::singular(ucfirst($attribute));

        return collect(array_map(
            fn ($allergen) => new $class($allergen),
            $value
        ));
    }
}
