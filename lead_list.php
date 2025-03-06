<?php include 'layouts/header.php'; ?>

<section id="lead-list">
    <div class="container">
        <h2 class="mb-4">Lead List</h2>

        <!-- Search Box -->
        <input type="text" id="search" class="form-control mb-3" placeholder="Search by Customer Name or Contact No">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Lead Number</th>
                    <th>Customer Name</th>
                    <th>Contact No</th>
                    <th>Project Name</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="leadTable">
                <!-- Leads will be loaded here via Ajax -->
            </tbody>
        </table>
    </div>
</section>

<script>
    $(document).ready(function() {
        function loadLeads(query = '') {
            $.ajax({
                url: "fetch_leads.php",
                type: "GET",
                data: {
                    search: query
                },
                success: function(data) {
                    $("#leadTable").html(data);
                }
            });
        }

        loadLeads(); // Initial Load

        $("#search").on("keyup", function() {
            var query = $(this).val();
            loadLeads(query);
        });
    });
</script>

<?php include 'layouts/footer.php'; ?>