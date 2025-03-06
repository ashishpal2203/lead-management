<?php
include 'layouts/header.php';

if (!isset($_GET['id'])) {
    die("Lead ID is required.");
}

$lead_id = intval($_GET['id']); // Prevent SQL Injection

$stmt = $mysqli->prepare("SELECT * FROM leads WHERE id = ?");
$stmt->bind_param("i", $lead_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Lead not found.");
}

$lead = $result->fetch_assoc();
?>


<section id="lead-details">

    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <h2>Lead Details</h2>

                <table class="table table-borderless">
                    <tr>
                        <th>Lead Number:</th>
                        <td><?= $lead['lead_number'] ?></td>
                    </tr>
                    <tr>
                        <th>Customer Name:</th>
                        <td><?= $lead['customer_name'] ?></td>
                    </tr>
                    <tr>
                        <th>Contact No:</th>
                        <td><?= $lead['contact_no'] ?></td>
                    </tr>
                    <tr>
                        <th>Project Name:</th>
                        <td><?= $lead['project_name'] ?></td>
                    </tr>
                    <tr>
                        <th>Flat Details:</th>
                        <td><?= $lead['flat_details'] ?></td>
                    </tr>
                    <tr>
                        <th>Property Cost:</th>
                        <td><?= $lead['property_cost'] ?></td>
                    </tr>
                    <tr>
                        <th>State:</th>
                        <td><?= $lead['state'] ?></td>
                    </tr>
                    <tr>
                        <th>City:</th>
                        <td><?= $lead['city'] ?></td>
                    </tr>
                    <tr>
                        <th>Loan Amount:</th>
                        <td><?= $lead['loan_amount'] ?></td>
                    </tr>
                    <tr>
                        <th>Rate of Interest (ROI %):</th>
                        <td><?= $lead['roi'] ?></td>
                    </tr>
                    <tr>
                        <th>Tenor (Months):</th>
                        <td><?= $lead['tenor'] ?></td>
                    </tr>
                    <tr>
                        <th>EMI:</th>
                        <td><?= $lead['emi'] ?></td>
                    </tr>
                    <tr>
                        <th>Created At:</th>
                        <td><?= $lead['created_at'] ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-5">
                <h4>Lead Attachments</h4>
                <div id="imageGallery" class="d-flex gap-2 flex-wrap">
                </div>
            </div>
        </div>
    </div>

</section>






<script>
    $(document).ready(function() {
        function loadImages() {
            $.ajax({
                url: "fetch_lead_images.php",
                type: "GET",
                data: {
                    id: <?= $lead_id ?>
                },
                success: function(data) {
                    $("#imageGallery").html(data);
                }
            });
        }

        loadImages();
    });
</script>

<?php include 'layouts/footer.php'; ?>