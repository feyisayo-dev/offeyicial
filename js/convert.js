document.addEventListener("DOMContentLoaded", function () {
    const imageInput = document.getElementById("imageInput");
    const convertButton = document.getElementById("convertButton");
    const pdfContainer = document.getElementById("pdfContainer");

    convertButton.addEventListener("click", function () {
        const formData = new FormData();
        const files = imageInput.files;

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            formData.append("images[]", file);
            alert("Selected File Name: " + file.name);
        }

        // Make an AJAX request to send formData
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "convert.php", true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                const pdfUrl = xhr.responseText;
                alert(pdfUrl);
                pdfContainer.innerHTML = `<embed src="${pdfUrl}" type="application/pdf" width="100%" height="600px" />`;
            } else {
                // Handle errors here
                pdfContainer.innerHTML = "Error occurred during conversion.";
            }
        };

        xhr.onerror = function () {
            // Handle errors here
            pdfContainer.innerHTML = "Error occurred during conversion.";
        };

        xhr.send(formData);
    });
});
