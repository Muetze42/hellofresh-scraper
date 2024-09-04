<?php

namespace NormanHuth\HellofreshScraper\Traits;

trait HasRelationTrait
{
    /**
     * Define a one-to-one relationship.
     */
    protected function hasOne(mixed $resource, string $key)
    {
        if (!$this->data[$key]) {
            return null;
        }

        return new $resource($this->data[$key]);
    }

    /**
     * Define a one-to-many relationship.
     */
    protected function hasMany(mixed $resource, string $key): array
    {
        return array_map(
            fn (array $item) => new $resource($item),
            $this->data[$key]
        );
    }
}
