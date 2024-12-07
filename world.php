<?php
// Database credentials
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    // Establish a connection to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if a 'country' parameter is provided in the GET request
    $country = isset($_GET['country']) ? $_GET['country'] : '';

    // Prepare SQL query based on whether a country is provided
    if ($country) {
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->execute(['country' => "%$country%"]);
    } else {
        $stmt = $conn->query("SELECT * FROM countries");
    }

    // Fetch all results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the results as an HTML table
    header('Content-Type: text/html');
    echo '<table>';
    echo '<tr><th>Country</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr>';
    foreach ($results as $row) {
        echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['continent']}</td>
                <td>{$row['independence_year']}</td>
                <td>{$row['head_of_state']}</td>
              </tr>";
    }
    echo '</table>';
} catch (PDOException $e) {
    // Handle connection errors
    echo 'Error: ' . $e->getMessage();
}
?>
