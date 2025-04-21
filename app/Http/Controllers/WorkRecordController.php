<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkRecordController extends Controller
{
    public function store(Request $request)
    {
        try {
            $currentDate = now();
            return response()->json([
                'status' => 'success',
                'message' => 'Work record stored successfully',
                'date' => $currentDate,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to store work record',
            ], 500);
        }
    }
}
