// add_book.js

// Show the modal with a message
function showModal(message) {
    document.getElementById("modalMessage").textContent = message;
    document.getElementById("resultModal").style.display = "block";
}

// Close the modal
function closeModal() {
    document.getElementById("resultModal").style.display = "none";
}

// Wait for the page to load, then show the modal if there are messages
window.onload = function() {
    var successMessage = document.getElementById("phpMessages").getAttribute("data-success-message");
    var errorMessage = document.getElementById("phpMessages").getAttribute("data-error-message");

    if (successMessage) {
        showModal(successMessage);
    } else if (errorMessage) {
        showModal(errorMessage);
    }
};
