<?php

namespace App\Http\Traits;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;

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
    try {
      $attachment = Cloudinary::upload($file->getRealPath(), [
        "asset_folder" => "$folder/",
        'resource_type' => "$typeResource",
        "chunk_size" => 6000000,
        'allowed_formats' => ['png', 'jpg', 'jpeg', 'pdf', 'word']
      ]);
      $attachmentJson = [
        'public_id' => $attachment->getPublicId(),
        'url' => $attachment->getSecurePath(),
      ];

      return json_encode($attachmentJson);
    } catch (\Exception $e) {
      throw new Exception('failed To Upload In Cloudinary, Because: ' . $e->getMessage());
    }
  }


  /**
   * Destroys a file on Cloudinary based on the provided JSON and type of attachment.
   *
   * @param string $json The JSON string containing the public ID of the attachment to be destroyed.
   * @param string $typeAttachment The type of attachment being destroyed.
   *
   * @throws \Exception If the type of attachment is not supported.
   */
  protected static function destoryAttachment($json, $typeAttachment): void
  {
    $publicId = static::decodeJsonThenGetAttr($json, 'public_id');

    $type = match ($typeAttachment) {
      'image' => 'image',
      'video' => 'video',
      default => throw new \Exception('Sorry, We not support this type')
    };

    if (!is_null($publicId)) {
      Cloudinary::destroy($publicId, ['resource_type' =>  $type]);
    }
  }

  /**
   * Decodes a JSON string and returns the value of the specified attribute.
   *
   * @param string $json The JSON string to decode.
   * @param string $attribute The attribute in the decoded JSON whose value is to be returned.
   *
   * @return mixed The value of the specified attribute if the JSON is valid and the attribute exists, null otherwise.
   */
  private static function decodeJsonThenGetAttr($json, $attribute): null | string
  {
    $filed = json_decode($json);
    return is_null($filed) ? null : $filed->$attribute;
  }
}
