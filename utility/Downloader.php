<?php

namespace Utility;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

if (! class_exists('Utility\Downloader')) {
    /**
     * Class Downloader
     * @package Utility
     */
    class Downloader
    {
        /**
         * @var
         */
        private $fileUrl;
        /**
         * @var Client
         */
        private $guzzle;

        /**
         * Downloader constructor.
         *
         * @param $fileUrl
         */
        public function __construct($fileUrl)
        {
            $this->fileUrl = $fileUrl;
            $this->guzzle  = new Client(
                [
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36' . ' (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36',
                    ],
                ]
            );

            $this->download();
        }

        private function checkRemoteFile()
        {
            try {
                $this->guzzle->head($this->fileUrl);

                return true;
            } catch (ClientException $client_exception) {
                return false;
            }
        }

        private function download()
        {
            if (! file_exists($localFile = $this->getFileDirectory()) && $this->checkRemoteFile()) {
                try {
                    $this->guzzle->request(
                        'GET',
                        $this->fileUrl,
                        ['sink' => $localFile]
                    );
                } catch (GuzzleException $e) {
                }
            }
        }

        private function getFileDirectory()
        {
            $parsed_url = parse_url($this->fileUrl);
            $file_name  = basename($parsed_url['path']);
            $exploded   = explode('-', $file_name);
            $year       = $exploded[0];
            $month      = $exploded[1];

            $directory = BASE_DIR . '/static/magazins' . "/{$exploded[0]}/$exploded[1]";
            if (! is_dir($directory)) {
                //Create our directory.
                mkdir($directory, 0755, 1);
            }

            return $directory . "/{$exploded[2]}";
        }
    }
}
