<?php

namespace NormanHuth\HellofreshScraper\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use NormanHuth\HellofreshScraper\Concerns\HasPrimaryKeyTrait;

class AbstractModel
{
    use HasAttributes;

    /**
     * The primary key for the model.
     *
     * @var string
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
     *
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute(string $key): mixed
    {
        return data_get($this->attributes, $key);
    }

    /**
     * Get the number of minutes as integer equivalent form a time string.
     *
     * @param  string  $attribute
     * @return int|null
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
     * @param  string  $attribute
     * @return bool
     */
    protected function bool(string $attribute): bool
    {
        $value = $this->getAttribute($attribute);

        return is_bool($value) ? $value : false;
    }
}
