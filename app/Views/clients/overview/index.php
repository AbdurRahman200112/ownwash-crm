<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body,
    html {
        height: 100%;
        font-family: 'Arial', sans-serif;
    }
    .container {
        display: flex;
        height: 100%;
    }

    .content {
        flex-grow: 1;
        background-color: #ecf0f1;
        padding: 20px;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .profile {
        display: flex;
        background-color: #ffffff;
        padding: 20px;
        align-items: center;
        gap: 20px;
    }

    .photo img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
    }

    .info {
        flex-grow: 1;
    }

    .info h2 {
        color: #2c3e50;
    }

    .info p {
        color: #7f8c8d;
    }

    .actions {
        display: flex;
        justify-content: flex-end;
    }

    .actions button {
        padding: 10px 20px;
        background-color: #3498db;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .notes {
        background-color: #ffff;
        padding: 20px;
        height:310px;
        justify-content: center;
        flex:1;
        align-items:'center'
   

    }

    .note p {
        background-color: #ecf0f1;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    /* Responsive styles */
    @media (max-width: 768px) {

        .profile,
        .notes {
            flex-direction: column;
        }

        .actions {
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .content {
            padding: 10px;
        }

        .profile {
            flex-direction: column;
        }

        .photo img {
            width: 80px;
            /* Smaller profile picture on phones */
            height: 80px;
        }

        .actions button {
            width: 100%;
            /* Full width button on small screens */
        }
    }
</style>
<div class="mt20">
    <div class="row">
        <div class="col-md-3">
            <?php echo total_clients_widget($show_own_clients_only_user_id, $allowed_client_groups); ?>
        </div>
        <div class="col-md-3">
            <?php echo total_contacts_widget($show_own_clients_only_user_id, $allowed_client_groups); ?>
        </div>
        <div class="col-md-3">
            <?php echo client_contacts_logged_in_widget("logged_in_today", $show_own_clients_only_user_id, $allowed_client_groups); ?>
        </div>
        <div class="col-md-3">
            <?php echo client_contacts_logged_in_widget("logged_in_seven_days", $show_own_clients_only_user_id, $allowed_client_groups); ?>
        </div>
    </div>

    <?php if ($show_invoice_info) { ?>
        <div class="row">
            <div class="col-md-4">
                <?php echo client_invoices_widget("has_unpaid_invoices", $show_own_clients_only_user_id, $allowed_client_groups); ?>
            </div>

            <div class="col-md-4">
                <?php echo client_invoices_widget("has_partially_paid_invoices", $show_own_clients_only_user_id, $allowed_client_groups); ?>
            </div>

            <div class="col-md-4">
                <?php echo client_invoices_widget("has_overdue_invoices", $show_own_clients_only_user_id, $allowed_client_groups); ?>
            </div>
        </div>
    <?php } ?>
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="col-md-6" style="border-radius:20px">
                    <!-- <div class="header">
                        <img src="logo.png" alt="Company Logo">
                    </div> -->
                    <div class="profile">
                        <div class="info">
                            <div class="row">
                                <div class="col-md-6 bgs">
                                <img src="image/avatar.jpg" height="300px" width="300px" alt="Mohan Kumar Sharma">
                                </div>
                                <div class="col-md-6">
                                    <h4 style="color:#005058;text-decoration:underline"><b>Mohan Kumar Sharma</b></h4>
                                    <h4 style="color:#005058;text-decoration:underline"><b>Mumbai (MH)</b></h4>

                                </div>
                                <p style="text-align:center"><span><b>Email:</b></span> rahul9901@gmail.com</p>

                            </div>

                            <div class="row p-3" style="background-color:#005058">
                                <div class="col-md-6">
                                    <p style="color:yellow; text-align:center"><b>Reg. Date</b></p>
                                    <p style="color:white;text-align:center"><b>29/09/2023</b></p>
                                </div>
                                <div class="col-md-6">
                                    <p style="color:yellow; text-align:center"><b>Amount</b></p>
                                    <p style="color:white;text-align:center">₹120000/-</p>
                                </div>
                            </div>

                            <div class="row mt-2 p-3" style="background-color:#005058">
                                <div class="col-md-5">
                                    <p
                                        style="color:#005058;background-color:yellow; padding:15px; width:100%;border-radius:20px;text-align:center">
                                        <b>Business Address</b></p>

                                </div>
                                <div class="col-md-7">
                                    <p style="color:white">305, Satguru Parinay, Vijay Nagar, Indore, MP - 452010</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="notes flex-1 align-items-center justify-content-center">
                        <h3>Follow-up & Notes</h3>
                        <div class="note">
                            <p>29/08/2024 16:24 - Vandana</p>
                            <p>We have a conversation with franchise that he will start the work as soon as possible due
                                to election he is busy</p>
                        </div>
                        <!-- More notes can be added here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        //trigger clients tab when it's client overview page
        $('body').on('click', '.client-widget-link', function (e) {
            e.preventDefault();

            var filter = $(this).attr("data-filter");
            if (filter) {
                window.selectedClientQuickFilter = filter;
                $("[data-bs-target='#clients_list']").attr("data-reload", "1").trigger("click");
            }
        });

        //trigger contacts tab when click on contact widget
        $('body').on('click', '.contact-widget-link', function (e) {
            e.preventDefault();

            var filter = $(this).attr("data-filter");
            if (filter) {
                window.selectedContactQuickFilter = filter;
                $("[data-bs-target='#contacts']").attr("data-reload", "1").trigger("click");
            }
        });
    });
</script>