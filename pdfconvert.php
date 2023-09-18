<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="convert.css">
    <link rel="stylesheet" href="css/all.min.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font/bootstrap-icons.css">
    <link rel="icon" href="img/offeyicial.png" type="image/jpeg" sizes="32x32" />
    <link href="css/aos.css" rel="stylesheet">
    <link href="css/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="css/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="css/remixicon/remixicon.css" rel="stylesheet">
    <link href="css/swiper/swiper-bundle.min.css" rel="stylesheet">
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <title>Image to PDF Converter</title>
</head>

<body>
    <header>
        <img src="img/offeyicial.png" width="40px" height="40px">
        <p>Image to PDF Converter</p>
    </header>
    <main>
        <section class="upload-section">
            <h2>Upload Images</h2>
            <div id="imageUploadForm">
                <input type="file" id="imageInput" multiple accept="image/*">
                <label id="Upload" for="imageInput">Pick images</label>

                <button type="button" id="convertButton">Convert to PDF</button>
            </div>
        </section>
        <section class="pdf-settings">
            <h2>PDF Settings:</h2>
            <div class="compress">
                <input type="checkbox" id="pdfSizeLimit" name="pdfSizeLimit">
                <label for="pdfSizeLimit">Compress</label>
            </div>
            <div class="name">
                <label for="name_of_file">Name of file:</label>
                <input class="form-control" id="name_of_file" placeholder="Name of file">
            </div>
        </section>
        <section class="pdf-preview">
            <h2>PDF Preview</h2>
            <div id="pdfContainer">
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 OFFEYICIAL</p>
    </footer>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const imageInput = document.getElementById("imageInput");
            const convertButton = document.getElementById("convertButton");
            const pdfContainer = document.getElementById("pdfContainer");

            convertButton.addEventListener("click", function() {
                const name = document.getElementById("name_of_file").value;
                console.log(name);
                const pdfSizeLimit = document.getElementById('pdfSizeLimit').checked;
                if (name != "") {
                    const formData = new FormData();
                    const files = imageInput.files;
                    formData.append("pdfSizeLimit", pdfSizeLimit);
                    formData.append("name", name);
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        formData.append("images[]", file);
                    }

                    const xhr = new XMLHttpRequest();
                    xhr.open("POST", "convert.php", true);
                    const loader = document.createElement('img');
                    loader.src = 'icons/internet.gif';
                    loader.classList.add('loader');
                    pdfContainer.appendChild(loader);
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            const pdfUrl = xhr.responseText;
                            console.log(pdfUrl);
                            loader.style.display = 'none';
                            expected = 'pdf';
                            const inputFormat = pdfUrl.split(".").pop().toLowerCase();
                            console.log(inputFormat);
                            if (inputFormat != "") {
                                pdfContainer.innerHTML = `<embed src="books/${pdfUrl}" type="application/pdf" width="100%" height="600px" />`;
                            } else {
                                pdfContainer.innerHTML = '<div class="error form-control"><img src="icons/close.png"><p>No images recieved at the backend</p></div>';
                            }
                        } else {
                            pdfContainer.innerHTML = "Error occurred during conversion.";
                        }
                    };
                    xhr.onerror = function() {
                        pdfContainer.innerHTML = "Error occurred during conversion.";
                    };
                    xhr.send(formData);
                } else {
                    alert("PLEASE FILL NAME")
                }
            });
        });
    </script>
</body>

</html>