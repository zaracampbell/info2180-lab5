<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $country = isset($_GET['country']) ? $_GET['country'] : '';
    $lookup = isset($_GET['lookup']) ? $_GET['lookup'] : '';

    if ($lookup === 'cities') {
        $stmt = $conn->prepare(
            "SELECT cities.name AS city_name, cities.district, cities.population 
             FROM cities 
             JOIN countries ON cities.country_code = countries.code 
             WHERE countries.name LIKE :country"
        );
        $stmt->execute(['country' => "%$country%"]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: text/html');
        echo '<table border="1">';
        echo '<tr>
                <th>Name</th>
                <th>District</th>
                <th>Population</th>
              </tr>';
        foreach ($results as $row) {
            echo "<tr>
                    <td>{$row['city_name']}</td>
                    <td>{$row['district']}</td>
                    <td>{$row['population']}</td>
                  </tr>";
        }
        echo '</table>';
    } else {
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->execute(['country' => "%$country%"]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
