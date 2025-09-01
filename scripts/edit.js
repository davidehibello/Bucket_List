"use strict";

document.addEventListener("DOMContentLoaded", function () {
    
    
    // Function to validate the form
    function validateForm() {
        // Reset previous error messages
        resetErrors();


        // Validate each input
        let isValid = true;


        // Validate list selection
        const list = document.getElementById("list").value;
        if (list === '0') {
            displayError("list", "Please select a bucket list.");
            isValid = false;
        }


        // Validate name
        const itemName = document.getElementById("gotoasummerfestival").value;
        if (!itemName.trim()) {
            displayError("gotoasummerfestival", "Please enter the name.");
            isValid = false;
        }


        // Validate date format
        const createdDate = document.getElementById("start").value;
        const completedDate = document.getElementById("completion").value;


        if (!isValidDateFormat(createdDate)) {
            displayError("item-start", "Invalid date format. Please use YYYY-MM-DD.");
            isValid = false;
        }


        if (!isValidDateFormat(completedDate)) {
            displayError("item-Completion", "Invalid date format. Please use YYYY-MM-DD.");
            isValid = false;
        }


        // Validate description
        const description = document.getElementById("description").value;
        if (!description.trim()) {
            displayError("description", "Please enter a description.");
            isValid = false;
        }


        // Validate rating
        const rating = document.getElementById("rating").value;
        if (rating === '0') {
            displayError("rating", "Please select a rating.");
            isValid = false;
        }


         // Validate details
         const details = document.getElementById("details").value;
         if (!description.trim()) {
             displayError("details", "Please enter a description.");
             isValid = false;
         }


        return isValid;
    }


    // Event listener for form submission
    document.getElementById("edit-form").addEventListener("submit", function (event) {
        if (!validateForm()) {
            // Prevent form submission if validation fails
            event.preventDefault();
        }
    });


    // Function to display an error message
    function displayError(field, message) {
        const errorSpan = document.querySelector(`#${field} + .error`);
        errorSpan.textContent = message;
    }


    // Function to reset error messages
    function resetErrors() {
        const errorSpans = document.querySelectorAll(".error");
        errorSpans.forEach((span) => (span.textContent = ""));
    }


    // Function to validate date format (YYYY-MM-DD)
    function isValidDateFormat(dateString) {
        const dateFormatRegex = /^\d{4}-\d{2}-\d{2}$/;
        return dateFormatRegex.test(dateString);
    }

    







 // rating field star system implementation
    const starRating = document.getElementById("star-rating");
    const ratingInputs = starRating.querySelectorAll("input[name='rating']");
    const errorDisplay = document.querySelector(".error");

    // Event listener for rating inputs
    ratingInputs.forEach((input) => {
        input.addEventListener("change", function () {
            resetErrors();
            const selectedRating = this.value;
            console.log("Selected Rating:", selectedRating);
        });
    });

    function resetErrors() {
        errorDisplay.textContent = "";
    }


  
    
});

// WORD LIMIT ON DETAILS implementation
document.addEventListener("DOMContentLoaded", function () {
    const descriptionTextarea = document.querySelector('textarea[name="details"]');
    const characterCounter = document.querySelector('#character-counter');

    // Set the initial character count
    updateCharacterCount();

    // Add an input event listener to the description textarea
    descriptionTextarea.addEventListener('input', function () {
        updateCharacterCount();
    });

    function updateCharacterCount() {
        const maxLength = 2500;
        const currentLength = descriptionTextarea.value.length;
        const charactersLeft = maxLength - currentLength;

        // Display the character count
        characterCounter.textContent = `${charactersLeft} characters left`;

        // Change the color based on the remaining characters
        if (charactersLeft >= 0) {
            characterCounter.style.color = 'black'; // or any color you prefer
        } else {
            characterCounter.style.color = 'red'; // or any color you prefer for exceeded limit
        }
    }
});
