<?php

namespace Utility;

/**
 * Class Downloader
 */
class Downloader
{
    /**
     * The base URL for the files we want to download
     *
     * @var string
     */
    private $baseUrl = 'https://www.chip.com.tr/images/pdf/b/';

    /**
     * Download a file
     *
     * @param array $ranges An array of ranges to loop through, with the following keys:
     *                      'year_start' => The start year to loop through
     *                      'year_end' => The end year to loop through
     *                      'month_start' => The start month to loop through
     *                      'month_end' => The end month to loop through
     *                      'page_start' => The start page to loop through
     *                      'page_end' => The end page to loop through
     *
     * @throws \Exception
     */
    public function download(array $ranges)
    {
        // Extract the range values from the array
        extract($ranges);

        // Loop through all years from the start year to the end year
        for ($year = $year_start; $year <= $year_end; $year++) {
            // Loop through all months from the start month to the end month
            for ($month = $month_start; $month <= $month_end; $month++) {
                // Loop through all pages from the start page to the end page
                for ($page = $page_start; $page <= $page_end; $page++) {
                    // Create the full URL of the file we want to download
                    $fileUrl = $this->baseUrl . "{$year}-{$month}-{$page}.jpg";

                    // Try to download the file
                    try {
                        file_get_contents($fileUrl);
                    } catch (\Exception $e) {
                        error_log($e->getMessage());
                    }
                }
            }
        }
    }
}


