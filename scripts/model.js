

document.addEventListener("DOMContentLoaded", function () {

     // JAVASCRIPT TO VIEW LIST ITEMS IN MODEL WINDOW
    const items = document.querySelectorAll('.view-item-link');

    items.forEach(item => {
        item.addEventListener('click', function (event) {
            event.preventDefault();
            const itemId = this.getAttribute('data-item-id');
            openModal(itemId);
        });
    });

    function openModal(itemId) {
        // Fetch data from the server using AJAX
        fetch(`view-item.php?id=${itemId}`)
            .then(response => response.text())
            .then(data => {
                // Create a modal
                const modal = document.createElement('div');
                modal.classList.add('modal');
                modal.innerHTML = data;

               // Add styles to center the modal
            modal.style.position = 'fixed';
            modal.style.top = '50%';
            modal.style.left = '50%';
            modal.style.transform = 'translate(-50%, -50%)';

                // Append the modal to the body
                document.body.insertAdjacentElement('beforeend', modal);

                // Close modal when clicking outside of it
                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        closeModal();
                    }
                });

                // Close modal when pressing the ESC key
                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        closeModal();
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    function closeModal() {
        const modal = document.querySelector('.modal');
        if (modal) {
            modal.remove();
        }
    }



        // JAVASCRIPT TO CONFIRM THE DELETION OF AN ITEM
        const deleteLinks = document.querySelectorAll('.delete-item-link');
    
        deleteLinks.forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault();
    
                const itemId = this.getAttribute('data-item-id');
                const confirmation = confirm('Are you sure you want to delete this item?');
    
                if (confirmation) {
                    // If user clicks OK, proceed with deletion
                    window.location.href = `./delete-item.php?id=${itemId}`;
                }
            });
        });
  




// JAVASCRIPT TO CONFIRM THE DELETION OF AN ACCOUNT
console.log("Model.js loaded");

const deleteAccountLinks = document.querySelectorAll('.delete-account-link');

deleteAccountLinks.forEach(link => {
    link.addEventListener('click', function (event) {
        event.preventDefault();

        console.log("Delete account link clicked");

        const confirmation = confirm('Are you sure you want to delete your account?');

        console.log("Confirmation dialog result:", confirmation);

        if (confirmation) {
            console.log("User confirmed. Proceeding with account deletion.");
            // If user clicks OK, proceed with account deletion
            window.location.href = `./delete-account.php`;
        } else {
            console.log("User canceled account deletion.");
        }
      });
  });

    
});