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
            } catch (error) {
                console.error("Error accessing the camera:", error);
            }
        }

        // Call the function to start the camera when the page loads
        window.addEventListener("load", startCamera);
    </script>
</body>
</html>
