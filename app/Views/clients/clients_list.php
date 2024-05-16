<style>
    /* Style the table */
    #client-table {
        width: 100%;
        border-collapse: collapse;
    }

    #client-table th, #client-table td {
        padding: 8px;
        border: 1px solid #ddd;
    }

    #client-table th {
        background-color: #f2f2f2;
        text-align: left;
    }

    #client-table tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #client-table tbody tr:hover {
        background-color: #ddd;
    }
</style>
<div class="card">
<div class="table-responsive">
        <table id="client-table" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Customer Name</th>
                    <th>Address</th>
                    <th>Mobile</th>
                    <th>Car / Segment</th>
                    <th>Time</th>
                    <th>Assign Franchise</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Any Remarks</th>
                    <!-- Add other table headers as needed -->
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated here -->
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        // Fetch data using AJAX
        $.ajax({
            url: '<?php echo site_url("customerfetch/list_data") ?>',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                // Clear existing table data
                $('#client-table tbody').empty();

                // Populate table with fetched data
                $.each(response, function(index, client) {
                    var row = $('<tr>');
                    row.append($('<td>').text(client.registrationDate));
                    row.append($('<td>').text(client.customerName));
                    row.append($('<td>').text(client.address));
                    row.append($('<td>').text(client.mobile));
                    row.append($('<td>').text(client.carSegments));
                    row.append($('<td>').text(client.hours + ':' + client.minutes + ' ' + client.meridiem));
                    row.append($('<td>').text(client.assignFranchise));
                    row.append($('<td>').text(client.amount));
                    row.append($('<td>').text(client.status));
                    row.append($('<td>').text(client.anyRemarks));
                    // Add more columns if needed
                    $('#client-table tbody').append(row);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    });
</script>
