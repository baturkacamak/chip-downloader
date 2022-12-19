<?php

namespace Utility;

// Import the 'GuzzleHttp\Client' and 'GuzzleHttp\Exception\ClientException' and 'GuzzleHttp\Exception\GuzzleException' classes
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

// Check if the 'Utility\FileDownloader' class already exists
if (! class_exists('Utility\FileDownloader')) {
    /**
     * Class FileDownloader
     * @package Utility
     */
    class FileDownloader implements DownloaderInterface
    {
        /**
         * The URL of the file to download.
         *
         * @var string
         */
        private $fileUrl;
        /**
         * The Guzzle HTTP client instance.
         *
         * @var Client
         */
        private $guzzle;

        /**
         * FileDownloader constructor.
         *
         * @param string $fileUrl The URL of the file to download.
         *
         * @throws \Exception If the file cannot be downloaded.
         */
        public function __construct($fileUrl)
        {
            // Set the file URL property to the value of the '$fileUrl' parameter
            $this->fileUrl = $fileUrl;

            // Create a new instance of the 'GuzzleHttp\Client' class,
            // and set the 'User-Agent' header to a specific value
            $this->guzzle = new Client(
                [
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36' . ' (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36',
                    ],
                ]
            );

            // Call the 'download()' method to start the download
            $this->downloadFile();
        }

        /**
         * @param Client $guzzle
         */
        public function setGuzzle($guzzle)
        {
            $this->guzzle = $guzzle;
        }

        /**
         * Check if the file exists on the remote server.
         *
         * @return bool
         */
        public function checkRemoteFile()
        {
            // Try to get the HTTP headers of the file at the specified URL
            try {
                $this->guzzle->head($this->fileUrl);

                // If the file exists, return true
                return true;
            } catch (ClientException $client_exception) {
                // If the file does not exist, return false
                return false;
            }
        }

        /**
         * Download the file from the remote server.
         *
         * @throws \Exception If the file cannot be downloaded.
         */
        public function downloadFile()
        {
            // Check if the file does not exist locally and exists on the remote server
            if (! file_exists($localFile = $this->getFileDirectory()) && $this->checkRemoteFile()) {
                // Try to download the file
                try {
                    // Use the Guzzle client to send a GET request to the file URL,
                    // and save the file to the local file path
                    $this->guzzle->request(
                        'GET',
                        $this->fileUrl,
                        ['sink' => $localFile]
                    );
                } catch (GuzzleException $e) {
                    // If an error occurs while downloading the file,
                    // do nothing (just catch the exception and continue)
                }
            } elseif (! file_exists($localFile) && ! $this->checkRemoteFile()) {
                // If the file does not exist locally and does not exist on the remote server,
                // throw an exception
                throw new \Exception('All files exists');
            }
        }

        /**
         * Get the local file path for the file.
         *
         * @return string
         */
        public function getFileDirectory()
        {
            // Parse the URL of the file to download
            $parsed_url = parse_url($this->fileUrl);

            // Get the file name from the URL
            $file_name = basename($parsed_url['path']);

            // Split the file name into parts using the '-' character
            $exploded = explode('-', $file_name);

            // Build the local file path based on the file name and the directory it is in
            $directory = BASE_DIR . "/static/magazins/{$exploded[0]}/{$exploded[1]}";

            // Create the directory if it does not exist
            if (! is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            // Return the local file path
            return "{$directory}/{$exploded[2]}";
        }
    }
}


