<?php
include "components/db.php";

// Add Supplier
if (isset($_POST["submit"])) {
    $type = $_POST["sup_type"];
    $email = $_POST["sup_email"];
    $phone = $_POST["sup_phone"];

    $query = "INSERT INTO supplier (sup_type, sup_email, sup_phone) VALUES('$type', '$email', '$phone')";
    mysqli_query($conn, $query);

    echo "<script>alert('Supplier is added');</script>";
}

// Update Supplier
if (isset($_POST["update"])) {
    $updateSupId = $_POST["UProductId"];
    $columnToUpdate = $_POST["columnToUpdate"];
    $newValue = $_POST["newValue"];

    // Validate input based on columnToUpdate
    if (($columnToUpdate == 'sup_phone') && !is_numeric($newValue)) {
        echo "<script>alert('Invalid input for $columnToUpdate. Please enter a numeric value.')</script>";
    } else {
        // Update the supplier table
        $updateSupplierQuery = "UPDATE supplier SET $columnToUpdate='$newValue' WHERE sup_id='$updateSupId'";
        mysqli_query($conn, $updateSupplierQuery);

        echo "<script>alert('Supplier updated successfully');</script>";
    }
}

// Fetch all suppliers
$getAllSuppliersQuery = "SELECT * FROM supplier";
$supplierResult = mysqli_query($conn, $getAllSuppliersQuery);
?>

<html>
<head>
    <?php include "Style.php"; ?>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        td.editable {
            cursor: pointer;
        }

        td.editable:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <?php include "header.php"; ?>

    <div class="content">
        <div class="container">
            <h1> Mimi's Pet Shop </h1>
        </div>
    </div>

    <!-- Add Supplier Form -->
    <form action="" method="post">
        <div class="content">
            <div class="container">
                <h2>Add Supplier</h2>
                <label for="sup_type">Supplier Type:</label>
                <select class="" name="sup_type" required>
                    <option value="" selected hidden>--SELECT--</option>
                    <option value="Dogs">Dogs</option>
                    <option value="Cats">Cats</option>
                    <option value="Accessories">Accessories</option>
                    <option value="Other">Other</option>
                </select>
                <label for="sup_email">Supplier Email:</label>
                <input type="text" id="sup_email" name="sup_email" required><br><br>
                <label for="sup_phone">Supplier Phone:</label>
                <input type="number" id="sup_phone" name="sup_phone" required><br><br>
                <input type="submit" name="submit" value="Add">
            </div>
        </div>
    </form>

    <!-- Supplier Table -->
    <div class="content">
        <div class="container">
            <h2>Supplier Table</h2>

            <table>
                <tr>
                    <th>Supplier ID</th>
                    <th>Supplier Type</th>
                    <th>Supplier Email</th>
                    <th>Supplier Phone</th>
                </tr>

                <?php
                while ($row = mysqli_fetch_assoc($supplierResult)) {
                    ?>
                    <tr>
                        <td><?php echo isset($row['sup_id']) ? $row['sup_id'] : ''; ?></td>
                        <td><?php echo isset($row['sup_id']) ? $row['sup_type'] : ''; ?></td>
                        <td class="editable" onclick="editCell('<?php echo $row['sup_id']; ?>', 'sup_email', '<?php echo $row['sup_email']; ?>')"><?php echo $row['sup_email']; ?></td>
                        <td class="editable" onclick="editCell('<?php echo $row['sup_id']; ?>', 'sup_phone', '<?php echo $row['sup_phone']; ?>')"><?php echo $row['sup_phone']; ?></td>
                    </tr>
                <?php
                }
                ?>
            </table>

            <!-- Form for Updating Supplier -->
            <form action="" method="post">
                <input type="hidden" id="UProductId" name="UProductId">
                <input type="hidden" id="columnToUpdate" name="columnToUpdate">
                <input type="number" id="newValue" name="newValue" style="display: none;" min="0" step="0.01">
                <input type="submit" name="update" value="Update" style="display: none;">
            </form>
        </div>
    </div>

    <?php include "scripts.php"; ?>
    <script>
        function editCell(supplierId, columnToUpdate, currentValue) {
            document.getElementById("UProductId").value = supplierId;
            document.getElementById("columnToUpdate").value = columnToUpdate;
            document.getElementById("newValue").value = currentValue;
            document.getElementById("newValue").type = "text";
            document.getElementById("newValue").style.display = "inline";
            document.getElementById("update").style.display = "inline";
        }
    </script>

</body>
</html>
