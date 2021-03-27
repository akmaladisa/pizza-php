<?php

    //connect to the databse
    $conn = mysqli_connect( 'localhost'/*host name*/ , 'Akmal'/*user name*/,
                            'test123'/*password*/, 'ninja_pizza'/*database name*/ );

    //check connection
    if( !$conn ) {
        echo "Connection Error: " . mysqli_connect_error();
    }
?>