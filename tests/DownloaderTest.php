<?php
/**
 * Created by PhpStorm.
 * User: baturkacamak
 * Date: 7/12/22
 * Time: 16:09
 */

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Utility\Downloader;

class DownloaderTest extends TestCase
{
    // Test the getFileDirectory() method
    public function testGetFileDirectory()
    {
        // Set the base directory
        define('BASE_DIR', '/var/www/html');

        // Create a new Downloader object
        $downloader = new Downloader('https://example.com/files/my-file-2020-12.pdf');

        // Test the getFileDirectory() method
        $this->assertEquals('/var/www/html/static/magazins/2020/12/my-file-2020-12.pdf', $downloader->getFileDirectory());
    }

    // Test the checkRemoteFile() method when the file exists on the remote server
    public function testCheckRemoteFileExists()
    {
        // Set the base directory
        define('BASE_DIR', '/var/www/html');

        // Create a new Downloader object
        $downloader = new Downloader('https://example.com/files/my-file-2020-12.pdf');

        // Mock the Guzzle HTTP client
        $client = $this->createMock(Client::class);
        $client->method('head')->willReturn(new Response(200));
        // Set the mocked client on the Downloader object
        $downloader->setGuzzle($client);

        // Test the checkRemoteFile() method
        $this->assertTrue($downloader->checkRemoteFile());
    }

    // Test the checkRemoteFile() method when the file does not exist on the remote server
    public function testCheckRemoteFileNotExists()
    {
        // Set the base directory
        define('BASE_DIR', '/var/www/html');

        // Create a new Downloader object
        $downloader = new Downloader('https://example.com/files/my-file-2020-12.pdf');

        // Mock the Guzzle HTTP client
        $client = $this->createMock(Client::class);
        $client->method('head')
               ->willThrowException(new ClientException('File not found', new Request('HEAD', 'https://example.com/files/my-file-2020-12.pdf'), new Response(404)));

        // Set the mocked client on the Downloader object
        $downloader->setGuzzle($client);

        // Test the checkRemoteFile() method
        $this->assertFalse($downloader->checkRemoteFile());
    }

    // Test the downloadFile() method when the file exists on the remote server
    public function testDownloadFile()
    {
        // Set the base directory
        define('BASE_DIR', '/var/www/html');

        // Create a new Downloader object
        $downloader = new Downloader('https://example.com/files/my-file-2020-12.pdf');

        // Mock the Guzzle HTTP client
        $client = $this->createMock(Client::class);
        $client->method('head')->willReturn(new Response(200));
        $client->method('request')->willReturn(new Response(200));

        // Set the mocked client on the Downloader object
        $downloader->setGuzzle($client);

        // Test the downloadFile() method
        $downloader->downloadFile();
        $this->assertFileExists('/var/www/html/static/magazins/2020/12/my-file-2020-12.pdf');
    }

    // Test the downloadFile() method when the file does not exist on the remote server
    public function testDownloadFileNotExists()
    {
        // Set the base directory
        define('BASE_DIR', '/var/www/html');

        // Create a new Downloader object
        $downloader = new Downloader('https://example.com/files/my-file-2020-12.pdf');

        // Mock the Guzzle HTTP client
        $client = $this->createMock(Client::class);
        $client->method('head')
               ->willThrowException(new ClientException('File not found', new Request('HEAD', 'https://example.com/files/my-file-2020-12.pdf'), new Response(404)));

        // Set the mocked client on the Downloader object
        $downloader->setGuzzle($client);
        // Test the downloadFile() method
        $downloader->downloadFile();
        $this->assertFileNotExists('/var/www/html/static/magazins/2020/12/my-file-2020-12.pdf');
    }

    // Test the downloadFile() method when there is an error while downloading the file
    public function testDownloadFileError()
    {
        // Set the base directory
        define('BASE_DIR', '/var/www/html');

        // Create a new Downloader object
        $downloader = new Downloader('https://example.com/files/my-file-2020-12.pdf');

        // Mock the Guzzle HTTP client
        $client = $this->createMock(Client::class);
        $client->method('head')->willReturn(new Response(200));
        $client->method('request')
               ->willThrowException(new GuzzleException('Error while downloading file'));

        // Set the mocked client on the Downloader object
        $downloader->setGuzzle($client);

        // Test the downloadFile() method
        $downloader->downloadFile();
        $this->assertFileNotExists('/var/www/html/static/magazins/2020/12/my-file-2020-12.pdf');
    }
}


