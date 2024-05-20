

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Franchise</title>
</head>

<body>
    <h1>Edit Franchise</h1>

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

    <div id="page-content" class="page-wrapper clearfix">
        <!-- edit_franchise.php -->
<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?><!DOCTYPE html>
<html lang="en">
        <div class="card grid-button">
            <div class="page-title clearfix projects-page">
                <form action="<?php echo site_url('franchise/update/' . $franchise['id']); ?>" method="post">
                    <label for="registration_date">Registration Date:</label>
                    <input type="date" name="registration_date" value="<?php echo $franchise['registration_date']; ?>" required><br>

                    <label for="franchise_name">Franchise Name:</label>
                    <input type="text" name="franchise_name" value="<?php echo $franchise['franchise_name']; ?>" required><br>

                    <label for="city">City:</label>
                    <input type="text" name="city" value="<?php echo $franchise['city']; ?>" required><br>

                    <label for="mobile_number">Mobile Number:</label>
                    <input type="text" name="mobile_number" value="<?php echo $franchise['mobile_number']; ?>" required><br>

                    <label for="email_id">Email ID:</label>
                    <input type="email" name="email_id" value="<?php echo $franchise['email_id']; ?>" required><br>

                    <label for="remarks">Remarks:</label>
                    <textarea name="remarks" required><?php echo $franchise['remarks']; ?></textarea><br>
                    <label for="status">Status:</label>
                    <select name="status" required>
                        <option value="Cancelled by Customer" <?php echo ($franchise['status'] == 'Cancelled by Customer') ? 'selected' : ''; ?>>Cancelled by Customer</option>
                        <option value="Cancelled By Franchis" <?php echo ($franchise['status'] == 'Cancelled By Franchis') ? 'selected' : ''; ?>>Cancelled By Franchise</option>
                        <option value="Done" <?php echo ($franchise['status'] == 'Done') ? 'selected' : ''; ?>>Done</option>
                    </select><br>

                    <button type="submit">Update</button>
                </form>
            </div>
           </div>
        </div>
</body>

</html>