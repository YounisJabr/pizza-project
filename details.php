<?php
global $conn;

include('db_connect.php');

// Handle deletion
if (isset($_POST['delete'])) {
    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);
    $sql = "DELETE FROM pizzas WHERE id = '$id_to_delete'"; // Corrected SQL query
    if (mysqli_query($conn, $sql)) {
        header('Location: add.php');
        exit(); // Always use exit after header redirection
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

// Retrieve pizza details
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM pizzas WHERE id = '$id'"; // Use quotes for the ID
    $result = mysqli_query($conn, $sql);
    $pizza = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include("header.php"); ?>

<div class="container center">
    <?php if ($pizza): ?>
        <h4><?php echo htmlspecialchars($pizza['title']); ?></h4>
        <p>Created by: <?php echo htmlspecialchars($pizza['email']); ?></p>
        <h5>Created at: <?php echo date('Y-m-d H:i:s', strtotime($pizza['create_time'])); ?></h5>
        <h5>Ingredients</h5>
        <p><?php echo htmlspecialchars($pizza['ingredients']); ?></p>
        <!-- Delete form -->
        <form action="details.php" method="POST">
            <input type="hidden" name="id_to_delete" value="<?php echo $pizza['id']; ?>">
            <input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
        </form>
    <?php else: ?>
        <h6>No such pizza</h6>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>
</html>