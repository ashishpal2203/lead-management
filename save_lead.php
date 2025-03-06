<?php
include 'DB/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST['customer_name'];
    $contact_no = $_POST['contact_no'];
    $project_name = $_POST['project_name'];
    $flat_details = $_POST['flat_details'];
    $property_cost = $_POST['property_cost'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $loan_amount = $_POST['loan_amount'];
    $roi = $_POST['roi'];
    $tenor = $_POST['tenor'];
    
    // Calculate EMI (Loan Amount * ROI * Tenor / 100)
    $emi = ($loan_amount * $roi * $tenor) / 100;

    // Generate unique lead number 
    $lead_number = "LEAD" . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);

    // Insert Lead into Database
    $stmt = $mysqli->prepare("INSERT INTO leads (lead_number, customer_name, contact_no, project_name, flat_details, property_cost, state, city, loan_amount, roi, tenor, emi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssddid", $lead_number, $customer_name, $contact_no, $project_name, $flat_details, $property_cost, $state, $city, $loan_amount, $roi, $tenor, $emi);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $lead_id = $stmt->insert_id; 
    } else {
        die("Error: Failed to insert lead.");
    }

    $stmt->close();

    // Image Upload Process
    $imagePaths = [];
    if (!empty($_FILES['images']['name'][0])) {
        $uploadDir = 'uploads/';

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true); 
        }

        foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
            $imageName = $lead_id . '_' . time() . '_' . preg_replace('/\s+/', '_', $_FILES['images']['name'][$key]); // Remove spaces in filename
            $filePath = $uploadDir . $imageName;

            if (move_uploaded_file($tmpName, $filePath)) {
                $imagePaths[] = $filePath;
            } else {
                echo "Failed to upload: " . $_FILES['images']['name'][$key];
            }
        }
    }

    echo "Lead saved successfully with Lead ID: $lead_id";
}
?>
