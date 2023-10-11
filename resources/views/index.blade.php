<!DOCTYPE html>
<html>
<head>
    <title>Camera Preview</title>
    <style>
        video {
            height: 95vh;
            width: auto;
        }
    </style>
</head>
<body>
    <!-- <h1>Camera Preview</h1> -->
    <video id="camera-preview" autoplay></video>

    <script>
        const cameraPreview = document.getElementById("camera-preview");

        // Start the camera when the page is loaded
        async function startCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: true });

                // Display the camera stream in the video element
                cameraPreview.srcObject = stream;

                const mediaRecorder = new MediaRecorder(mediaStream);
                const chunks = [];
                mediaRecorder.ondataavailable = (event) => {
                    if (event.data.size > 0) {
                        chunks.push(event.data);
                    }
                };

                mediaRecorder.onstop = () => {
                    const blob = new Blob(chunks, { type: 'video/webm' });
                    const formData = new FormData();
                    formData.append('video', blob);

                    // Send the recorded video to the server using a POST request
                    fetch('/your-upload-endpoint', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => {
                        console.log('Video sent to server.');
                    })
                    .catch(error => {
                        console.error('Error sending video to server:', error);
                    });
                };

                mediaRecorder.start();
            } catch (error) {
                console.error("Error accessing the camera:", error);
            }
        }

        // Call the function to start the camera when the page loads
        window.addEventListener("load", startCamera);
    </script>
</body>
</html>
