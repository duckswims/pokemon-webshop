document.addEventListener('DOMContentLoaded', () => {
    const userButton = document.querySelector('.user-button');
    const userDropdown = document.querySelector('.user-dropdown');

    // Toggle the user dropdown visibility when the user button is clicked
    userButton.addEventListener('click', () => {
        userDropdown.style.display = userDropdown.style.display === 'flex' ? 'none' : 'flex';
    });

    // Close the dropdown if the user clicks outside of the dropdown or the button
    document.addEventListener('click', (event) => {
        if (!userButton.contains(event.target) && !userDropdown.contains(event.target)) {
            userDropdown.style.display = 'none';
        }
    });
});
