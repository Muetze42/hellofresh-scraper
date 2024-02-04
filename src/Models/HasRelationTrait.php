<?php

namespace NormanHuth\HellofreshScraper\Models;

trait HasRelationTrait
{
    /**
     * Define a one-to-one relationship.
     */
    protected function hasOne(mixed $model, string $key)
    {
        if (!$this->data[$key]) {
            return null;
        }

        return new $model($this->data[$key]);
    }

    /**
     * Define a one-to-many relationship.
     */
    protected function hasMany(mixed $model, string $key): array
    {
        return array_map(
            fn (array $item) => new $model($item),
            $this->data[$key]
        );
    }
}
