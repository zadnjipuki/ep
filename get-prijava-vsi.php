<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Prijava strank</title>
</head>
<body>
Izpolnite spodnji obrazec za prijavo<br>
<?php 
    $funkcija = $_GET["funkcija"];
    echo $funkcija;

?>
<br>
	<form action="get-proces-prijava-stranka.php" method="get">
		Email <input type="text" name="email"> 
		Geslo <input type="text" name="geslo" />
                <input type="hidden"  name="funkcija" value ="<?= $funkcija ?>"/>
		<input type="submit" value="Prijavi se">
	</form>

        <form action="poiskus.php" method="get">
		
		Le zacasno<input type="submit" value="Klikni">
	</form>

        
</body>
</html>