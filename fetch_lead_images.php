<?php
include 'DB/connect.php';

if (!isset($_GET['id'])) {
    die("Lead ID is required.");
}

$lead_id = intval($_GET['id']);
$imageDir = "uploads/";
$images = glob($imageDir . $lead_id . "_*");

if (count($images) > 0) {
    foreach ($images as $image) {
        echo "<img src='$image' width='150' height='150' class='img-thumbnail'>";
    }
} else {
    echo "<p>No images found.</p>";
}
?>
