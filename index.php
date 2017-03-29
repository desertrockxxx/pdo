<?php
/*
Die PHP Data Objects-Erweiterung (PDO) stellt eine leichte, 
konsistente Schnittstelle bereit, um mit PHP auf Datenbanken zuzugreifen. 
Jeder Datenbanktreiber, der die PDO-Schnittstelle implementiert, 
kann spezifische Features als reguläre Funktionen der Erweiterung bereitstellen. 
Beachten Sie, dass Sie keine Funktionen der Datenbank mit PDO allein benutzen können. 
Sie müssen einen datenbankspezifischen PDO-Treiber benutzen, 
um auf eine Datenbank zuzugreifen. 
*/
$dsn = "mysql:host=localhost;dbname=c9";
$user = "markschuster";
$pass = "";

try {
    $db = new PDO($dsn, $user, $pass);
    echo "Verbindung erfolgreich";
} catch(PDOException $e) {
    echo "Fehler: " . $e->getMessage();
}


?>
<html>
<head>
    
</head>
<body>



</body>
</html>