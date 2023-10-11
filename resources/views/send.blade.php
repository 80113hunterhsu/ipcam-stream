<!DOCTYPE html>
<html>
<head>
    <title>Sender Page</title>
</head>
<body>
    <h1>Sender Page</h1>
    <video id="camera-preview" autoplay></video>
    <canvas id="captured-frame" style="display: none;"></canvas>
    <canvas id="preview" width="320" height="240"></canvas>

    <script>
        async function run() {
            const cameraPreview = document.getElementById("camera-preview");
            const capturedFrameCanvas = document.getElementById("captured-frame");
            const previewCanvas = document.getElementById("preview");
            const previewContext = previewCanvas.getContext("2d");

            const mediaStream = await navigator.mediaDevices.getUserMedia({ video: true });
            cameraPreview.srcObject = mediaStream;
    
            // const canvas = document.createElement('canvas');
            // const context = canvas.getContext('2d');
            // const videoWidth = cameraPreview.videoWidth;
            // const videoHeight = cameraPreview.videoHeight;
    
            const sendFrameToServer = () => {
                capturedFrameCanvas.width = cameraPreview.videoWidth;
                capturedFrameCanvas.height = cameraPreview.videoHeight;
                const context = capturedFrameCanvas.getContext("2d");
                context.drawImage(cameraPreview, 0, 0, cameraPreview.videoWidth, cameraPreview.videoHeight);

                // Draw the captured frame onto the preview canvas
                previewContext.drawImage(capturedFrameCanvas, 0, 0, previewCanvas.width, previewCanvas.height);

                // canvas.width = videoWidth;
                // canvas.height = videoHeight;
                // context.drawImage(cameraPreview, 0, 0, videoWidth, videoHeight);
    
                const imageData = capturedFrameCanvas.toDataURL('image/jpeg'); // Convert the frame to base64 JPEG
    
                // Send the image data to the server using a POST request
                // var img = JSON.stringify({ image: imageData });
                var img = btoa(imageData);
                console.log(img);
                var fd = new FormData();
                // fd.append('image', img);
                fd.append('test', 'test');
                // console.log(fd.get('image'));
                fetch('/stream', {
                    method: 'POST',
                    body: fd,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-csrf-token': "{{ csrf_token() }}",
                    },
                })
                .then(response => {
                    console.log(response.status);
                    return response.json();
                    // console.log('Frame sent to server.');
                })
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error('Error sending frame to server:', error);
                });
            };
    
            setInterval(sendFrameToServer, 2000); // Adjust the interval as needed (e.g., every 1 second)
        }
        window.onload = run;
    </script>
</body>
</html>
