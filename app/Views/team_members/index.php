    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        #team_member-table thead th {
            background-color: #005058;
            color: white;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 28px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 28px;
        }

        .select2-container--default .select2-selection--single {
            border-color: #dcdcdc;
            height: 40px;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #005058;
            color: white;
        }

        a {
            color: #005058 !important;
            text-decoration: none;
            background-color: transparent;
        }

        div.dataTables_wrapper div.dataTables_filter input {
            margin: 20px;
        }

        table.dataTable.display tbody tr.even>.sorting_1,
        table.dataTable.order-column.stripe tbody tr.even>.sorting_1 {
            background-color: #ffffff;
        }

        table.dataTable.display tbody tr.odd>.sorting_1,
        table.dataTable.order-column.stripe tbody tr.odd>.sorting_1 {
            background-color: #ffffff;
        }

        a:hover {
            color: #3ab691;
            text-decoration: none;
        }
    </style>
    </head>
    <body>
        <div id="page-content" class="page-wrapper clearfix">
            <div class="card">
                <div class="page-title clearfix">
                    <h1>Franchise</h1>
                    <div class="title-button-group">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default btn-sm active me-0" title="<?php echo app_lang('list_view'); ?>">
                                <i data-feather="menu" class="icon-16"></i>
                            </button>
                            <?php echo anchor(get_uri("team_members/view"), "<i data-feather='grid' class='icon-16'></i>", array("class" => "btn btn-default btn-sm")); ?>
                        </div>
                        <?php
                        if ($login_user->is_admin || get_array_value($login_user->permissions, "can_add_or_invite_new_team_members")) {
                            echo modal_anchor(get_uri("team_members/import_modal_form"), "<i data-feather='upload' class='icon-16'></i> " . app_lang('import_team_members'), array("class" => "btn btn-default", "title" => app_lang('import_team_members')));
                            echo modal_anchor(get_uri("team_members/invitation_modal"), "<i data-feather='mail' class='icon-16'></i> " . app_lang('send_invitation'), array("class" => "btn btn-default", "title" => app_lang('send_invitation')));
                            echo modal_anchor(get_uri("team_members/modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_team_member'), array("class" => "btn btn-default", "title" => app_lang('add_team_member')));
                        }
                        ?>
                    </div>
                </div>
                <div class="filters">
                    <div class="form-group" style="margin-left:20px">
                        <select id="hire_date_filter" name="hire_date" class="form-control w-50">
                            <option value="tomorrow">Tomorrow</option>
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="last-7-days">Last 7 Days</option>
                            <option value="last-30-days">Last 30 Days</option>
                            <option value="current_month">This Month</option>
                            <option value="previous_month">Previous Month</option>
                            <option value="last-3-months">Last 3 Months</option>
                            <option value="last-6-months">Last 6 Months</option>
                            <option value="current_year">This Year</option>
                            <option value="previous_year">Previous Year</option>
                            <option value="all" selected>All</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="team_member-table" class="display" cellspacing="0" width="100%">
                    </table>
                </div>
            </div>
        </div>
        <script>
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
                    case 'current_month':
                        start = new Date(now.getFullYear(), now.getMonth(), 1);
                        end = new Date(now.getFullYear(), now.getMonth() + 1, 0);
                        break;
                    case 'previous_month':
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
                    case 'current_year':
                        start = new Date(now.getFullYear(), 0, 1);
                        end = new Date(now.getFullYear(), 11, 31);
                        break;
                    case 'previous_year':
                        start = new Date(now.getFullYear() - 1, 0, 1);
                        end = new Date(now.getFullYear() - 1, 11, 31);
                        break;
                    case 'all':
                        start = null;
                        end = null;
                        break;
                }

                if (start && end) {
                    start.setHours(0, 0, 0, 0);
                    end.setHours(23, 59, 59, 999);
                }

                return {
                    start,
                    end
                };
            }

            function formatDate(date) {
                const year = date.getFullYear();
                const month = ('0' + (date.getMonth() + 1)).slice(-2);
                const day = ('0' + date.getDate()).slice(-2);
                return `${year}-${month}-${day}`;
            }

            $(document).ready(function() {
                var visibleContact = "<?php echo $show_contact_info; ?>" === 'true';
                var visibleDelete = "<?php echo $login_user->is_admin; ?>" === 'true';

                var table = $("#team_member-table").DataTable({
                    ajax: {
                        url: '<?php echo get_uri("team_members/list_data/"); ?>',
                        data: function(d) {
                            var selectedFilter = $("#hire_date_filter").val();
                            var dateRange = getDateRange(selectedFilter);

                            if (dateRange.start && dateRange.end) {
                                d.start_date = formatDate(dateRange.start);
                                d.end_date = formatDate(dateRange.end);
                            } else {
                                d.start_date = null;
                                d.end_date = null;
                            }

                            var selectedStatus = $("#franchise_status").val();
                            if (selectedStatus !== 'all') {
                                d.status = selectedStatus;
                            } else {
                                d.status = null;
                            }
                        }
                    },
                    order: [
                        [1, "asc"]
                    ],
                    columns: [{
                            title: '',
                            className: "w50 text-center all"
                        },
                        {
                            title: "<?php echo 'Franchise Name'; ?>",
                            className: "w200 all"
                        },
                        {
                            title: "<?php echo 'Date of Registration'; ?>",
                            className: "w250 all"
                        },
                        {
                            title: "<?php echo 'City'; ?>",
                            className: "w15p"
                        },
                        {
                            title: "<?php echo 'Email'; ?>",
                            className: "w15p"
                        },
                        {
                            title: "<?php echo 'Phone'; ?>",
                            className: "w10"
                        },
                        {
                            title: "<?php echo 'Remarks'; ?>",
                            className: "w10"
                        },
                        {
                            title: "<?php echo 'Status'; ?>",
                            className: "w10p"
                        },
                        <?php echo $custom_field_headers; ?> {
                            visible: visibleDelete,
                            title: '<i data-feather="menu" class="icon-16"></i>',
                            className: "text-center option w100"
                        }
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });

                $("#hire_date_filter").change(function() {
                    table.ajax.reload();
                });

                $("#franchise_status").change(function() {
                    table.ajax.reload();
                });
            });
        </script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>