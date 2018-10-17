    <form action="curl.php" method="post">
        Keyword <input type="text" name="keyword" value="<?php echo ((isset($_POST['keyword']))?$_POST['keyword']:"") ?>"> <br>
        <input type="Submit" name="formSubmit" value="Search">
    </form>
    
<?php
if(isset($_POST['formSubmit']))
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://bencore.ugr.es/iii/encore/search");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $st = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
    $response = curl_exec($ch);
    if($st==200)
       echo "Request Unsuccessful";
    else
    {
        if (strpos($response,$_POST['keyword']) !== false)
        {
            echo 'Your input keyword found.';
        }
        else
            echo 'No matches, try another keyword';
    }
    curl_close($ch);
}
?>

<!--http://bencore.ugr.es/iii/encore/Home,
$Search.form.sdirect?formids=target&lang=spi&suite=def&reservedids=lang%2Csuite
&submitmode=&submitname=&target=Learning+PHP&submit.x=0&submit.y=0-->
