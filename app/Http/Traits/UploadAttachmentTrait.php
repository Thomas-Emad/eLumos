<?php

namespace App\Http\Traits;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


trait UploadAttachmentTrait
{
  /**
   * Uploads a video to Cloudinary and returns the public ID and secure URL of the uploaded video.
   *
   * @param Request $request The HTTP request object containing the video file to be uploaded.
   * @return string The JSON-encoded video information including the public ID and secure URL.
   */
  protected static function uploadVideo($file, string $folder, string $typeResource): string
  {
    $attachment = Cloudinary::uploadVideo($file->getRealPath(), [
      "asset_folder" => "$folder/",
      'resource_type' => "$typeResource",
      "chunk_size" => 6000000,
    ]);
    $attachmentJson = [
      'public_id' => $attachment->getPublicId(),
      'url' => $attachment->getSecurePath(),
      'duration' => $attachment->getResponse()['duration'],
    ];

    return json_encode($attachmentJson);
  }
  /**
   * Uploads a file to Cloudinary and returns the public ID and secure URL of the uploaded file.
   *
   * @param object $file The file object to be uploaded.
   * @param string $folder The folder where the file will be uploaded.
   * @param string $typeResource The type of resource being uploaded.
   *
   * @return string The JSON-encoded file information including the public ID and secure URL.
   */
  protected static function uploadAttachment($file, string $folder, string $typeResource): string
  {
    $attachment = Cloudinary::upload($file->getRealPath(), [
      "asset_folder" => "$folder/",
      'resource_type' => "$typeResource",
      "chunk_size" => 6000000,
      'allowed_formats' => ['png', 'jpg', 'jpeg', 'pdf']
    ]);
    $attachmentJson = [
      'public_id' => $attachment->getPublicId(),
      'url' => $attachment->getSecurePath(),
    ];

    return json_encode($attachmentJson);
  }
}
