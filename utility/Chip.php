<?php

namespace Utility;

// Check if the 'Utility\Chip' class already exists
if (! class_exists('Utility\Chip')) {
    /**
     * Class Chip
     */
    class Chip
    {
        /**
         * The one true instance.
         *
         * @var Chip
         */
        private static $instance;

        /**
         * Constructor.
         */
        protected function __construct()
        {
            // Set the instance property to the current instance
            return self::$instance = $this;
        }

        /**
         * Get singleton instance.
         *
         * @return Chip
         *
         * @since 1.5
         */
        public static function getInstance()
        {
            // Check if the instance property is not set
            if (! isset(self::$instance)) {
                // Create a new instance of the class
                self::$instance = new self();
            }

            // Return the instance property
            return self::$instance;
        }

        /**
         * Initializer
         *
         * @throws \Exception
         */
        public function init()
        {
            // Set the base URL for the files we want to download
            $baseUrl = 'https://www.chip.com.tr/images/pdf/b/';

            // Loop through all years from 1997 to 2018
            for ($year = 1997; $year <= 2018;) {
                // Loop through all months from 1 to 12
                for ($month = 1; $month <= 12;) {
                    // Loop through all pages from 1 to 300
                    for ($page = 1; $page <= 300;) {
                        // Create the full URL of the file we want to download
                        $fileUrl = $baseUrl . "{$year}-{$month}-{$page}.jpg";

                        // Try to download the file
                        try {
                            // Create a new instance of the 'Utility\Downloader' class,
                            // passing the URL of the file we want to download
                            new \Utility\Downloader($fileUrl);
                        } catch (\Exception $e) {
                            // If an error occurs, break out of the innermost loop
                            break 1;
                        }
                        // Increment the page number
                        $page++;
                    }
                    // Increment the month number
                    $month++;
                }
                // Increment the year number
                $year++;
            }
        }
    }
}

