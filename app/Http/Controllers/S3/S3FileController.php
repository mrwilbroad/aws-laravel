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

       try {
        $data = $request->file("profile");
        $ex = $data->guessClientExtension();
        $filename = Str::uuid() . "." . $ex;
        $filename = $data->getClientOriginalName();
        $user_id = $request->user()->id;
        Storage::disk("s3")->putFileAs("documents",$data,$filename);
        Files::create([
            "user_id" => $user_id,
            "filename" => $filename
        ]);

       } catch (\Throwable $th) {
           dd($th);
       }

        return back()
                      ->with("success","File uploaded successfull");
    }
}
