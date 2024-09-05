<?php

namespace App\Classes;

use Google\Client;
use Google\Service\Drive;
use Illuminate\Support\Str;

class GoogleDriveService
{
  protected static $driveService;

  protected static function initializeService()
  {
    if (!static::$driveService) {
      $client = new Client();
      $client->setAuthConfig([
        'client_id' => env('GOOGLE_DRIVE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_DRIVE_CLIENT_SECRET'),
      ]);
      $client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));

      static::$driveService = new Drive($client);
    }
  }


  public static function uploadFile($file, $uploadType = 'multipart', $folderId = null)
  {
    try {
      if (!static::$driveService) {
        static::initializeService();
      }

      // Conditionally add 'parents' if the folder is specified or if an environment variable is set
      $fileMetadataArray = [
        'name' => Str::random(10) . '.' . $file->extension(),
      ];

      if ($folderId !== null || !empty(env('GOOGLE_DRIVE_FOLDER_ID'))) {
        $fileMetadataArray['parents'] = [$folderId ?? env('GOOGLE_DRIVE_FOLDER_ID')];
      }

      // Create and upload the file
      $fileMetadata = new Drive\DriveFile($fileMetadataArray);

      $uploadedFile = static::$driveService->files->create($fileMetadata, [
        'data' => file_get_contents($file->getRealPath()),
        'mimeType' => $file->getMimeType(),
        'uploadType' =>  $uploadType,
        'fields' => 'id'
      ]);

      // Return the file ID
      return (object) $uploadedFile;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public static function createFolder($name)
  {
    try {
      if (!static::$driveService) {
        static::initializeService();
      }

      // Create and upload the file
      $fileMetadata = new Drive\DriveFile(array(
        'name' => $name,
        'mimeType' => 'application/vnd.google-apps.folder'
      ));
      $folder = static::$driveService->files->create($fileMetadata, array(
        'fields' => 'id'
      ));

      return $folder;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public static function search($name, $typeSearch = 'files')
  {
    if (!static::$driveService) {
      static::initializeService();
    }

    // Conditionally add query search file or folder or all
    $typeSearch = match ($typeSearch) {
      'files' => "and mimeType != 'application/vnd.google-apps.folder'",
      'folders' => "and mimeType = 'application/vnd.google-apps.folder'",
      'all' => '',
      default => '',
    };


    try {
      $files = [];
      $pageToken = null;

      do {
        $response = static::$driveService->files->listFiles([
          'q' => "name contains '{$name}' $typeSearch",
          'spaces' => 'drive',
          'pageToken' => $pageToken,
          'fields' => 'nextPageToken, files(id, name)',
        ]);

        foreach ($response->files as $file) {
          $files[] = ['id' => $file->id, 'name' => $file->name];
        }

        $pageToken = $response->nextPageToken;
      } while ($pageToken != null);

      return $files;
    } catch (\Exception $e) {
      return ['error' => 'Error Message: ' . $e->getMessage()];
    }
  }

  // public static function getfile($name)
  // {
  //   if (!static::$driveService) {
  //     static::initializeService();
  //   }
  // }
}
