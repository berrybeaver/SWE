<?php
include ("hilf_funktionen.php");

/**
 * Verbindung zur Datenbank erstellt.
 */
$link = connect_db();

/**
 * Ermöglichen von speziellen Zeichen.
 */
if (!$link->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $link->error);
}

/**
 * variable setzen
 */
$daten =
    [
        'title' => $_POST['title'] ?? NULL,
        'datum_start' => $_POST['datum_start'] ?? NULL,
        'uhrzeit_start' => $_POST['uhrzeit_start'] ?? NULL,
        'ort' => $_POST['ort'] ?? NULL,
        'datum_ende' => $_POST['datum_ende'] ?? NULL,
        'uhrzeit_ende' => $_POST['uhrzeit_ende'] ?? NULL,
        'teilnehmer' => $_POST['teilnehmer'] ?? NULL,
        'technik' => $_POST['technik'] ?? NULL
    ];
$title = $_POST['title'] ?? NULL;
$datum_s = $_POST['datum_start'] ?? NULL;
$zeit_s = $_POST['uhrzeit_start'] ?? NULL;
$ort = $_POST['ort'] ?? NULL;
$datum_e = $_POST['datum_ende'] ?? NULL;
$zeit_e = $_POST['uhrzeit_ende'] ?? NULL;
$teilnehmer = $_POST['teilnehmer'] ?? NULL;
$technik = $_POST['technik'] ?? NULL;

/**
 * Bedingungen
 */
$check = 0;
$error_message = "";
if(!empty($title) && !empty($datum_s) && !empty($zeit_s) && !empty($ort)
&& !empty($datum_e) && !empty($zeit_e) && !empty($teilnehmer) && !empty($technik)){
    $sql_termin_check = "SELECT * FROM `swe-d7`.termin";
    $sql_start_date_check = "SELECT start_d FROM `swe-d7`.termin";
    $sql_end_date_check = "SELECT end_d FROM `swe-d7`.termin";
    //Inhalt prüfen
    $result_termin_check = mysqli_query($link, $sql_termin_check);
    $result_start_date_check = mysqli_query($link, $sql_start_date_check);
    $result_end_date_check = mysqli_query($link, $sql_end_date_check);
    while ($row_termin_check = mysqli_fetch_assoc($result_termin_check)){
        //if start date in between already existing termin
        $new_startDate = $datum_s;
        $new_endDate = $datum_e;
        $new_startDate = date('d/m/Y', strtotime($new_startDate));
        $startDate = date('d/m/Y', strtotime($result_start_date_check));
        $endDate = date('d/m/Y', strtotime($result_end_date_check));
        if((($new_startDate >= $startDate) && ($new_startDate <= $endDate)) ||
            ($new_endDate)){
            echo "fehler";
        }else{
            if ($new_startDate == $endDate){
                //check time
                while($row_termin_check2 = mysqli_fetch_assoc($result_termin_check)) {
                    if ($zeit_s > $row_termin_check2['end_t'] ){
                        echo "fehler";
                    } else{
                        $check =1;
                    }
                }
            }
        }
        //if end date in between already existing termin
        //if teilnehmer have a termin already in between date
        //if technik have a termin already in between date
    }

}

/**
 * zu DB einfügen
 */
if($check){
    termin_hinzufuegen($title, $datum_s, $zeit_s, $ort, $datum_e, $zeit_e, $teilnehmer, $technik);

}



?>

<!--
<script type="text/JavaScript">
    function createNewElement() {
        // First create a DIV element.
        var txtNewInputBox = document.createElement('div');

        // Then add the content (a new input box) of the element.
        txtNewInputBox.innerHTML = "<input type='text' class='teilnehmer'>";

        // Finally put it where it is supposed to appear.
        document.getElementById("ma1").appendChild(txtNewInputBox);
    }

</script>
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../CSS/termin-hinzufügen.css">
    <link rel="stylesheet" href="../CSS/style-header-general.css">
    <link rel="stylesheet" href="../CSS/style-footer.css">

    <link rel="prev" href="login.php">
    <title>Neuer Termin erstellen</title>
</head>
<body>

<?php include('../vorlagen/header-homepage.php') ?>

<div>
    <form method="post" action="termin-hinzufügen.php">
        <fieldset class="t_add">
            <table>
                <thead>Neuer Termin:</thead>
                <tr>
                    <td>
                        <label class="titel" for="title">Titel:</label>
                    </td>
                    <td>
                        <input type="text" name="title" placeholder="Eingabe" maxlength="220" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="datum_start" for="datum_start">Datum (Start):</label>
                    </td>
                    <td>
                        <input type="text" name="datum_start" placeholder="Eingabe" maxlength="220" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="uhrzeit_start" for="uhrzeit_start">Uhrzeit (start):</label>
                    </td>
                    <td>
                        <input type="text" name="uhrzeit_start" placeholder="Eingabe" maxlength="220" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="ort" for="ort">Ort:</label>
                    </td>
                    <td>
                        <input type="text" name="ort" placeholder="Eingabe" maxlength="220" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="datum_ende" for="datum_ende">Datum (ende):</label>
                    </td>
                    <td>
                        <input type="text" name="title" placeholder="Eingabe" maxlength="220" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="uhrzeit_ende" for="uhrzeit_ende">Uhrzeit (ende):</label>
                    </td>
                    <td>
                        <input type="text" name="uhrzeit_ende" placeholder="Eingabe" maxlength="220" required>
                    </td>
                </tr>
                <tr>
                        <td>
                            <label class="teilnehmer" for="teilnehmer">Teilnehmer:</label>
                        </td>
                        <td>
                            <input class="teilnehmer" type="text" name="teilnehmer" placeholder="Eingabe" required>
                    <!--
                        </td>
                        <td>
                            <div id="dynamicCheck">
                                <input class="teilnehmer" type="button" value="+" onclick="createNewElement();"/>
                            </div>
                        </td>
                    </div>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div id="ma1">-->
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="technik" for="technik">Technik:</label>
                    </td>
                    <td>
                        <input type="text" name="technik" placeholder="Eingabe" required>
                    </td>
                </tr>
            </table>
        </fieldset>
        <div>
            <button class="action" type="submit" name="action" value="speichern">Speichern</button>
            <button class="action" type="submit" name="action" value="abbrechen">Abbrechen</button>
        </div>
    </form>

</div>
<?php var_dump($check)?>

<?php include('../vorlagen/footer.html') ?>

</body>
</html>