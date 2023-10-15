<?php

namespace App\Http\Controllers\S3;

use App\Http\Controllers\Controller;
use App\Http\Requests\S3\S3ProfileSendRequest;
use App\Models\FilesystemS3\Files;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class S3FileController extends Controller
{


    public function __construct()
    {
        $this->middleware([
            HandlePrecognitiveRequests::class
        ]);

    }

    public function SendProfileType(S3ProfileSendRequest $request)
    {

        $data = $request->file("profile");
        $ex = $data->guessClientExtension();
        $filename = "Profile/" . Str::uuid() . "." . $ex;;
        $user_id = $request->user()->id;
        $data->storeAs($filename, "", [
            "disk" => "s3"
        ]);
        Files::create([
            "user_id" => $user_id,
            "filename" => $filename
        ]);

        return back()
                      ->with("success","File uploaded successfull");
    }
}
