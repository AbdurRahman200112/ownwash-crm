<style>
    /* Table styles */
    #franchise-table {
        width: 100%;
        border-collapse: collapse;
        padding: 15px;
        align-items: center;
    }

    #franchise-table th,
    #franchise-table td {
        padding: 8px;
        border: 1px solid #ddd;
        text-align: left;
    }

    /* Header styles */
    #franchise-table thead th {
        background-color: #ffff;
        font-weight: bold;
    }

    /* Alternate row color */
    #franchise-table tbody tr:nth-child(even) {
        background-color: #ffff;
    }

    /* Style for status "done" */
    .status-done {
        background-color: #ccffcc; /* Green */
        text-align: center;
    }

    /* Style for status "cancelled" */
    .status-cancelled {
        background-color: #ffcccc; /* Red */
    }
</style>

<div id="page-content" class="page-wrapper clearfix">
    <div class="card grid-button">
        <div class="page-title clearfix projects-page">
            <h1><?php echo "Franchises" ?></h1>
            <div class="title-button-group">
                <?php
                if ($can_create_projects) {
                    if ($can_edit_projects) {
                        echo modal_anchor(get_uri("labels/modal_form"), "<i data-feather='tag' class='icon-16'></i> " . app_lang('manage_labels'), array("class" => "btn btn-default", "title" => app_lang('manage_labels'), "data-post-type" => "project"));
                    }
                    
                    echo modal_anchor(get_uri("projects/import_modal_form"), "<i data-feather='upload' class='icon-16'></i> import Franchise",array("class" => "btn btn-default", "title" => "import Franchise"));

                    echo modal_anchor(
                        get_uri("projects/modal_form"), 
                        "<i data-feather='plus-circle' class='icon-16'></i> Add Franchise", 
                        array(
                            "class" => "btn btn-default", 
                            "title" => "Add Franchise"
                        )
                    );
                }
                ?>
            </div>
            <div class="table-responsive">
                <table id="franchise-table" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Registration Date</th>
                            <th>Franchise Name</th>
                            <th>City</th>
                            <th>Mobile Number</th>
                            <th>Email ID</th>
                            <th>Remarks</th>
                            <th>Status</th>
                            <th>Actions</th> <!-- Add action column for edit/delete buttons -->
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // Fetch data via AJAX
        $.ajax({
            url: '<?php echo site_url("franchises/list"); ?>',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                var tableBody = $('#franchise-table tbody');
                tableBody.empty(); // Clear existing data

                $.each(response, function(index, franchise) {
                    var row = $('<tr>');
                    row.append($('<td>').text(franchise.registration_date));
                    row.append($('<td>').text(franchise.franchise_name));
                    row.append($('<td>').text(franchise.city));
                    row.append($('<td>').text(franchise.mobile_number));
                    row.append($('<td>').text(franchise.email_id));
                    row.append($('<td>').text(franchise.remarks));

                    // Add status cell with appropriate class
                    var statusCell = $('<td>').text(franchise.status);
                    if (franchise.status === 'done') {
                        statusCell.addClass('status-done');
                    } else if (franchise.status === 'cancelled by customer') {
                        statusCell.addClass('status-cancelled');
                    }
                    row.append(statusCell);

                    // Add actions cell
                    var actionsCell = $('<td>');
                    var deleteButton = $('<button style="color:white">')
                        .text('Delete')
                        .addClass('btn btn-danger delete-button p-3')
                        .data('id', franchise.id);
                    actionsCell.append(deleteButton);
                    row.append(actionsCell);

                    tableBody.append(row);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });

        $('#franchise-table').on('click', '.delete-button', function() {
            var franchiseId = $(this).data('id');
            var $row = $(this).closest('tr'); // Get the row to remove

            if (confirm('Are you sure you want to delete this franchise?')) {
                $.ajax({
                    url: '<?php echo site_url("franchise/delete/"); ?>' + franchiseId,
                    method: 'POST',
                    success: function(response) {
                        if (response.success) {
                            window.location.href = '<?php echo site_url("projects/index"); ?>'; // Redirect on successful delete
                        } else {
                            alert('Failed to delete the franchise.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting franchise:', error);
                    }
                });
            }
        });
    });
</script>
