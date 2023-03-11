<?php
	//zpracování dat kurzovního lístku
    $target_url = 'https://www.cnb.cz/cs/financni-trhy/devizovy-trh/kurzy-devizoveho-trhu/kurzy-devizoveho-trhu/denni_kurz.txt';
    $rawText = file_get_contents($target_url);
    $rawText = explode("\n", $rawText);
    $hlavicky = $rawText[1];
    $hlavicky = explode("|", $hlavicky);
    $data = [];
    for($i = 2; $i < count($rawText); $i++) {
		$obj;
    	$rowData = explode("|", $rawText[$i]);
        for($j = 0; $j < count($hlavicky); $j++) {
        	$obj[$hlavicky[$j]] = $rowData[$j];
        }
      	array_push($data, $obj);
	}
    //extrahování kurzu AUD
    $kurz_aud = $data[0]["kurz"];
    $kurz_aud = str_replace(',', '.', $kurz_aud);
	//výpočet ceny v AUD
	$money = (float) $kurz_aud;
	$cena_v_aud = number_format((float)($_POST["cena"] / $money), 2, ".", " ");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Rekapitulace</title>
		<link rel="stylesheet" href="styles.css">
	</head>
	<body>
		<div class="container tableback">
			<header>
				<h1 id="title-recap">Rekapitulace</h1>
			</header>
			<table>
				<tr id="jmeno">
					<td>Jméno:</td> 
					<td><?php
					echo $_POST["firstname"];
					?></td>
				</tr>
				<tr id="prijmeni">
					<td>Příjmení:</td>
					<td><?php 
					echo $_POST["lastname"];
					?></td>
				</tr>
				<tr id="email">
					<td>Email:</td>
					<td><?php 
					echo $_POST["email"];
					?></td>
				</tr>
				<tr id="tel">
					<td>Telefon:</td>
					<td><?php
					echo $tel = number_format($_POST["telefon"], 0, ",", " ");
					?></td>
				</tr>
				<tr id="dat_nar">
					<td>Datum narození:</td>
					<td><?php
					echo $_POST["dat_nar"];
					?></td>
				</tr>
				<tr id="produkt">
					<td>Produkt:</td>
					<td><?php 
					echo $_POST["produkt"];
					?></td>
				</tr>
				<tr id="ks">
					<td>Počet kusů:</td>
					<td><?php
					echo $_POST["kusy"];
					?></td>
				</tr>
				<tr id="cena_s_dph">
					<td>Cena bez DPH:</td>
					<td><?php
					$cena_bez_dph = $_POST["cena"] - ($_POST["cena"] * 0.21);
					echo $cena_bez_dph_sep = number_format($cena_bez_dph, 0, ".", " ") . " Kč";
					?></td>
				</tr>
				<tr id="dph">
					<td>DPH (21%):</td>
					<td><?php
					$dph = ($_POST["cena"] * 0.21);
					echo $dph_sep = number_format($dph, 0, ".", " ") . " Kč";
					?></td>
				</tr>
				<tr id="cena_bez_dph">
					<td>Cena s DPH:</td>
					<td><?php
					$cena_s_dph = $_POST["cena"];
					echo $cena_s_dph_sep = number_format($cena_s_dph, 0, '.', ' ') . " Kč";
					?></td>
				</tr>
				<tr id="Cena_v_AUD">
					<td>Cena v AUD:</td>
					<td><?php
					echo $cena_v_aud;
					?>
				<tr id="AUD">
					<td>Současný kurz 1AUD =</td>
					<td><?php
					echo $money . " Kč";
					?></td>
				</tr>
			</table>
		</div>
	</body>
</html>
