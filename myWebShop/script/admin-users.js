// Toggle the admin status when the checkbox is clicked
function toggleAdmin(username, checkbox) {
    const adminStatus = checkbox.checked;

    // Create the request to update the user's info.json in the same PHP file
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'admin-users.php', true);  // Send POST request to the current page
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle the successful response (e.g., logging)
            console.log('Admin status updated successfully for ' + username);
        }
    };

    // Sending the data to update the admin status in the JSON file
    xhr.send('username=' + encodeURIComponent(username) + '&admin=' + (adminStatus ? 'true' : 'false'));
}
