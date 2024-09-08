<?php

namespace NormanHuth\HelloFreshScraper\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use NormanHuth\HelloFreshScraper\Exceptions\MissingAttributeException;
use NormanHuth\HelloFreshScraper\Models\Concerns\HasPrimaryKeyTrait;

class AbstractModel
{
    use HasAttributes;

    /**
     * The primary key for the model.
     */
    protected string $primaryKey = 'id';

    /**
     * Indicates that an error should be thrown if you want to access a non-existent attribute.
     */
    protected bool $throwMissingAttributeException = true;

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
     * Determine that an error should be thrown if you want to access a non-existent attribute.
     *
     * @param  bool  $state
     * @return $this
     */
    public function throwMissingAttributeException(bool $state): static
    {
        $this->throwMissingAttributeException = $state;

        return $this;
    }

    /**
     * Get an attribute from the model.
     */
    public function getAttribute(string $key): mixed
    {
        if ($this->throwMissingAttributeException && ! array_key_exists($key, $this->attributes)) {
            throw new MissingAttributeException($this, $key);
        }

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

    /**
     * Get attribute cast as boolean.
     *
     * @param  string  $attribute
     * @return bool
     */
    protected function toBool(string $attribute): bool
    {
        $value = $this->getAttribute($attribute);

        return is_bool($value) ? $value : false;
    }

    /**
     * Get a parsed datetime attribute.
     *
     * @param  string  $attribute
     * @return \Illuminate\Support\Carbon|null
     */
    protected function toDatetime(string $attribute): ?Carbon
    {
        $value = $this->getAttribute($attribute);

        if (! is_string($value) || empty($value)) {
            return null;
        }

        try {
            $instance = Carbon::parse($value);

            return $instance->year > 2000 ? $instance : null;
        } catch (\Exception | \Throwable) {
            return null;
        }
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

    /**
     * Get the value indicating whether the IDs are incrementing.
     */
    public function getIncrementing(): bool
    {
        return false;
    }
}
