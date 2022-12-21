<?php
/**
 * Created by PhpStorm.
 * User: baturkacamak
 * Date: 7/12/22
 * Time: 14:47
 */

namespace Utility;

/**
 * Interface DownloaderInterface
 *
 * Defines the methods that must be implemented by a file downloader class.
 */
interface DownloaderInterface
{
    /**
     * DownloaderInterface constructor.
     *
     * @param string $fileUrl The URL of the file to download.
     *
     * @throws \InvalidArgumentException If the file URL is invalid.
     * @throws \GuzzleHttp\Exception\ClientException If the file does not exist on the remote server.
     * @throws \Exception If an unknown error occurs.
     */
    public function __construct($fileUrl);

    /**
     * Check if the file exists on the remote server.
     *
     * @throws \GuzzleHttp\Exception\ClientException If an error occurs while checking for the file on the remote
     *     server.
     * @throws \Exception If an unknown error occurs.
     *
     * @return bool
     */
    public function isFileExistsRemotely();

    /**
     * Download the file from the remote server.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException If an error occurs while downloading the file.
     * @throws \Exception If an unknown error occurs.
     */
    public function downloadFile();

    /**
     * Get the local file path for the file.
     *
     * @return string
     */
    public function getFileDirectory();
}
