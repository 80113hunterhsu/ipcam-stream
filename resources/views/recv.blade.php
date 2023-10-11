<!DOCTYPE html>
<html>
<head>
    <title>Receiver Page</title>
</head>
<body>
    <h1>Receiver Page</h1>
    <img id="video-stream" src></img>

    <script>
        const videoStream = document.getElementById("video-stream");

        // Function to fetch and display received video frames
        const displayVideo = () => {
            fetch('/stream') // Replace with the actual endpoint for video frames
            .then(response => response.text())
            .then(data => {
                console.log(data);
                // data = JSON.parse(data);
                // return data.blob();
                videoStream.src = data;
                videoStream.onload = async () => {
                    // requestAnimationFrame(displayVideo); // Continue displaying frames
                    // await sleep(1000);
                };
            })
            // .then(blob => {
            //     const url = URL.createObjectURL(blob);
            //     videoStream.src = url;
            //     requestAnimationFrame(displayVideo); // Continue displaying frames
            // })
            // .catch(error => {
            //     console.error('Error fetching video frames:', error);
            // });
        };

        displayVideo(); // Start displaying video frames
    </script>
</body>
</html>
