<style>
    /* Table styles */
    #franchise-table {
        width: 100%;
        border-collapse: collapse;
        padding:15px;
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
                    </tr>
                </thead>
                <tbody><!-- Data will be populated here --></tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
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
                    row.append($('<td>').text(franchise.status));
                    tableBody.append(row);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    });
</script>