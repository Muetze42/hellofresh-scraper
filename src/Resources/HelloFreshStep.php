<?php

namespace NormanHuth\HellofreshScraper\Resources;

class HelloFreshStep extends AbstractResource
{
    /**
     * The data array.
     *
     * @var array{
     *     index: int,
     *     instructions: string,
     *     instructionsHTML: string,
     *     instructionsMarkdown: string,
     *     ingredients: array<int, string>,
     *     utensils: array<int, string>,
     *     timers: array<int, string>,
     *     images: array{array-key, array{
     *         link: string,
     *         path: string,
     *         caption: string,
     *     }},
     *     videos: array{array-key, array{
     *         link: string,
     *         path: string,
     *         caption: string,
     *     }},
     * }
     */
    protected array $data;

    /**
     * Get the data array.
     *
     * @return array{
     *      index: int,
     *      instructions: string,
     *      instructionsHTML: string,
     *      instructionsMarkdown: string,
     *      ingredients: array<int, string>,
     *      utensils: array<int, string>,
     *      timers: array<int, string>,
     *      images: array{array-key, array{
     *          link: string,
     *          path: string,
     *          caption: string,
     *      }},
     *      videos: array{array-key, array{
     *          link: string,
     *          path: string,
     *          caption: string,
     *      }},
     *  }
     */
    public function data(): array
    {
        return $this->data;
    }

    // timers
    // videos
}
