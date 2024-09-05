<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yaza\LaravelGoogleDriveStorage\Gdrive;


class FileGoogleDriveController extends Controller
{
  public function store($file)
  {
    $file = Gdrive::put('filename.png', $file);
    return response()->json($file);
  }
}
