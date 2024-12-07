document.addEventListener('DOMContentLoaded', () => {
    const lookupBtn = document.querySelector('#lookup');
    const lookupCitiesBtn = document.querySelector('#lookup-cities');
    const resultDiv = document.querySelector('#result');

    // Function to fetch data based on the lookup type
    function fetchData(lookupType = '') {
        const country = document.querySelector('#country').value.trim();
        const url = `world.php?country=${encodeURIComponent(country)}${lookupType ? `&lookup=${lookupType}` : ''}`;

        fetch(url)
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data; // Insert the response data into the result div
            })
            .catch(err => {
                console.error('Error fetching data:', err);
                resultDiv.innerHTML = '<p style="color:red;">An error occurred. Please try again later.</p>';
            });
    }

    // Event listeners for both buttons
    lookupBtn.addEventListener('click', () => fetchData());
    lookupCitiesBtn.addEventListener('click', () => fetchData('cities'));
});
