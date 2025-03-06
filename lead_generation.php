<?php include 'layouts/header.php'; ?>

<section id="lead-form">
    <div class="container">
        <h2 class="mb-4">Lead Generation Form</h2>

        <form id="leadForm" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label>Lead Number:</label>
                    <input type="text" class="form-control" name="lead_number" id="lead_number" readonly>
                </div>

                <div class="col-12 col-md-6">
                    <label>Customer Name:</label>
                    <input type="text" class="form-control" name="customer_name" required>
                </div>

                <div class="col-12 col-md-6">
                    <label>Contact No:</label>
                    <input type="text" class="form-control" id="phone_number" name="contact_no"
                        placeholder="Mobile Number" maxlength="10"
                        pattern="\d{10}"
                        oninput="this.value = this.value.replace(/\D/g, '').slice(0, 10);"
                        title="Enter a valid 10-digit mobile number"
                        required>
                </div>

                <div class="col-12 col-md-6">
                    <label>Project Name:</label>
                    <input type="text" class="form-control" name="project_name">
                </div>

                <div class="col-12 col-md-6">
                    <label>Flat Details:</label>
                    <input type="text" class="form-control" name="flat_details">
                </div>

                <div class="col-12 col-md-6">
                    <label>Property Cost:</label>
                    <input type="number" class="form-control" name="property_cost">
                </div>

                <div class="col-12 col-md-6">
                    <label>State:</label>
                    <select class="form-control" name="state" id="state">
                        <option value="">Select State</option>
                    </select>
                </div>

                <div class="col-12 col-md-6">
                    <label>City:</label>
                    <select class="form-control" name="city" id="city">
                        <option value="">Please select a state first</option>
                    </select>
                </div>

                <div class="col-12 col-md-6">
                    <label>Loan Amount:</label>
                    <input type="number" class="form-control" name="loan_amount" id="loan_amount">
                </div>

                <div class="col-12 col-md-6">
                    <label>Rate of Interest (ROI %):</label>
                    <input type="number" class="form-control" name="roi" id="roi">
                </div>

                <div class="col-12 col-md-6">
                    <label>Tenor (Months):</label>
                    <input type="number" class="form-control" name="tenor" id="tenor">
                </div>

                <div class="col-12 col-md-6">
                    <label>EMI:</label>
                    <input type="text" class="form-control" id="emi" name="emi" readonly>
                </div>

                <div class="col-12 col-md-6">
                    <label>Upload Images:</label>
                    <input type="file" class="form-control" name="images[]" multiple>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn submit_btn">Save Lead</button>
            </div>
        </form>

    </div>
</section>
<script>
    $(document).ready(function() {
        let citiesData = [];

        $.getJSON("json/cities.json", function(data) {
            citiesData = data;

            let states = [...new Set(data.map(city => city.state))];

            states.forEach(state => {
                $("#state").append(`<option value="${state}">${state}</option>`);
            });
        });


        $("#state").change(function() {
            let selectedState = $(this).val();
            $("#city").html('<option value="">Select City</option>'); 

            if (selectedState) {
                let filteredCities = citiesData.filter(city => city.state === selectedState);
                filteredCities.forEach(city => {
                    $("#city").append(`<option value="${city.name}">${city.name}</option>`);
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Generate Lead Number
        $.get("generate_lead_number.php", function(data) {
            $("#lead_number").val(data);
        });

        // EMI Calculation
        $("#loan_amount, #roi, #tenor").on("input", function() {
            var loan = parseFloat($("#loan_amount").val()) || 0;
            var roi = parseFloat($("#roi").val()) || 0;
            var tenor = parseFloat($("#tenor").val()) || 1;

            var monthlyRate = roi / 100 / 12;
            var emi = (loan * monthlyRate * Math.pow(1 + monthlyRate, tenor)) / (Math.pow(1 + monthlyRate, tenor) - 1);
            $("#emi").val(isNaN(emi) ? 0 : emi.toFixed(2));
        });

        // Submit form via Ajax
        $("#leadForm").on("submit", function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "save_lead.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    alert("Lead Saved Successfully!");
                    $("#leadForm")[0].reset();
                    window.location.href = "lead_list.php";
                }
            });
        });
    });
</script>

<?php include 'layouts/footer.php'; ?>