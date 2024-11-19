<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    #client-table {
        width: 100%;
        border-collapse: collapse;
    }

    #client-table th,
    #client-table td {
        padding: 8px;
        /* border: 1px solid #ddd; */
        text-align: center;
    }

    #client-table th {
        background-color: #005058;
        color: white;
        padding:20px;
        text-align: center;

    }

    #client-table tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #client-table tbody tr:hover {
        background-color: #ddd;
    }

    #filter-section {
        margin-bottom: 20px;
    }
</style>

<div class="card">
    <div id="filter-section" style="margin-top:20px;margin-bottom:20px; margin-left:10px">
        <select id="time-filter" style="padding:10px;border-color:#3AB691; border-radius:20px; width:30%">
            <option value="tomorrow">Tomorrow</option>
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="last-7-days">Last 7 Days</option>
            <option value="last-30-days">Last 30 Days</option>
            <option value="current-month">Current Month</option>
            <option value="last-month">Previous Month</option>
            <option value="last-3-months">Last 3 Months</option>
            <option value="last-6-months">Last 6 Months</option>
            <option value="current-week">Current Week</option>
            <option value="last-week">Last Week</option>
            <option value="six-months">Last 6 Months</option>
            <option value="current-year">This Year</option>
            <option value="last-year">Previous Year</option>
        </select>
    </div>
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
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        function getDateRange(filterType) {
            const now = new Date();
            let start, end;

            switch (filterType) {
                case 'tomorrow':
                    start = new Date(now);
                    start.setDate(now.getDate() + 1);
                    end = new Date(start);
                    break;
                case 'today':
                    start = new Date(now);
                    end = new Date(start);
                    break;
                case 'yesterday':
                    start = new Date(now);
                    start.setDate(now.getDate() - 1);
                    end = new Date(start);
                    break;
                case 'last-7-days':
                    start = new Date(now);
                    start.setDate(now.getDate() - 7);
                    end = new Date(now);
                    break;
                case 'last-30-days':
                    start = new Date(now);
                    start.setDate(now.getDate() - 30);
                    end = new Date(now);
                    break;
                case 'current-month':
                    start = new Date(now.getFullYear(), now.getMonth(), 1);
                    end = new Date(now.getFullYear(), now.getMonth() + 1, 0);
                    break;
                case 'last-month':
                    start = new Date(now.getFullYear(), now.getMonth() - 1, 1);
                    end = new Date(now.getFullYear(), now.getMonth(), 0);
                    break;
                case 'last-3-months':
                    start = new Date(now);
                    start.setMonth(now.getMonth() - 3);
                    end = new Date(now);
                    break;
                case 'last-6-months':
                    start = new Date(now);
                    start.setMonth(now.getMonth() - 6);
                    end = new Date(now);
                    break;
                case 'current-week':
                    const currentDay = now.getDay();
                    start = new Date(now);
                    start.setDate(now.getDate() - currentDay + (currentDay === 0 ? -6 : 1));
                    end = new Date(start);
                    end.setDate(start.getDate() + 6);
                    break;
                case 'last-week':
                    start = new Date(now);
                    start.setDate(now.getDate() - now.getDay() - 7 + (now.getDay() === 0 ? -6 : 1));
                    end = new Date(start);
                    end.setDate(start.getDate() + 6);
                    break;
                case 'current-year':
                    start = new Date(now.getFullYear(), 0, 1);
                    end = new Date(now.getFullYear(), 11, 31);
                    break;
                case 'last-year':
                    start = new Date(now.getFullYear() - 1, 0, 1);
                    end = new Date(now.getFullYear() - 1, 11, 31);
                    break;
            }
            return {
                start: start,
                end: end
            };
        }
        function formatDate(date) {
            const year = date.getFullYear();
            const month = ('0' + (date.getMonth() + 1)).slice(-2);
            const day = ('0' + date.getDate()).slice(-2);
            return `${year}-${month}-${day}`;
        }

        function fetchData(filterType) {
            const dateRange = getDateRange(filterType);
            const startDate = formatDate(dateRange.start);
            const endDate = formatDate(dateRange.end);

            $.ajax({
                url: '<?php echo site_url("customerfetch/list_data") ?>',
                method: 'GET',
                data: {
                    start_date: startDate,
                    end_date: endDate,
                    filter_type: filterType
                },
                dataType: 'json',
                success: function(response) {
                    console.log('Logged-in email:', response.email);

                    $('#client-table tbody').empty();

                    $.each(response.data, function(index, client) {
                        var clientDate = new Date(client.registrationDate);
                        if (clientDate >= dateRange.start && clientDate <= dateRange.end) {
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

                            var actionCell = $('<td>');
                            var editButton = $('<button>').html('<i style="color:#005058" class="fas fa-pencil-alt"></i>').addClass('btn edit-button').data('id', client.id);
                            actionCell.append(editButton);
                            row.append(actionCell);

                            $('#client-table tbody').append(row);
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }
        fetchData('current-week');
        $('#time-filter').on('change', function() {
            const filterType = $(this).val();
            fetchData(filterType);
        });

        $('#client-table').on('click', '.edit-button', function() {
            var clientId = $(this).data('id');
            var row = $(this).closest('tr');

            row.find('td').each(function(index, td) {
                // Skip the "Amount" column
                if (index !== 7) {
                    if (index < 10) {
                        var value = $(td).text();
                        if (index === 0) {
                            $(td).html('<input type="text" class="form-control datepicker" value="' + value + '">');
                        } else {
                            $(td).html('<input type="text" class="form-control" value="' + value + '">');
                        }
                    }
                }
            });

            row.find('.datepicker').datepicker({
                dateFormat: 'yy-mm-dd',
                defaultDate: new Date(), // Ensure the default date is set correctly
                changeMonth: true, // Add dropdown for month
                changeYear: true // Add dropdown for year
            });

            $(this).html('<i style="color:white" class="fas fa-save"></i>').removeClass('edit-button').addClass('save-button btn-success');
        });

        $('#client-table').on('click', '.save-button', function() {
            var clientId = $(this).data('id');
            var row = $(this).closest('tr');
            var updatedData = {};

            row.find('td').each(function(index, td) {
                // Skip the "Amount" column
                if (index !== 7) {
                    if (index < 10) {
                        var value = $(td).find('input').val();
                        switch (index) {
                            case 0:
                                updatedData.registrationDate = value;
                                break;
                            case 1:
                                updatedData.customerName = value;
                                break;
                            case 2:
                                updatedData.address = value;
                                break;
                            case 3:
                                updatedData.mobile = value;
                                break;
                            case 4:
                                updatedData.carSegments = value;
                                break;
                            case 5: // Time column
                                var timeParts = value.split(' ');
                                var time = timeParts[0].split(':');
                                updatedData.hours = time[0];
                                updatedData.minutes = time[1];
                                updatedData.meridiem = timeParts[1];
                                break;
                            case 6:
                                updatedData.assignFranchise = value;
                                break;
                            case 8:
                                updatedData.status = value;
                                break;
                            case 9:
                                updatedData.anyRemarks = value;
                                break;
                        }
                    }
                } else {
                    updatedData.amount = $(td).text();
                }
            });

            updatedData.id = clientId;

            $.ajax({
                url: '<?php echo site_url("customerfetch/update_data") ?>',
                method: 'POST',
                data: updatedData,
                success: function(response) {
                    if (response.status === 'success') {
                        row.find('td').each(function(index, td) {
                            if (index !== 7) {
                                if (index < 10) {
                                    var value = $(td).find('input').val();
                                    $(td).text(value);
                                }
                            }
                        });
                        $(this).html('<i style="color:#6690F4" class="fas fa-pencil-alt"></i>').removeClass('save-button btn-success').addClass('edit-button btn-primary');
                    } else {
                        alert('Error updating data');
                    }
                }.bind(this),
                error: function(xhr, status, error) {
                    console.error('Error updating data:', error);
                }
            });
        });
    });
</script>