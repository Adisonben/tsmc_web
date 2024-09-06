<?php

namespace App\Http\Controllers;

use App\Models\Post_media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function filepondUpload (Request $request) {

        if ($request->hasFile('doc_files')) {
            // Manually validate the file size
            $file = $request->file('doc_files');
            $savedFile = $file[0];
            $file_name_original = $savedFile->getClientOriginalName();
            $fileSizeBytes = $savedFile->getSize();
            $fileSizeKB  = round($fileSizeBytes / 1024, 2); // convert Bytes to KB
            $fileEx = $file[0]->getClientOriginalExtension();

            $file_name = '';
            $file_name = time() . '_' . md5(uniqid(rand(), true)) . '.' . $savedFile->getClientOriginalExtension();
            $folder = 'uploads/postFiles';
            // $file[0]->storeAs($folder , $file_name);
            $folderPath = public_path('uploads/postFiles');
            // Move the file to the storage path
            $savedFile->move($folderPath, $file_name);

            $saved_file = Post_media::create([
                'folder' => $folder,
                'file_name' => $file_name,
                'type'=> "doc",
                'size_kb' => $fileSizeKB,
                'extension' => $fileEx,
                'originalName' => $file_name_original
            ]);

            return $saved_file->id;
        }
        return '';
    }

    public function filepondDelete (Request $request) {
        try {
            $tmp_file = Post_media::findOrFail($request->getContent());
            $filePath = public_path($tmp_file->folder . '/' . $tmp_file->file_name);
            if (file_exists($filePath)) {
                unlink($filePath);
                $tmp_file->delete();
            }

            return response([
                "status" => "delete file success.",
            ], 200);
        } catch (\Throwable $th) {
            return response([
                "status" => $th->getMessage(),
            ], 500);
        }
    }
}
