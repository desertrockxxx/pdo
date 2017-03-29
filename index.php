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
    <title>Buchliste</title>
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
    // PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
    );

// Verbindung testen
try {
    $db = new PDO($dsn, $user, $pass, $options);
    // Wenn erfolgreich, gebe aus und spiele ab
    // echo "Verbindung erfolgreich";
?> 
    <!-- Erfolgreich Song-->
 <!--   <audio autoplay preload="metadata" style=" width:300px;">-->
	<!--<source src="audio/Cockatiel-sings.mp3" type="audio/mpeg">-->
	<!--Your browser does not support the audio element.-->
 <!--   </audio><br />-->
    <!-- Erfolgreich Image-->
 <!--   <img src="img/giphy.gif" width="200px"></img>-->
    
<?php    
// Wenn fehlerhaft, gebe den Fehler aus
} catch(PDOException $e){
    echo "Fehler: " . $e->getMessage();
}



// In $stmt speichern und aus der Datenbank Infos rausgreifen, sinnvoll benennen
$stmt = $db->query("SELECT id, autor AS Buchautor, titel AS Buchtitel, isbn AS ISBN, preis AS Preis FROM buecher");
$buecher = $stmt->fetchAll();

// Datensätze in Formular ausgeben, Editieren eines Datensatzes ermöglichen, wenn edit geklickt
if(isset($_REQUEST['edit'])){

    $id = $_REQUEST['id'];
    $db->query("SELECT * FROM buecher WHERE id = " . $id);
    $einzelBuchArray = $stmt->fetchAll();
}

// aendern geklickt, dann 
if(isset($_REQUEST['aendern'])){
   
    $id = $_REQUEST['id'];
    $titel = $_REQUEST['titel'];
    $autor = $_REQUEST['autor'];
    $isbn = $_REQUEST['isbn'];
    $preis = $_REQUEST['preis'];
    
    
    // intval($id) weil eine Datenbank immer String zurückgibt, deswegen Umwandlung in int
    $stmt = $db->query("UPDATE buecher SET titel = '" . $titel . "', autor ='" . $autor . "', isbn ='" . $isbn . "', preis ='" . $preis . "' WHERE id = '" . intval($id) ."'");
}


// Löschen eines Datensatzes, wenn X geklickt
// Wenn delete aufgerufen wird und delete=true gesetzt ist, dann lösche id
if(isset($_REQUEST['delete'])){
    
    $titel = $_POST['titel'];
    $autor = $_POST['autor'];
    $isbn = $_POST['isbn'];
    $preis =$_POST['preis'];
    
    $db->query("DELETE FROM buecher WHERE id = " . $_REQUEST['id']);
}


// Wenn Hinzuefugen geklickt und Buchtitel nicht leer, dann in DB übergeben
if(isset($_POST['hinzufuegen']) && !empty($_POST['titel']))
{
    $titel = $_POST['titel'];
    $autor = $_POST['autor'];
    $isbn = $_POST['isbn'];
    $preis =$_POST['preis'];
    
    $db->query("INSERT INTO buecher (titel, autor, isbn, preis)
    VALUES ('$titel', '$autor', '$isbn', '$preis') ");
}


?>

<body>

<h2>Buecherliste</h2>
<table border="1px">
    <thead>
        <tr>
            <th>Buchtitel</th>
            <th>Buchautor</th>
            <th>ISBN</th>
            <th>Preis</th>
            <th>Loeschen</th>
            <th>Editieren</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($buecher as $buch) { ?>
        <tr>
            <td> <?php echo $buch['Buchtitel'];?></td>
            <td> <?php echo $buch['Buchautor'];?></td>
            <td> <?php echo $buch['ISBN'];?></td>
            <td> <?php echo $buch['Preis'];?></td>
            <td><a href="index.php?delete=true&id=<?php echo $buch['id'];?>">x</a></td>
            <td><a href="index.php?edit=true&id=<?php echo $buch['id'];?>">edit</a></td>
        <?php } ?>
        </tr>
    </tbody>
</table>

<h2>Hinzufuegen/Aendern eines neuen Buches</h2>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
    <div>
        <input type="text" name="titel" value="<?php if(isset($_REQUEST['edit'])) echo $einzelBuchArray[0]['titel']; ?>" placeholder="Buchtitel"/>
    </div>
    <div>
        <input type="text" name="autor" value="<?php if(isset($_REQUEST['edit'])) echo $einzelBuchArray[0]['autor']; ?>" placeholder="Autor"/>
    </div>
    <div>
        <input type="text" name="isbn" value="<?php if(isset($_REQUEST['edit'])) echo $einzelBuchArray[0]['isbn']; ?>" placeholder="ISBN"/>
    </div>
    <div>
        <input type="text" name="preis" value="<?php if(isset($_REQUEST['edit'])) echo $einzelBuchArray[0]['preis']; ?>" placeholder="Preis (12.23)"/>
    </div>
    <div>
    <?php if(isset($_REQUEST['edit'])) { ?>
        
        <input type="submit" name="aendern" value="Speichern"/>
        <input type="hidden" name="id" value="<?php  echo $_REQUEST['id']; ?>"/>
    <?php } else { ?>
        <input type="submit" name="hinzufuegen" value="Buch hinzufuegen"/>
    <?php } ?>    
    </div>
</form>


</body>
</html>