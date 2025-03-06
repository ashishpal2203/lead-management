<?php
include 'DB/connect.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM leads WHERE customer_name LIKE ? OR contact_no LIKE ?";
$stmt = $mysqli->prepare($sql);
$searchTerm = "%$search%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['lead_number']}</td>
            <td>{$row['customer_name']}</td>
            <td>{$row['contact_no']}</td>
            <td>{$row['project_name']}</td>
            <td>{$row['state']}</td>
            <td>{$row['city']}</td>
            <td><a href='lead_details.php?id={$row['id']}' class='btn btn-info'>View</a></td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='7' class='text-center'>No leads found</td></tr>";
}

$stmt->close();
?>
