<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Uspesna prijava</title>
</head>
<body><?php
include 'funkcije.php';
include 'database-methods.php';


if(1==1){
    echo "ta mail ne obstaja";
    ?>
    <form action="get-prijava-stranka.php" method="get">
		<input type="hidden" name="napacna_prijava" value = "fnedskf"> 
	 
		<input type="submit" value="Poiskusi ponovno">
    </form>
    <?php
   
}



?>
</body>
</html>
