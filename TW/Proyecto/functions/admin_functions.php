<?php
    require_once 'db_operations.php';

    function printModDelForm($id, $page_name, $section){
        echo "<td><form action='{$page_name}' method='POST'>
                    <input type='hidden' name='id'  value='{$id}' />
                    <input class='btn' type='submit' name='action' value='Modify $section' />
                    <input  class='btn' type='submit' name='action' value='Delete $section' />
                </form></td>";
        
    }
    function printDelForm($id, $page_name, $section){
        echo "<td><form action='{$page_name}' method='POST'>
                    <input type='hidden' name='id'  value='{$id}' />
                    <input  class='btn' type='submit' name='action' value='Delete $section' />
                </form></td>";
        
    }

    function printAddForm($page_name, $section, $id=NULL){
        echo "<td><form action='{$page_name}' method='POST'>";
        if(isset($id)){
            echo "<input type='hidden' name='album' value='{$id}'/>";
        }
        echo    "<input class='btn orange' type='submit' name='action' value='Add $section' />
            </form></td>";
        
    }

    function checkActionHome($action, $id, $page_name){
        echo "<br/>Action: ". $action ."<br/>";

        $action_return=null;
        $id_return=null;

        $adname=isset($_POST['adname'])?$_POST['adname']:null;
        $adsurname=isset($_POST['adsurname'])?$_POST['adsurname']:null;
        $ademail=isset($_POST['ademail'])?$_POST['ademail']:null;
        $adpassword=isset($_POST['adpassword'])?$_POST['adpassword']:null;
        $adtype=isset($_POST['adtype'])?$_POST['adtype']:null;

        $con = dbConnection();

        if (isset($action)){
            switch ($action) {
            case 'Delete Paragraph':
                $action_return = 'Delete Paragraph';
                $id_return = $id;
                break;
        
            case 'Modify Paragraph':
                $action_return = 'Modify Paragraph';
                $id_return = $id;
                $sql = "SELECT * FROM Introduction WHERE Id='$id'";
                $query = $con->query($sql);
                checkDBquery($con,$sql);
                $result = $query->fetch_assoc();
                $_SESSION['tmp'] = $id_return;
              
                echo "<td><form action='{$page_name}' method='POST' id='modIntform'>              
                        <input class='btn white' type='submit' name='modifyI' value='Accept' />
                        <input class='btn white' type='submit' name='modifyI' value='Cancel' /><br/>
                        Title<input type='text' name='Title' value='".$result['Title']."'/> (optional)<br/>";

                echo    "</form></td>
                            <textarea rows='10' cols='100' name='Content' form='modIntform'>".$result['Content']."</textarea>";

                break;


            case 'Add Paragraph':
                $action_return = 'Add Paragraph';
                echo "<td><form action='{$page_name}' method='POST' id='addIntform'>              
                    <input class='btn white' type='submit' name='addI' value='Add' />
                    <br/>Title<input type='text' name='Title'/>(optional)<br/> ";
    
                echo    "</form></td>
                                <textarea rows='10' cols='100' name='Content' form='addIntform'></textarea>";
    
                break;




            case 'Delete User':
                $action_return = 'Delete User';
                $id_return = $id;
                break;

            case 'Modify User':
                $action_return = 'Modify User';
                $id_return = $id;
                $sql = "SELECT * FROM Users WHERE Email='$id'";
                $query = $con->query($sql);
                checkDBquery($con,$sql);
                $result = $query->fetch_assoc();
                $_SESSION['tmp'] = $id_return;
                
                echo "<td><form action='{$page_name}' method='POST' id='modUsrform'> ";            
                $fields = getColumnNames($con,'Users');
                foreach($fields as $field){
                   
                    echo"
                                $field<input class='admin-input' ";
                                if($field=='Email')
                                    echo "type='email'";
                                else
                                    echo "type='text'";
                                    
                                echo "name='$field' value='".$result[$field]."'/><br/>";
                }
                echo "<input class='btn white' type='submit' name='modifyU' value='Accept' />
                <input class='btn white' type='submit' name='modifyU' value='Cancel' /><br/>";

                echo "</form></td>";
                break;


            case 'Add User':
                $action_return = 'Add User';
                $id_return = $id;
                break;


            case 'Cancel':
                break;
            }
        }
        
        if (isset($action_return)) {
            switch ($action_return) {
                case 'Delete Paragraph':
                    $sql = "DELETE FROM Introduction WHERE Id='$id'";
                    logToDB($con,"Deleted Paragraph by ".$_SESSION['email']);
                    checkDBquery($con,$sql);
                    break;

                case 'Delete User':
                    $sql = "DELETE FROM Users WHERE Email='$id_return'";
                    logToDB($con,"Deleted User $id_return by ".$_SESSION['email']);
                    checkDBquery($con,$sql);
                    break;

                case 'Add User':
                    
                    $sql = "INSERT INTO `Users` (`Name`, `Surname`, `Email`, `Password`, `Type`) VALUES ('$adname', '$adsurname', '$ademail', '$adpassword', '$adtype')";
                    echo "Adding: $adname $adsurname, $ademail, $adpassword, $adtype";
                    logToDB($con,"Added User $ademail by ".$_SESSION['email']);
                    checkDBquery($con, $sql);
                    break;
            }
        }

        if (isset($_POST['addI'])) {
                        
            $sql = "INSERT INTO `Introduction` (`Title`, `Content`, `Id`) VALUES(";
            if(isset($_POST['Title'])){
                $sql = $sql . "'". $_POST['Title'] ."' ,";
            }
            $sql = $sql ."'". $_POST['Content'] ."',NULL)";
            logToDB($con,"Added Intro Paragraph by ".$_SESSION['email']);
            checkDBquery($con,$sql);
        }

        if (isset($_POST['modifyI'])) {
            switch ($_POST['modifyI']) {
            case 'Accept':

                $fields = getColumnNames($con,'Introduction');
                $id_return = $_SESSION['tmp'];
                $_SESSION['tmp'] = null;
                $sql = "UPDATE Introduction SET ";
                foreach($fields as $field){
                    if($field != 'Id')
                        $sql = $sql . "$field='" . $_POST[$field] . "' ,";
                }
                $sql = substr($sql, 0, -1);
                $sql = $sql . "WHERE Id='$id_return'";
                $query = $con->query($sql);
                logToDB($con,"Modified Intro Paragraph by ".$_SESSION['email']);
                checkDBquery($con,$sql);
                break;
        
            case 'Cancel':
                break;
            }
        }

        if (isset($_POST['modifyU'])) {
            switch ($_POST['modifyU']) {
            case 'Accept':

                $fields = getColumnNames($con,'Users');
                $id_return = $_SESSION['tmp'];
                $_SESSION['tmp'] = null;
                $sql = "UPDATE Users SET ";
                foreach($fields as $field){
                        $sql = $sql . "$field='" . $_POST[$field] . "' ,";
                }
                $sql = substr($sql, 0, -1);
                $sql = $sql . "WHERE Email='$id_return'";
                $query = $con->query($sql);
                logToDB($con,"Modified User $id_return by ".$_SESSION['email']);
                checkDBquery($con,$sql);
                break;
        
            case 'Cancel':
                break;
            }
        }

        
        
        $sql = "select count(Email) from Users";
        $result = $con->query($sql);
        $row=$result->fetch_array(MYSQLI_NUM);
        $nRows=$row[0];
        $pageSize=600;
        if(isset($_GET['pageSize'])){
            $pageSize=$_GET['pageSize'];
        }
        $page=0;
        if(isset($_GET['page'])){
        $page=$_GET['page'];
        }
        $pos=$page*$pageSize;
        $pos=($pos>$nRows)?$nRows:$pos;
        $sql = "SELECT * FROM Users order by Name";
        $result = $con->query($sql);
	
        if ($result->num_rows > 0) {
        echo "<div class='datagrid'><table>
        <thead><tr>
        <th>Name</th><th>Surname</th><th>Email</th><th>Password(encrypted)</th><th>User Type</th><th>Options</th>
        </tr></thead><tbody>
        ";
        while($row = $result->fetch_assoc()) {
            echo "<tr class='alt'>";
            echo "<td>".$row["Name"]."</td>";
            echo "<td>".$row["Surname"]."</td>";
            echo "<td>".$row["Email"]."</td>";
            echo "<td>".$row["Password"]."</td>";
            echo "<td>".$row["Type"]."</td>";
            echo "<td><form action='ILLENIUMmain.php' method='POST'>
                <input  type='hidden' name='id'  value='{$row['Email']}' />
                <input class='btn orange' type='submit' name='action' value='Modify User' />
                <input class='btn orange' type='submit' name='action' value='Delete User' />
            </form></td>";
            echo "</tr>";
        }
        echo "<tbody></table></div>";
        echo "<br/><td><form action='ILLENIUMmain.php' method='POST'>
                Name<input class='admin-input' type='text' name='adname' required/>
                <br/>Surname<input class='admin-input' type='text' name='adsurname' required/> 
                <br/>Email<input class='admin-input' type='text' name='ademail' required/>
                <br/>Clave<input class='admin-input' type='text' name='adpassword' required/> 
                <br/>Type(admin/shop manager)<input class='admin-input' type='text' name='adtype' required/> 
                <br/><input class='btn white' type='submit' name='action' value='Add User'/>
            </form></td>";
        } else {
            echo "There are no users, did you just delete youself??";
        }
        mysqli_close($con); 
        return array($action_return,$id_return);
        
    }

    function checkActionMusic($id, $action, $page_name){
        echo "<br/>Action: ". $action ."<br/>";

        $action_return=null;
        $id_return=null;

        $adname=isset($_POST['name'])?$_POST['name']:null;
        $adsong=isset($_POST['song'])?$_POST['song']:null;
        $adduration=isset($_POST['duration'])?$_POST['duration']:null;

        $con = dbConnection();

        if (isset($action)){
            switch ($action) {
            case 'Delete Album':
                $action_return = 'Delete Album';
                $id_return = $id;
                break;
        
            case 'Modify Album':
                $action_return = 'Modify Album';
                $id_return = $id;
                $sql = "SELECT * FROM Albums WHERE Name='$id'";
                $query = $con->query($sql);
                checkDBquery($con,$sql);
                $result = $query->fetch_assoc();
                $_SESSION['tmp'] = $id_return;
              
                echo "<td><form action='{$page_name}' method='POST' id='modAlbform'>              
                        <input class='btn white' type='submit' name='modifyA' value='Accept' />
                        <input class='btn white' type='submit' name='modifyA' value='Cancel' /><br/>
                        Title<input type='text' name='Name' value='".$result['Name']."' required/><br/>
                        Image<input type='text' name='Image' value='".$result['Image']."' required/><br/>
                        Price<input type='number' name='Price' value='".$result['Price']."' required/><br/>";

                echo    "</form></td>
                            <textarea rows='5' cols='100' name='Description' form='modAlbform'>".$result['Description']."</textarea>";

                break;


            case 'Add Album':
                $action_return = 'Add Album';
                echo "<td><form action='{$page_name}' method='POST' id='addAlbform'>              
                    <input class='btn white' type='submit' name='addA' value='Add' />
                    <br/>Title<input type='text' name='Name' required/><br/>
                    Image<input type='text' name='Image' required/><br/>
                    Price<input type='number' name='Price' required/><br/>";
    
                echo    "</form></td>
                                <textarea rows='5' cols='100' name='Description' form='addAlbform'></textarea>";
    
                break;




            case 'Delete Song':
                $action_return = 'Delete Song';
                $id_return = $id;
                break;

            case 'Modify Song':
                $action_return = 'Modify Song';
                $id_return = $id;
                $sql = "SELECT * FROM Songs WHERE Song='$id'";
                $query = $con->query($sql);
                checkDBquery($con,$sql);
                $result = $query->fetch_assoc();
                $_SESSION['tmp'] = $id_return;
                
                echo "<td><form action='{$page_name}' method='POST' id='modSngform'> ";            
                $fields = getColumnNames($con,'Songs');
                foreach($fields as $field){
                   
                    echo"
                                $field<input class='admin-input' name='$field' value='".$result[$field]."' required/><br/>";
                }
                echo "<input class='btn white' type='submit' name='modifyS' value='Accept' />
                <input class='btn white' type='submit' name='modifyS' value='Cancel' /><br/>";

                echo "</form></td>";
                break;


            case 'Add Song':
                $action_return = 'Add Song';
                $id_return = $id;
                $_SESSION['tmp']=$_POST['album'];
                echo "<td><form action='{$page_name}' method='POST'>              
                <input class='btn white' type='submit' name='addS' value='Add' />
                <input class='btn white' type='submit' name='addS' value='Cancel' />
                Song<input type='text' name='song' required/><br/>
                Duration<input type='text' name='duration' required/><br/>
                </form></td>";
                break;


            case 'Cancel':
                break;
            }
        }
        
        if (isset($action_return)) {
            switch ($action_return) {
                case 'Delete Album':
                    $sql = "DELETE FROM Albums WHERE Name='$id'";
                    logToDB($con,"Deleted Album by ".$_SESSION['email']);
                    checkDBquery($con,$sql);
                    break;

                case 'Delete Song':
                    $sql = "DELETE FROM Songs WHERE Song='$id_return'";
                    logToDB($con,"Deleted Song $id_return by ".$_SESSION['email']);
                    checkDBquery($con,$sql);
                    break;
            }
        }

        if (isset($_POST['addA'])) {
                        
            $sql = "INSERT INTO `Albums` (`Name`, `Image`, `Description`, `Price`) 
                VALUES('". $_POST['Name'] ."','". $_POST['Image'] ."','". $_POST['Description'] ."','". $_POST['Price'] ."')";
            logToDB($con,"Added Album by ".$_SESSION['email']);
            checkDBquery($con,$sql);
        }

        if (isset($_POST['modifyA'])) {
            switch ($_POST['modifyA']) {
            case 'Accept':

                $fields = getColumnNames($con,'Albums');
                $id_return = $_SESSION['tmp'];
                $_SESSION['tmp'] = null;
                $sql = "UPDATE Albums SET ";
                foreach($fields as $field){
                    $sql = $sql . "$field='" . $_POST[$field] . "' ,";
                }
                $sql = substr($sql, 0, -1);
                $sql = $sql . "WHERE Name='$id_return'";
                $query = $con->query($sql);
                logToDB($con,"Modified Album by ".$_SESSION['email']);
                checkDBquery($con,$sql);
                break;
        
            case 'Cancel':
                break;
            }
        }

        if (isset($_POST['addS'])) {
            switch ($_POST['addS']) {
                case 'Add':
                            
                $sql = "INSERT INTO `Songs` (`Name`, `Song`, `Duration`) VALUES ('".$_SESSION['tmp']."', '$adsong', '$adduration')";
                echo "Adding: ".$_SESSION['tmp']." $adsong, $adduration";
                logToDB($con,"Added Song $adsong by ".$_SESSION['email']);
                checkDBquery($con, $sql);
                $_SESSION['tmp']=null;
                break;
            }
        }

        if (isset($_POST['modifyS'])) {
            switch ($_POST['modifyS']) {
            case 'Accept':

                $fields = getColumnNames($con,'Songs');
                $id_return = $_SESSION['tmp'];
                $_SESSION['tmp'] = null;
                $sql = "UPDATE Songs SET ";
                foreach($fields as $field){
                        $sql = $sql . "$field='" . $_POST[$field] . "' ,";
                }
                $sql = substr($sql, 0, -1);
                $sql = $sql . "WHERE Song='$id_return'";
                $query = $con->query($sql);
                logToDB($con,"Modified Song $id_return by ".$_SESSION['email']);
                checkDBquery($con,$sql);
                break;
        
            case 'Cancel':
                break;
            }
        }
        
        mysqli_close($con); 
        return array($action_return,$id_return);
    }

    function checkActionConcerts($id, $action, $page_name){
        echo "<br/>Action: ". $action ."<br/>";

        $action_return=null;
        $id_return=null;

        $addate=isset($_POST['Date'])?$_POST['Date']:null;
        $adfestival=isset($_POST['Festival'])?$_POST['Festival']:null;
        $adplace=isset($_POST['Place'])?$_POST['Place']:null;

        $con = dbConnection();

        if (isset($action)){
            switch ($action) {

            case 'Delete Concert':
                $action_return = 'Delete Concert';
                $id_return = $id;
                break;

            case 'Modify Concert':
                $action_return = 'Modify Concert';
                $id_return = $id;
                $sql = "SELECT * FROM Concerts WHERE Date='$id'";
                $query = $con->query($sql);
                checkDBquery($con,$sql);
                $result = $query->fetch_assoc();
                $_SESSION['tmp'] = $id_return;
                
                echo "<td><form action='{$page_name}' method='POST' id='modConform'> ";            
                $fields = getColumnNames($con,'Concerts');
                foreach($fields as $field){
                    echo"$field<input class='admin-input' name='$field' value='".$result[$field]."' required/><br/>";
                }
                echo "<input class='btn white' type='submit' name='modifyC' value='Accept' />
                <input class='btn white' type='submit' name='modifyC' value='Cancel' /><br/>";

                echo "</form></td>";
                break;


            case 'Add Concert':
                $action_return = 'Add Concert';
                $id_return = $id;
                echo "<td><form action='{$page_name}' method='POST'>           
                <input class='btn white' type='submit' name='addC' value='Add' />
                <input class='btn white' type='submit' name='addC' value='Cancel' />";
                $fields = getColumnNames($con,'Concerts');
                foreach($fields as $field){
                    echo"$field<input class='admin-input' name='$field' required/><br/>";
                }
                echo "</form></td>";
                break;


            case 'Cancel':
                break;
            }
        }
        
        if (isset($action_return)) {
            switch ($action_return) {

                case 'Delete Concert':
                    $sql = "DELETE FROM Concerts WHERE Date='$id_return'";
                    logToDB($con,"Deleted Concert $id_return by ".$_SESSION['email']);
                    checkDBquery($con,$sql);
                    break;
            }
        }


        if (isset($_POST['addC'])) {
            switch ($_POST['addC']) {
                case 'Add':
                            
                $sql = "INSERT INTO `Concerts` (`Date`, `Festival`, `Place`) VALUES ('$addate', '$adfestival', '$adplace')";
                echo "Adding: ".$_SESSION['tmp']." $addate, $adfestival, $adplace";
                logToDB($con,"Added Concert $addate by ".$_SESSION['email']);
                checkDBquery($con, $sql);
                $_SESSION['tmp']=null;
                break;
            }
        }

        if (isset($_POST['modifyC'])) {
            switch ($_POST['modifyC']) {
            case 'Accept':

                $fields = getColumnNames($con,'Concerts');
                $id_return = $_SESSION['tmp'];
                $_SESSION['tmp'] = null;
                $sql = "UPDATE Concerts SET ";
                foreach($fields as $field){
                        $sql = $sql . "$field='" . $_POST[$field] . "' ,";
                }
                $sql = substr($sql, 0, -1);
                $sql = $sql . "WHERE Date='$id_return'";
                $query = $con->query($sql);
                logToDB($con,"Modified Concert $id_return by ".$_SESSION['email']);
                checkDBquery($con,$sql);
                break;
        
            case 'Cancel':
                break;
            }
        }
        
        mysqli_close($con); 
        return array($action_return,$id_return);
    }

    function getColumnNames($con,$table){
        
        $sql = "SHOW COLUMNS FROM $table";
        $result = mysqli_query($con,$sql);
        $return_array = array();
        while($row = mysqli_fetch_array($result)){
            array_push($return_array, $row['Field']);
        }
        return $return_array;
    }

    function debug_to_console( $data ) {
        $output = $data;
        if ( is_array( $output ) )
            $output = implode( ',', $output);
    
        echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
    }

    function checkDBquery($con,$sql){
        if ($con->query($sql) === TRUE) {
            debug_to_console("DB query succesful: $sql");
        }
        else {
            debug_to_console("Error: " . $sql . "<br />" . $con->error);
        }
    }

    function logToDB($con,$accion){
        $sql="INSERT INTO `Log`(`Date`,`Content`,`Id`) VALUES ('".date("Y-m-d H:i:s")."','$accion',NULL )";
        checkDBquery($con,$sql);
    }

?>