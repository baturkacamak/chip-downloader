<?php

namespace Utility;

/**
 * Class Chip
 */
class Chip
{
    /**
     * The Downloader instance.
     *
     * @var Downloader
     */
    private $downloader;

    /**
     * Constructor.
     *
     * @param Downloader $downloader The Downloader instance.
     */
    public function __construct(Downloader $downloader)
    {
        $this->downloader = $downloader;
    }

    /**
     * Initializer
     *
     * @param array $ranges An array of ranges to loop through, with the following keys:
     *                      'year-start' => The start year to loop through
     *                      'year-end' => The end year to loop through
     *                      'month-start' => The start month to loop through
     *                      'month-end' => The end month to loop through
     *                      'page-start' => The start page to loop through
     *                      'page-end' => The end page to loop through
     *
     * @throws \Exception
     */
    public function init(array $ranges)
    {
        // Replace underscores with hyphens in the keys of the provided ranges array
        // This is done so that the keys match the format of the other keys in the array
        // (e.g., 'year-start' instead of 'year_start')
        $ranges = array_combine(
            str_replace('_', '-', array_keys($ranges)),
            array_values($ranges)
        );

        // Merge the default values with the provided range values
        $ranges = $this->mergeRangeValues($ranges);

        // Download the files using the specified ranges
        $this->downloader->download($ranges);
    }

    /**
     * Set the default values for the range elements
     *
     * @return array The default values
     */
    private function getDefaultValues()
    {
        return [
            'year-start' => 1997,
            'year-end' => 2018,
            'month-start' => 1,
            'month-end' => 12,
            'page-start' => 1,
            'page-end' => 300,
        ];
    }

    /**
     * Merge the provided range values with the default values
     *
     * @param array $ranges The provided range values
     *
     * @return array The merged range values
     */
    private function mergeRangeValues(array $ranges)
    {
        // Get the default values
        $defaults = $this->getDefaultValues();

        // Merge the default values with the provided range values
        return array_merge($defaults, $ranges);
    }
}
