<?php
/**
 * Created by PhpStorm.
 * User: baturkacamak
 * Date: 7/12/22
 * Time: 14:47
 */

namespace Utility;

interface DownloaderInterface
{
    /**
     * DownloaderInterface constructor.
     *
     * @param string $fileUrl The URL of the file to download.
     *
     * @throws \Exception If the file cannot be downloaded.
     */
    public function __construct($fileUrl);

    /**
     * Check if the file exists on the remote server.
     *
     * @return bool
     */
    public function checkRemoteFile();

    /**
     * Download the file from the remote server.
     *
     * @throws \Exception If the file cannot be downloaded.
     */
    public function downloadFile();

    /**
     * Get the local file path for the file.
     *
     * @return string
     */
    public function getFileDirectory();
}
