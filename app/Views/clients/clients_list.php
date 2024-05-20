<style>
    /* Style the table */
    #client-table {
        width: 100%;
        border-collapse: collapse;
    }

    #client-table th,
    #client-table td {
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
                    <th>Actions</th>
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
    $(document).ready(function() {
        // Fetch data using AJAX
        $.ajax({
            url: '<?php echo site_url("customerfetch/list_data") ?>',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log('Logged-in email:', response.email); // Print the email in console

                // Clear existing table data
                $('#client-table tbody').empty();

                // Populate table with fetched data
                $.each(response.data, function(index, client) {
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

                    // Add Delete button
                    var actionCell = $('<td>');
                    var deleteButton = $('<button style="color:white">').text('Delete').addClass('btn p-2 btn-danger delete-button').data('id', client.id);
                    actionCell.append(deleteButton);
                    row.append(actionCell);

                    // Add row to table
                    $('#client-table tbody').append(row);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });

        // Delete button action
        $('#client-table').on('click', '.delete-button', function() {
            var clientId = $(this).data('id');
            if (confirm('Are you sure you want to delete this client?')) {
                $.ajax({
                    url: '<?php echo site_url("customerfetch/delete/") ?>' + clientId,
                    method: 'POST',
                    success: function(response) {
                        // Reload the page after successful deletion
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting client:', error);
                    }
                });
            }
        });
    }); 
</script>
