"use strict";

document.addEventListener("DOMContentLoaded", function () {
    // Function to validate the form
    function validateForm() {
        // Get form inputs
        const form = document.getElementById("username").value;
        const username = document.getElementById("username").value;
        const name = document.getElementById("name").value;
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;


        form.addEventListener('submit', e => {
            e.prevebtDefault();

            validateInputs();
        });

        

        const setError = (element, message) => {
            const inputControl = element.parentElement;
            const errorDisplay = inputControl.querySelector('.error');
        
            errorDisplay.innerText = message;
            inputControl.classList.add('error');
            inputControl.classList.remove('success')
        }
        
        const setSuccess = element => {
            const inputControl = element.parentElement;
            const errorDisplay = inputControl.querySelector('.error');
        
            errorDisplay.innerText = '';
            inputControl.classList.add('success');
            inputControl.classList.remove('error');
        };
        
        const isValidEmail = email => {
            const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }
        
        const validateInputs = () => {
            const usernameValue = username.value.trim();
            const nameValue = name.value.trim();
            const emailValue = email.value.trim();
            const passwordValue = password.value.trim();
            
        
            if(usernameValue === '') {
                setError(username, 'Username is required');
            } else {
                setSuccess(username);
            }

            if(nameValue === '') {
                setError(name, 'name is required');
            } else {
                setSuccess(name);
            }

            if(emailValue === '') {
                setError(email, 'Email is required');
            } else if (!isValidEmail(emailValue)) {
                setError(email, 'Provide a valid email address');
            } else {
                setSuccess(email);
            }
        
            if(passwordValue === '') {
                setError(password, 'Password is required');
            } else if (passwordValue.length < 8 ) {
                setError(password, 'Password must be at least 8 character.')
            } else {
                setSuccess(password);
            }
        
        };
        
    }


    // Function to validate username using AJAX
    function validateUsername(username) {
    // Use AJAX to send a request to the server for username validation
    // You can implement this based on your server-side validation logic

    // Example using Fetch API:
    fetch('validate-username.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ username: username }),
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response from the server
        if (data.exists) {
            document.getElementById('username-error').innerText = 'Username already exists';
        } else {
            document.getElementById('username-error').innerText = '';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
    }

     // Function to update password strength indicator
    function updatePasswordStrength(password) {
    // Implement password strength logic here
    // You can use a library like zxcvbn for password strength estimation

    // Example: Display password strength in a div with id "password-strength"
    const strengthIndicator = document.getElementById('password-strength');
    // Your password strength logic here
    // strengthIndicator.innerText = 'Weak | Strong | Very Strong';
    }

    // Event listener for username field on input
    document.getElementById('username').addEventListener('input', function() {
    const username = this.value;
    if (username.trim() !== '') {
        validateUsername(username);
    } else {
        document.getElementById('username-error').innerText = '';
    }
    });

     // Event listener for password field on input
     document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    updatePasswordStrength(password);
    });

    // Event listener for "Show Password" checkbox
    document.getElementById('show-password').addEventListener('change', function() {
    const passwordField = document.getElementById('password');
    passwordField.type = this.checked ? 'text' : 'password';
    });

});
