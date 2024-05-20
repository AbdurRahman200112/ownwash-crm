
    <!-- Display validation errors if any -->
    <?php if (session()->has('errors')) : ?>
        <div class="alert alert-danger">
            <?php echo implode('<br>', session('errors')); ?>
        </div>
    <?php endif; ?>

    <!-- Display success message if any -->
    <?php if (session()->has('success')) : ?>
        <div class="alert alert-success">
            <?php echo session('success'); ?>
        </div>
    <?php endif; ?>
    <div class="card">

    <!-- Edit Customer Form -->
    <form action="<?php echo site_url('customerfetch/update/' . $customer['id']); ?>" method="post">
        <!-- Add input fields for customer details -->
        <label for="registrationDate">Registration Date:</label>
        <input type="date" name="registrationDate" value="<?php echo $customer['registrationDate']; ?>" required><br>

        <label for="customerName">Customer Name:</label>
        <input type="text" name="customerName" value="<?php echo $customer['customerName']; ?>" required><br>

        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo $customer['address']; ?>" required><br>

        <label for="mobile">Mobile:</label>
        <input type="text" name="mobile" value="<?php echo $customer['mobile']; ?>" required><br>

        <label for="carSegments">Car / Segment:</label>
        <input type="text" name="carSegments" value="<?php echo $customer['carSegments']; ?>" required><br>

        <label for="hours">Hours:</label>
        <input type="number" name="hours" value="<?php echo $customer['hours']; ?>" required><br>

        <label for="minutes">Minutes:</label>
        <input type="number" name="minutes" value="<?php echo $customer['minutes']; ?>" required><br>

        <label for="meridiem">Meridiem:</label>
        <select name="meridiem" required>
            <option value="AM" <?php echo ($customer['meridiem'] == 'AM') ? 'selected' : ''; ?>>AM</option>
            <option value="PM" <?php echo ($customer['meridiem'] == 'PM') ? 'selected' : ''; ?>>PM</option>
        </select><br>

        <label for="amount">Amount:</label>
        <input type="text" name="amount" value="<?php echo $customer['amount']; ?>" required><br>

        <label for="assignFranchise">Assign Franchise:</label>
        <input type="text" name="assignFranchise" value="<?php echo $customer['assignFranchise']; ?>" required><br>

        <label for="status">Status:</label>
        <select name="status" required>
            <option value="Active" <?php echo ($customer['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
            <option value="Inactive" <?php echo ($customer['status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
        </select><br>

        <label for="anyRemarks">Any Remarks:</label>
        <textarea name="anyRemarks" required><?php echo $customer['anyRemarks']; ?></textarea><br>

        <button type="submit">Update</button>
    </form>
    </div>
