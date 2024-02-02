<?php

namespace NormanHuth\HellofreshScraper\Models;

class HelloFreshFamily extends AbstractModel
{
    use HasIdTrait;

    /**
     * @return array{
     *      id: string,
     *      uuid: string,
     *      name: string,
     *      slug: string,
     *      type: string,
     *      priority: int,
     *      iconLink: string|null,
     *      iconPath: string|null,
     * }
     */
    public function data(): array
    {
        return $this->data;
    }
}
