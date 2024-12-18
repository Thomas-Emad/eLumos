<?php

namespace App\Actions;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeGeneratorAction
{

  /**
   * Generate a QR code.
   *
   * This function generates a QR code with the specified size and content.
   *
   * @param int $size The size of the QR code.
   * @param string $content The content to encode in the QR code.
   * @return string The generated QR code.
   */
  public function generate($size, $content)
  {
    $qrCode = QrCode::size($size)->generate($content);
    return $qrCode;
  }
}
