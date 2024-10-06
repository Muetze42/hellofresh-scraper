<?php

namespace NormanHuth\HelloFreshScraper\Models;

use NormanHuth\HelloFreshScraper\Models\Concerns\HasNameTrait;
use NormanHuth\HelloFreshScraper\Models\Concerns\HasPrimaryKeyTrait;
use NormanHuth\HelloFreshScraper\Models\Concerns\HasTimestampsTrait;

class Family extends AbstractModel
{
    use HasPrimaryKeyTrait;
    use HasTimestampsTrait;
    use HasNameTrait;

    /**
     * Get all the current attributes on the model.
     *
     * @phpstan-return array<string, mixed>
     *
     * @return array{
     *     id: string,
     *     uuid: string,
     *     name: string,
     *     slug: string,
     *     type: string,
     *     description: string|null,
     *     priority: int,
     *     iconLink: string,
     *     iconPath: string,
     *     usageByCountry: array<string, int>,
     *     createdAt: string,
     *     updatedAt: string,
     * }
     */
    public function getAttributes(): array
    {
        return parent::getAttributes();
    }
}
