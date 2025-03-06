<?php
include 'layouts/header.php';

// Fetch lead count per state
$query = "SELECT state, COUNT(*) as lead_count FROM leads GROUP BY state";
$result = $mysqli->query($query);

$states = [];
$leadCounts = [];

while ($row = $result->fetch_assoc()) {
    $states[] = $row['state'];
    $leadCounts[] = $row['lead_count'];
}
?>


<section id="dashboard">
    <div class="container">

        <h2>Dashboard</h2>
        <hr>

        <div class="card p-3">
            <h4>Leads Count by State</h4>
            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <canvas id="leadChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const ctx = document.getElementById('leadChart').getContext('2d');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?= json_encode($states) ?>,
            datasets: [{
                label: 'Leads per State',
                data: <?= json_encode($leadCounts) ?>,
                backgroundColor: ['red', 'blue', 'green', 'yellow', 'purple', 'orange', 'cyan'],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
            }
        }
    });
</script>
<?php include 'layouts/footer.php'; ?>