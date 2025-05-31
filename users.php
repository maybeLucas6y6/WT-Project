<?php
define ('SLASH', DIRECTORY_SEPARATOR);
define ('DIRECTOR_SITE', dirname(__FILE__));
require_once 'autoloader/autoloader.php';

$db = new Database();

$conn = $db->getConnection();

if (!$conn) {
    die("Connection failed.");
}

// Assuming your table is called 'users'
$sql = "SELECT * FROM users";
$result = pg_query($conn, $sql);

if ($result && pg_num_rows($result) > 0) {
    echo "<h1>List of Users</h1>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr>";

    // Fetch field names as headers
    $num_fields = pg_num_fields($result);
    for ($i = 0; $i < $num_fields; $i++) {
        echo "<th>" . htmlspecialchars(pg_field_name($result, $i)) . "</th>";
    }
    echo "</tr>";

    // Fetch rows
    while ($row = pg_fetch_assoc($result)) {
        echo "<tr>";
        foreach ($row as $col) {
            echo "<td>" . htmlspecialchars($col) . "</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No users found.";
}

$control = new userController();
?>
