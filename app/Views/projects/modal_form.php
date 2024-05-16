<?php echo form_open('franchise/save', array('id' => 'franchise-form', 'class' => 'general-form')); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
        <div class="form-group">
            <div class="row">
                <label for="title" class=" col-md-3">Registration Date</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(
                        array(
                            "id" => "registration_date",
                            "name" => "registration_date",
                            "class" => "form-control",
                            "placeholder" => "Registration Date",
                            "autofocus" => true,
                            "data-rule-required" => true,
                            "data-msg-required" => "Registration Date is required",
                        )
                    );
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="title" class=" col-md-3">Franchise Name</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(
                        array(
                            "id" => "franchise_name",
                            "name" => "franchise_name",
                            "class" => "form-control",
                            "placeholder" => "Franchise Name",
                        )
                    );
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="title" class=" col-md-3">City</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(
                        array(
                            "id" => "city",
                            "name" => "city",
                            "class" => "form-control",
                            "placeholder" => "City",
                        )
                    );
                    ?>

                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="title" class=" col-md-3">Mobile Number</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(
                        array(
                            "id" => "mobile_number",
                            "name" => "mobile_number",
                            "class" => "form-control",
                            "placeholder" => "Mobile Number",
                        )
                    );
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="description" class=" col-md-3">Email Id</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(
                        array(
                            "id" => "email_id",
                            "name" => "email_id",
                            "class" => "form-control",
                            "placeholder" => "Email Id",
                        )
                    );
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="start_date" class=" col-md-3">Remarks</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(
                        array(
                            "id" => "remarks",
                            "name" => "remarks",
                            "class" => "form-control datepicker",
                            "placeholder" => "Remarks",
                        )
                    );
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="deadline" class=" col-md-3">Status</label>
                <div class=" col-md-9">
                    <?php
                    $options = array(
                        'cancelled by franchise' => 'Cancelled by Franchise',
                        'cancelled by customer' => 'Cancelled by Customer',
                        'done' => 'Done'
                    );

                    echo form_dropdown(
                        'status', // name attribute of the dropdown
                        $options, // options array
                        '', // selected value (if any)
                        array(
                            'id' => 'status', // id attribute of the dropdown
                            'name' => 'status', // add name attribute
                            'class' => 'form-control' // CSS class
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
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x"
            class="icon-16"></span>Close</button>
    <button type="button" id="save-and-continue-button" class="btn btn-info text-white"><span
            data-feather="check-circle" class="icon-16"></span>Save and Continue</button>
    <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span>Save</button>
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        // Set date picker for registration date
        setDatePicker("#registration_date");

        // Save and continue button functionality
        $("#save-and-continue-button").click(function () {
            $("#franchise-form").submit(); // Submit the form
        });
    });
</script>