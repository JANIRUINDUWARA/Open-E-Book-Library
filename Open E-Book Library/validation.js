// validation.js

function validateForm() {
    // Get the form values
    var title = document.getElementById("title").value;
    var author = document.getElementById("author").value;
    var genre = document.getElementById("genre").value;
    var year = document.getElementById("year").value;

    // Reset error messages
    document.getElementById("titleError").textContent = "";
    document.getElementById("authorError").textContent = "";
    document.getElementById("genreError").textContent = "";
    document.getElementById("yearError").textContent = "";

    // Title validation
    if (title.trim() === "") {
        document.getElementById("titleError").textContent = "Title is required.";
        return false;
    }

    // Author validation
    var authorRegex = /^[A-Za-z\s]+$/;
    if (author.trim() === "") {
        document.getElementById("authorError").textContent = "Author is required.";
        return false;
    } else if (!authorRegex.test(author)) {
        document.getElementById("authorError").textContent = "Author name should contain only letters.";
        return false;
    }

    // Genre validation: Ensure a valid genre is selected from the dropdown
    if (genre === "") {
        document.getElementById("genreError").textContent = "Please select a genre.";
        return false;
    }

    // Year validation
    var yearRegex = /^\d{4}$/;
    if (year.trim() === "") {
        document.getElementById("yearError").textContent = "Year is required.";
        return false;
    } else if (!yearRegex.test(year)) {
        document.getElementById("yearError").textContent = "Please enter a valid 4-digit year.";
        return false;
    } else if (year < 1000 || year > new Date().getFullYear()) {
        document.getElementById("yearError").textContent = "Please enter a valid year (greater than 1000 and not in the future).";
        return false;
    }

    return true;
}
