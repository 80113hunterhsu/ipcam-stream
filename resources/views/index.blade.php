<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camera Preview</title>
    <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
    <style>
        video {
            height: 95vh;
            width: auto;
        }
    </style>
</head>
<body>
    <!-- <h1>Camera Preview</h1> -->
    <video id="camera-preview" autoplay muted playsinline playsInline style="display: none;"></video>
    <select id="camera-select">
        <option value="0" selected disabled>請選擇相機</option>
    </select>

    <script>
        const cameraPreview = document.getElementById("camera-preview");
        var selector = document.getElementById("camera-select");

        async function getCameras() {
            var cameras = await navigator.mediaDevices.enumerateDevices();
            var html = '';
            cameras.forEach(function (camera) {
                if (camera.kind === 'videoinput') {
                    console.log(camera.label);
                    html += "<option value='" + camera.deviceId + "'>" + camera.label + "</option>";
                }
            });
            document.getElementById("camera-select").innerHTML += html;
        }
        
        selector.addEventListener('change', async (event) => {
            const stream = await navigator.mediaDevices.getUserMedia({ 
                video: {
                    width: { min: 1280, ideal: 1920, max: 2560 },
                    height: { min: 720, ideal: 1080, max: 1440 },
                    deviceId: { exact: event.target.value }
                }
            });
            cameraPreview.srcObject = stream;
            cameraPreview.onloadedmetadata = function(e) {
                cameraPreview.play();
            }
            cameraPreview.style.display = 'block';
        });

        // Call the function to start the camera when the page loads
        window.addEventListener("load", getCameras);
    </script>
</body>
</html>