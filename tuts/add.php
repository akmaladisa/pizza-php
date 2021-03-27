<?php
    include( 'config/db_connect.php' );

    $title = $ingredients = $email = '';

    $errors = array(
        'email' => '', 'title' => '', 'ingredients' => ''
    );

    if( isset( $_POST['submit'] ) ) {
        // use htmlspecial character to convert all the input into html like string num etc this is for safety

        //check email
        if( empty($_POST['email']) ) {
            $errors['email'] = "An email is required <br />";
        } else {
            $email = $_POST['email'];
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email must be a valid email address';
            }
        }

        //check title
        if( empty($_POST['title']) ) {
            $errors['title'] = "An title is required <br />";
        } else {
            $title = $_POST['title'];
            if( !preg_match('/^[a-zA-Z\s]+$/', $title) ) {
                $errors['title'] = "title must be letters and spaces only";
            }
        }

        //check ingredients
        if( empty($_POST['ingredients']) ) {
            $errors['ingredients'] = "An ingredients is required <br />";
        } else {
            $ingredients = $_POST['ingredients'];
            if( !preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients) ) {
                $errors['ingredients'] = "ingredients must be comma separated";
            }
        }

        if( array_filter( $errors ) ) {
            // echo "there is error in the form";
        } else {

            $email = mysqli_real_escape_string( $conn, $_POST['email'] );
            $title = mysqli_real_escape_string( $conn, $_POST['title'] );
            $ingredients = mysqli_real_escape_string( $conn, $_POST['ingredients'] );

            //create sql
            $sql = "INSERT INTO pizzas( title, email, ingredients ) VALUES( '$title',
            '$email', '$ingredients')";

            //save to DB and check
            if( mysqli_query( $conn, $sql ) ) {
                //success
                header( 'Location: index.php' );
            } else {
                //error
                echo "error query" . mysqli_error( $conn );
            }
            
        }

    } //end of post check


?>

<!DOCTYPE html>
<html lang="en">

    <?php include("template/header.php"); ?>

    <secion class="container grey-text">
        <h4 class="center">Add a Pizza</h4>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="white">
            <label for="">Your Email:</label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
            <div class="red-text">
                <?php echo $errors['email']; ?>
            </div>

            <label for="">Pizza Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
            <div class="red-text">
                <?php echo $errors['title']; ?>
            </div>

            <label for="">Ingredients (comma seperated):</label>
            <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
            <div class="red-text">
                <?php echo $errors['ingredients']; ?>
            </div>

            <div class="center">
                <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
            </div>
        </form>
    </secion>

    <?php include("template/footer.php"); ?>

    
</html>