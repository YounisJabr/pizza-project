<?php
global $conn;
include ('db_connect.php');
$sql = "select title,ingredients,id from pizzas"; #we write our querey

$result=mysqli_query($conn,$sql); #then we pass the coon and the sql
$pizzas=mysqli_fetch_all($result,MYSQLI_ASSOC); #we fetech the data and we put it in array form
mysqli_free_result($result);
mysqli_close($conn);
//print_r($pizzas);
?>
<!DOCTYPE html>
<html lang="lang">

<?php
include ("header.php");?>
<h4 class="center gray-text">pazzas!</h4>
<div class="container">
    <div class="row">
        <?php foreach ($pizzas as $pizza) :  ?>
            <div class="col s6 md3">
                <div class="card z-depth-0">
                    <img src="img/pizza.svg" class="pizza">
                    <div class="card-content center">
                        <h6><?php echo htmlspecialchars($pizza ['title'])?></h6>
                        <div><?Php foreach (explode(',',$pizza['ingredients' ]) as $ing):?>
                        <ul>
                            <?php echo htmlspecialchars($ing)?>
                        </ul>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="card-action right-align"><a class="brand-text" href="details.php?id=<?php echo $pizza['id'] ?>">More info</a></div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>
<?php include ('footer.php');
?>


</body>
</html>
