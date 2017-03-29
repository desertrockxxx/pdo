<!--
Die PHP Data Objects-Erweiterung (PDO) stellt eine leichte, 
konsistente Schnittstelle bereit, um mit PHP auf Datenbanken zuzugreifen. 
Jeder Datenbanktreiber, der die PDO-Schnittstelle implementiert, 
kann spezifische Features als reguläre Funktionen der Erweiterung bereitstellen. 
Beachten Sie, dass Sie keine Funktionen der Datenbank mit PDO allein benutzen können. 
Sie müssen einen datenbankspezifischen PDO-Treiber benutzen, 
um auf eine Datenbank zuzugreifen. 
-->
<html>
<head>
    <link rel="stylesheet" href="/js/jquery.js" type="text/css" />
</head>

<?php
// PDO Verbindungsdaten
$dsn = "mysql:host=localhost;dbname=c9";
$user = "markschuster";
$pass = "";
// Ein assoziatives Array daraus machen
$options = array(
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // Nur für die Entwicklung verwenden (Sendet Fehlermeldungen aus)
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
    );

// Verbindung testen
try {
    $db = new PDO($dsn, $user, $pass, $options);
    // Wenn erfolgreich, gebe aus und spiele ab
    echo "Verbindung erfolgreich";
?> 
    <!-- Erfolgreich Song-->
    <audio autoplay preload="metadata" style=" width:300px;">
	<source src="/Cockatiel-sings.mp3" type="audio/mpeg">
	Your browser does not support the audio element.
    </audio><br />
    <!-- Erfolgreich Image-->
    <img src="/giphy.gif" width="200px"></img>
    
<?php    
// Wenn fehlerhaft, gebe den Fehler aus
} catch(PDOException $e){
    echo "Fehler: " . $e->getMessage();
}

// In $stmt speichern und aus der Datenbank Infos rausgreifen, sinnvoll benennen
$stmt = $db->query("SELECT autor AS Buchautor, titel AS Buchtitel, isbn AS ISBN, preis AS Preis FROM buecher");
?>
<pre>
    <?php var_dump($stmt->fetchAll());?>
</pre>




<body>

</body>
</html>