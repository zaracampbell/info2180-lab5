// Ensure the script runs after the page is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    const lookupBtn = document.querySelector('#lookup');
    const resultDiv = document.querySelector('#result');

    // Function to fetch country data from the server
    function fetchCountryData() {
        const country = document.querySelector('#country').value.trim();
        const url = `world.php?country=${encodeURIComponent(country)}`;

        // Use Fetch API to send an AJAX request
        fetch(url)
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data; // Insert the response data into the #result div
            })
            .catch(err => {
                console.error('Error fetching data:', err);
                resultDiv.innerHTML = '<p style="color:red;">An error occurred. Please try again later.</p>';
            });
    }

    // Add event listener to the Lookup button
    lookupBtn.addEventListener('click', fetchCountryData);
});
