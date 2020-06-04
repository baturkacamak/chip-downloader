<?php

namespace Utility;

if (! class_exists('Utility\Chip')) {
    /**
     * Class Chip
     */
    class Chip
    {
        /**
         * The one true instance.
         */
        private static $instance;

        /**
         * Constructor.
         */
        protected function __construct()
        {
            return self::$instance = $this;
        }

        /**
         * Get singleton instance.
         *
         * @since 1.5
         */
        public static function getInstance()
        {
            if (! isset(self::$instance)) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        /**
         * Initializer
         */
        public function init()
        {
            $baseUrl = 'https://www.chip.com.tr/images/pdf/b/';
            for ($year = 1997; $year <= 2018; $year++) {
                for ($month = 1; $month <= 12; $month++) {
                    for ($page = 1; $page <= 300; $page++) {
                        $fileUrl = $baseUrl . "{$year}-{$month}-{$page}.jpg";
                        new \Utility\Downloader($fileUrl);
                    }
                }
            }

        }
    }
}
