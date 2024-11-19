<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['hire_date'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "rise";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $hire_date = $_GET['hire_date'];
    $date_condition = "";
    switch ($hire_date) {
        case 'current_week':
            $date_condition = "AND date_of_hire >= DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY)";
            break;
        case 'previous_week':
            $date_condition = "AND date_of_hire >= DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) + 7 DAY) 
                               AND date_of_hire < DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY)";
            break;
        case 'current_month':
            $date_condition = "AND date_of_hire >= DATE_FORMAT(CURDATE(), '%Y-%m-01')";
            break;
        case 'previous_month':
            $date_condition = "AND date_of_hire >= DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH, '%Y-%m-01') 
                               AND date_of_hire < DATE_FORMAT(CURDATE(), '%Y-%m-01')";
            break;
        case 'six_months':
            $date_condition = "AND date_of_hire >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)";
            break;
        case 'current_year':
            $date_condition = "AND date_of_hire >= DATE_FORMAT(CURDATE(), '%Y-01-01')";
            break;
        case 'previous_year':
            $date_condition = "AND date_of_hire >= DATE_FORMAT(CURDATE() - INTERVAL 1 YEAR, '%Y-01-01') 
                               AND date_of_hire < DATE_FORMAT(CURDATE(), '%Y-01-01')";
            break;
        case 'all':
        default:
            $date_condition = "";
            break;
    }

    $sql_open_count = "SELECT COUNT(*) AS open_count FROM rise_team_member_job_info WHERE salary_term = 'cancelled by customer' $date_condition";
    $sql_completed_count = "SELECT COUNT(*) AS completed_count FROM rise_team_member_job_info WHERE salary_term = 'done' $date_condition";
    $sql_hold_count = "SELECT COUNT(*) AS hold_count FROM rise_team_member_job_info WHERE salary_term = 'cancelled by franchise' $date_condition";

    $result_open = $conn->query($sql_open_count);
    $result_completed = $conn->query($sql_completed_count);
    $result_hold = $conn->query($sql_hold_count);

    $row_open = $result_open->fetch_assoc();
    $row_completed = $result_completed->fetch_assoc();
    $row_hold = $result_hold->fetch_assoc();

    $conn->close();

    echo json_encode([
        'open_count' => $row_open['open_count'],
        'completed_count' => $row_completed['completed_count'],
        'hold_count' => $row_hold['hold_count']
    ]);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Franchise Overview</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="card bg-white">
<div class="filter-options p-3">
    <select id="hire_date" name="hire_date" style="padding:8px;">
        <option value="current_week">Current Week</option>
        <option value="previous_week">Previous Week</option>
        <option value="current_month">This Month</option>
        <option value="previous_month">Previous Month</option>
        <option value="six_months">Last 6 Months</option>
        <option value="current_year">This Year</option>
        <option value="previous_year">Previous Year</option>
        <option value="all" selected>All</option>
    </select>
</div>
    <div class="card-header">
        <i data-feather="grid" class="icon-16"></i> &nbsp;Franchise Overview
    </div>
    <div class="rounded-bottom pt-2">
        <div class="box">
            <div class="box-content">
                <a href="projects/all_projects/1" class="text-default">
                    <div class="pt-3 pb10 text-center">
                        <div class="b-r">
                            <h4 id="open-count" class="strong mb-1 mt-0" style="color: #01B393;"></h4>
                            <span>cancelled by customer</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="box-content">
                <a href="projects/all_projects/2" class="text-default">
                    <div class="pt-3 pb10 text-center">
                        <div class="b-r">
                            <h4 id="completed-count" class="strong mb-1 mt-0 text-danger"></h4>
                            <span>done</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="box-content">
                <a href="projects/all_projects/3" class="text-default">
                    <div class="pt-3 pb10 text-center">
                        <div>
                            <h4 id="hold-count" class="strong mb-1 mt-0 text-warning"></h4>
                            <span>cancelled by franchise</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="container project-overview-widget">
            <div class="progress-outline">
                <div class="progress mt5 m-auto position-relative">
                    <div class="progress-bar bg-orange text-default" role="progressbar" style="width:50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                        <span class="justify-content-center d-flex position-absolute w-100">progression 50%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    function fetchCounts(hireDate) {
        $.ajax({
            url: '',
            type: 'GET',
            data: { hire_date: hireDate },
            success: function(data) {
                var counts = JSON.parse(data);
                $('#open-count').text(counts.open_count);
                $('#completed-count').text(counts.completed_count);
                $('#hold-count').text(counts.hold_count);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    $('#hire_date').on('change', function() {
        var hireDate = $(this).val();
        fetchCounts(hireDate);
    });

    // Fetch initial counts
    fetchCounts('all');
});
</script>

</body>
</html>
