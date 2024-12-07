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

    // Check for 'country' parameter in the GET request
    $country = isset($_GET['country']) ? $_GET['country'] : '';

    // Prepare the SQL query based on the presence of the 'country' parameter
    if ($country) {
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->execute(['country' => "%$country%"]);
    } else {
        $stmt = $conn->query("SELECT * FROM countries");
    }

    // Fetch all results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the results in an HTML table
    header('Content-Type: text/html');
    echo '<table border="1">';
    echo '<tr>
            <th>Country</th>
            <th>Continent</th>
            <th>Independence Year</th>
            <th>Head of State</th>
          </tr>';
    foreach ($results as $row) {
        echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['continent']}</td>
                <td>" . ($row['independence_year'] ?? 'N/A') . "</td>
                <td>{$row['head_of_state']}</td>
              </tr>";
    }
    echo '</table>';
} catch (PDOException $e) {
    // Handle database connection errors
    echo 'Error: ' . $e->getMessage();
}
?>
