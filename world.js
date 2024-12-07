// Ensure the script runs after the page is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    const lookupBtn = document.querySelector('#lookup');
    const resultDiv = document.querySelector('#result');

    // Create and append the "Lookup Cities" button
    const lookupCitiesBtn = document.createElement('button');
    lookupCitiesBtn.textContent = 'Lookup Cities';
    lookupCitiesBtn.id = 'lookup-cities';
    document.querySelector('#controls').appendChild(lookupCitiesBtn);

    // Function to perform AJAX request and fetch data
    function fetchResults(lookupType = '') {
        const country = document.querySelector('#country').value.trim();
        const url = `world.php?country=${encodeURIComponent(country)}${lookupType ? `&lookup=${lookupType}` : ''}`;

        // Fetch API to get data from PHP service
        fetch(url)
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data; // Insert response data into the #result div
            })
            .catch(err => {
                console.error('Error fetching data:', err);
                resultDiv.innerHTML = '<p style="color:red;">An error occurred. Please try again later.</p>';
            });
    }

    // Event listeners for buttons
    lookupBtn.addEventListener('click', () => fetchResults());
    lookupCitiesBtn.addEventListener('click', () => fetchResults('cities'));
});

