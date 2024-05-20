<?php echo form_open(get_uri('customers/save'), array("id" => "customer-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
    <div class="form-group">
        <div class="row">
            <label for="title" class=" col-md-3">Registration Date</label>
            <div class=" col-md-9">
                <?php
                echo form_input(
                    array(
                        "id" => "registrationDate",
                        "name" => "registrationDate",
                        "class" => "form-control datepicker",
                        "placeholder" => "Registration Date",
                    )
                );
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="title" class=" col-md-3">Customer Name</label>
            <div class=" col-md-9">
                <?php
                echo form_input(
                    array(
                        "id" => "customerName",
                        "name" => "customerName",
                        "class" => "form-control",
                        "placeholder" => "Customer Name",
                    )
                );
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="title" class=" col-md-3">Address</label>
            <div class=" col-md-9">
                <?php
                echo form_input(
                    array(
                        "id" => "address",
                        "name" => "address",
                        "class" => "form-control",
                        "placeholder" => "Address",
                    )
                );
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="title" class=" col-md-3">Mobile</label>
            <div class=" col-md-9">
                <?php
                echo form_input(
                    array(
                        "id" => "mobile",
                        "name" => "mobile",
                        "class" => "form-control",
                        "placeholder" => "Mobile",
                    )
                );
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="description" class=" col-md-3">Car / Segments</label>
            <div class=" col-md-9">
                <?php
                echo form_input(
                    array(
                        "id" => "carSegments",
                        "name" => "carSegments",
                        "class" => "form-control",
                        "placeholder" => "Car / Segments",
                    )
                );
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="start_date" class=" col-md-3">Time</label>
            <div class=" col-md-9">
                <div class="row">
                    <div class="col-md-3">
                        <select name="hours" id="hours" class="form-control">
                            <?php
                            for ($hour = 1; $hour <= 12; $hour++) {
                                echo "<option value=\"$hour\">" . sprintf('%02d', $hour) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    :
                    <div class="col-md-3">
                        <select name="minutes" id="minutes" class="form-control">
                            <?php
                            for ($minute = 0; $minute < 60; $minute++) {
                                echo "<option value=\"$minute\">" . sprintf('%02d', $minute) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="meridiem" id="meridiem" class="form-control">
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group mt-3">
                <div class="row">
                    <label for="deadline" class=" col-md-3">Amount</label>
                    <div class=" col-md-9">
                        <?php
                        echo form_input(
                            array(
                                "id" => "amount",
                                "name" => "v",
                                "class" => "form-control",
                                "placeholder" => "Amount",
                            )
                        );
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="assignFranchise" class="col-md-3">Assign Franchise</label>
                    <div class="col-md-9">
                        <select name="assignFranchise" id="assignFranchise" class="form-control">
                            <?php
                            // Database connection configuration
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "rise";

                            // Create connection
                            $conn = new mysqli($servername, $username, $password, $dbname);

                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // SQL query to fetch staff users
                            $sql = "SELECT * FROM rise_users WHERE is_admin = '0' AND user_type != 'client'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    $fullName = $row['email'];
                                    echo "<option value='" . $fullName . "'>" . $fullName . "</option>";
                                }
                            } else {
                                echo "<option value=''>No clients found</option>";
                            }
                            
                            $conn->close();
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="price" class=" col-md-3">Status</label>
                    <div class=" col-md-9">
                        <?php
                        $options = array(
                            'cancelled by_ ranchise' => 'Cancelled by Franchise',
                            'cancelled by customer' => 'Cancelled by Customer',
                            'done' => 'Done'
                        );
                        echo form_dropdown(
                            'status',
                            $options,
                            '',
                            array(
                                'id' => 'status',
                                'class' => 'form-control'
                            )
                        );
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label for="project_labels" class=" col-md-3">Any Remarks</label>
                    <div class=" col-md-9">
                        <?php
                        echo form_input(
                            array(
                                "id" => "anyRemarks",
                                "name" => "anyRemarks",
                                "class" => "form-control",
                                "placeholder" => "Any Remarks",
                            )
                        );
                        ?>
                    </div>
                </div>
            </div>
            <?php echo view("custom_fields/form/prepare_context_fields", array("custom_fields" => $custom_fields, "label_column" => "col-md-3", "field_column" => " col-md-9")); ?>
        </div>
    </div>
    <div class="modal-footer">
        <div id="link-of-add-contact-modal" class="hide">
            <?php echo modal_anchor(get_uri("clients/add_new_contact_modal_form"), "", array()); ?>
        </div>
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x"
                class="icon-16"></span> <?php echo app_lang('close'); ?></button>
        <?php if (!$model_info->id) { ?>
            <button type="button" id="save-and-continue-button" class="btn btn-info text-white"><span
                    data-feather="check-circle" class="icon-16"></span>
                <?php echo app_lang('save_and_continue'); ?></button>
        <?php } ?>
        <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span>
            <?php echo app_lang('save'); ?></button>
    </div>
    <?php echo form_close(); ?>

    <script type="text/javascript">
        $(document).ready(function () {
            var ticket_id = "<?php echo $ticket_id; ?>";

            window.clientForm = $("#client-form").appForm({
                closeModalOnSuccess: false,
                onSuccess: function (result) {
                    var $addMultipleContactsLink = $("#link-of-add-contact-modal").find("a");

                    if (result.view === "details" || ticket_id) {
                        if (window.showAddNewModal) {
                            $addMultipleContactsLink.attr("data-post-client_id", result.id);
                            $addMultipleContactsLink.attr("data-title", "<?php echo app_lang('add_multiple_contacts') ?>");
                            $addMultipleContactsLink.attr("data-post-add_type", "multiple");

                            $addMultipleContactsLink.trigger("click");
                        } else {
                            appAlert.success(result.message, { duration: 10000 });
                            setTimeout(function () {
                                location.reload();
                            }, 500);
                        }
                    } else if (window.showAddNewModal) {
                        $addMultipleContactsLink.attr("data-post-client_id", result.id);
                        $addMultipleContactsLink.attr("data-title", "<?php echo app_lang('add_multiple_contacts') ?>");
                        $addMultipleContactsLink.attr("data-post-add_type", "multiple");

                        $addMultipleContactsLink.trigger("click");

                        $("#client-table").appTable({ newData: result.data, dataId: result.id });
                    } else {
                        $("#client-table").appTable({ newData: result.data, dataId: result.id });
                        window.clientForm.closeModal();
                    }
                }
            });
            setTimeout(function () {
                $("#company_name").focus();
            }, 200);
            setDatePicker("#registrationDate, #registrationDate");

            window.showAddNewModal = false;

            $("#save-and-continue-button").click(function () {
                window.showAddNewModal = true;
                $(this).trigger("submit");
            });
        });
    </script>