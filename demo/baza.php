<?
$mysql_host = "sql.globmedia.home.pl";
$mysql_database = "globmedia3";
$mysql_user = "globmedia3";
$mysql_password = "vPhPRDsR0^eDL@Bnl3@HJ%Th";

$connection = mysql_connect($mysql_host, $mysql_user, $mysql_password);
mysql_select_db($mysql_database);

mysql_query("set collation_connection=utf8_bin");
mysql_query("set character set utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");
mysql_query("set character_set_database=utf8");
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_server=utf8");
mysql_query("set collation_database=utf8_bin");
mysql_query("set collation_server=utf8_bin"); 

$adres_ip = getenv('REMOTE_ADDR');

/*

<?php
function send_sms ($sms_do, $sms_tresc){//get
	$username = 'globmedia';                          //login z konta SMSAPI
	$password = '2a023d3a4d298e4d6f092c93b423b5b9';                     //lub $password="ciąg md5"
	$to = $sms_do;                            //numer odbiorcy
	//$from = 'SMSAPI';                           //nazwa nadawcy musi być aktywna
	$message = urlencode($sms_tresc);       //treść wiadomości
	$url = 'https://ssl.smsapi.pl/sms.do';
	$c = curl_init();
	curl_setopt($c, CURLOPT_URL, $url);
	curl_setopt($c, CURLOPT_POST, true);
	curl_setopt($c, CURLOPT_POSTFIELDS, 'username='.$username.'&password='.$password.'&to='.$to.'&message='.$message.'&eco=1');
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true); 
	$content = curl_exec($c);
	curl_close($c); 
	echo $content;
}
//dla rap xls
//EDIT YOUR MySQL Connection Info:
$DB_Server = "sql.globmedia.home.pl";        //your MySQL Server
$DB_Username = "globmedia19";                 //your MySQL User Name
$DB_Password = "vPhPRDsR0^eDL@Bnl3@HJ%Th";                //your MySQL Password
$DB_DBName = "globmedia19";                //your MySQL Database Name

//data 120 dni
	$dni120 = ' + 120 days';
	$dni127 = ' + 127 days';
	//$dolicz120 = date('d.m.Y', strtotime($_SESSION['d'].$dni120 ));//wyswietlana
	$dolicz120 = '31.10.2013';//wyswietlana
	//$dolicz120_dodaj_s_d = date('Y-m-d', strtotime($_SESSION['d'].$dni120 ));//do obliczen old
	//$dolicz120_plus7_sklep = date('Y-m-d', strtotime($_SESSION['d'].$dni127 ));//do obliczen old
	$dolicz120_dodaj_s_d = '2013-10-31';//do obliczen
	$dolicz120_plus7_sklep = '2013-11-07';//do obliczen
	$dzis_jest = date('Y-m-d');//do obliczen
	//flagi daty
	if($dolicz120_dodaj_s_d<$dzis_jest){$flaga120dnii='0';}else{$flaga120dnii='1';}//data rejestracja 120
	if($dolicz120_plus7_sklep<$dzis_jest){$flaga120dni_plus7='0';}else{$flaga120dni_plus7='1';}//data rejestracja 120
	
	//$flaga120dnii='1';//dodac przeliczenie
	//$flaga120dni_plus7='1';//dodac przeliczenie
	//daty weryfikacji
	//dzień tyg
	$dzis_dzien_tyg = date('l');
	$dzis_jest2 = date('d.m.Y H:i');
	
	if($dzis_dzien_tyg=='Friday'){
		$dni2 = ' + 3 days';
		$dni_1 = ' - 1 days';
		$stan_na_raw = date('d.m.Y H:i', strtotime($dzis_jest2)-16*3600);
		$stan_next_akt_raw = date('d.m.Y H:i', strtotime($dzis_jest2.$dni2));
		
	}elseif($dzis_dzien_tyg=='Saturday'){
		$dni_1 = ' - 1 days';
		$dni2 = ' + 2 days';
		$stan_na_raw = date('d.m.Y H:i', strtotime($dzis_jest2.$dni_1));
		$stan_next_akt_raw = date('d.m.Y H:i', strtotime($dzis_jest2.$dni2));
		
	}elseif($dzis_dzien_tyg=='Sunday'){
		$dni_1 = ' - 2 days';
		$dni2 = ' + 1 days';
		$stan_na_raw = date('d.m.Y H:i', strtotime($dzis_jest2.$dni_1));
		$stan_next_akt_raw = date('d.m.Y H:i', strtotime($dzis_jest2.$dni2));
	}else{
		$dni1 = ' + 1 days';
		$stan_na_raw = date('d.m.Y H:i', strtotime($dzis_jest2)-16*3600);
		$stan_next_akt_raw = date('d.m.Y H:i', strtotime($dzis_jest2.$dni1)-16*3600);
	}
	
	Monday
	Tuesday
	Wednesday
	Thursday
	Friday
	Saturday
	Sunday
	
	
	$stan_na = substr($stan_na_raw, 0, 10);
	$stan_next_akt = substr($stan_next_akt_raw, 0, 10);
//data

//pula id//28, 137, 90, 138, 10, 35, 72, 128, 38, 70, 132, 74, 27, 86, 37, 43, 71, 62
$gabarytowe = array("28", "137", "90", "138", "10", "35", "72", "128", "38", "70", "132", "74", "27", "86", "37", "43", "71", "62");
?>
*/