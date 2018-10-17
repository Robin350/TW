<?php
    function printLoginform(){
        echo    "
                <form action='checklogin.php' method='post' >

                   <label>Email:</label><br/>
                   <input name='email' type='email' id='email' required>
                    <br/>                 
                   <label>Password:</label><br/>
                   <input name='password' type='password' id='password' required><br/>
                                      
                   <input class='btn' type='submit' name='Submit' value='Log in'>
               
                </form>";
    }
?>