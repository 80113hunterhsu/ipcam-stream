<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoFrameController extends Controller
{
    public function index()
    {
        var_dump($this->parseJSON());
        return;
    }
    public function receiveFrame(Request $request)
    {
        // Handle and process the video frame data received from the sender
        // You can save, process, or relay the frames as needed
        $frameData = $request->image;
        // Log the frame data (you can modify this as needed)
        // \Log::info('Received frame: ' . $frameData);
        // array_push($this->data, $frameData);
        $arrData = $this->parseJSON();
        array_push($arrData, $frameData);
        $this->writeJSON($arrData);
        
        // You can also send a response if necessary
        $objResponse = (object)[
            "msg" => "Frame received",
            "data" => $frameData,
            "test" => $request->test
        ];
        return response(json_encode($objResponse), 200);
    }

    public function getFrame()
    {
        // In this example, we'll serve frames from a storage path, but you can customize this logic
        // $path = storage_path('app/public/frames/frame.jpg'); // Adjust the path as needed
        // $fileContents = file_get_contents($path);
        $data = base64_encode($this->parseJSON()[0]);
        $fileContents = $data;

        return response($fileContents, 200)->header('Content-Type', 'image/jpeg');
    }
    private function parseJSON() {
        $file = "data.json";
        $txt = file_get_contents($file);
        if ($txt == '') {
            $txt = '[]';
        }
        return json_decode($txt, true);
    }
    private function writeJSON($payload) {
        $file = fopen("data.json", "w") or die("Unable to open file!");
        $txt = json_encode($payload);
        fwrite($file, $txt);
        fclose($file);
    }
}
