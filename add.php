<?php
global $conn;
include('db_connect.php');

$email = $title = $ingredients = '';
$error = ['email' => '', 'title' => '', 'ingredients' => ''];

if (isset($_POST['submit'])) {
    // Initialize the error array
    $error = [];

    // Check the email
    if (empty($_POST['email'])) {
        $error['email'] = "The email is required <br />";
    } else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error['email'] = "Your email is not valid <br />";
        }
    }

    // Check the title
    if (isset($_POST['title']) && empty($_POST['title'])) {
        $error['title'] = "The title is required <br />";
    } elseif (isset($_POST['title'])) {
        $title = $_POST['title'];
        if (!preg_match("/^[a-zA-Z ]*$/", $title)) {
            $error['title'] = "Your title is not valid <br />";
        }
    }

    // Check ingredients
    if (empty($_POST['ingredients'])) {
        $error['ingredients'] = "The ingredients are required <br />";
    } else {
        if (!preg_match("/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/", $_POST['ingredients'])) {
            $error['ingredients'] = "Your ingredients are not valid <br />";
        }
    }

    // Handle errors
    if (array_filter($error)) {
        echo "You have errors in the form: <br />";
        foreach ($error as $err) {
            echo $err; // Display each error message
        }
    } else {
        // Escape string inputs for security
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

        // Prepare and execute the SQL insert query
        $sql = "INSERT INTO pizzas (email, title, ingredients) VALUES ('$email', '$title', '$ingredients')";
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php");
            exit(); // Always use exit after header redirection
        } else {
            echo "Query error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include("header.php"); ?>
<section class="container grey-text">
    <h4 class="center">Add a Pizza</h4>
    <form class="white" action="add.php" method="POST">
        <label>Your email:</label>
        <label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
        </label>
        <div class="red-text"><?php echo $error['email']; ?></div>

        <label>Pizza title:</label>
        <label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>">
        </label>
        <div class="red-text"><?php echo $error['title']; ?></div>

        <label>Ingredients:</label>
        <label>
            <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients); ?>">
        </label>
        <div class="red-text"><?php echo $error['ingredients']; ?></div>

        <div class="center">
            <input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>

<?php include('footer.php'); ?>
</html>