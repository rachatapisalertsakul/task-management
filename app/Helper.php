<?php
function DateThai($strDate)
{
	$strYear = date("Y", strtotime($strDate)) + 543;
	$strMonth = date("n", strtotime($strDate));
	$strDay = date("j", strtotime($strDate));
	$strHour = date("H", strtotime($strDate));
	$strMinute = date("i", strtotime($strDate));
	$strSeconds = date("s", strtotime($strDate));
	$strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
	$strMonthThai = $strMonthCut[$strMonth];
	$strtime  = date("H:i:s", strtotime($strDate));
	return "$strDay  $strMonthThai  $strYear เวลา $strtime น.";
}

function get_order_no($id, $year)
{
	$no = str_pad($id, 5, '0', STR_PAD_LEFT);
	$order_no =  'SL' . date("Y", strtotime($year)) . '-' . $no;

	return $order_no;
}


function DateThaiNotime($strDate)
{
	$strYear = date("Y", strtotime($strDate)) + 543;
	$strMonth = date("n", strtotime($strDate));
	$strDay = date("j", strtotime($strDate));
	$strHour = date("H", strtotime($strDate));
	$strMinute = date("i", strtotime($strDate));
	$strSeconds = date("s", strtotime($strDate));
	$strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
	$strMonthThai = $strMonthCut[$strMonth];
	return " $strDay $strMonthThai $strYear";
}


function formatcurrency($floatcurr, $curr = "THB")
{
	$currencies['ARS'] = array(2, ',', '.');          //  Argentine Peso
	$currencies['AMD'] = array(2, '.', ',');          //  Armenian Dram
	$currencies['AWG'] = array(2, '.', ',');          //  Aruban Guilder
	$currencies['AUD'] = array(2, '.', ' ');          //  Australian Dollar
	$currencies['BSD'] = array(2, '.', ',');          //  Bahamian Dollar
	$currencies['BHD'] = array(3, '.', ',');          //  Bahraini Dinar
	$currencies['BDT'] = array(2, '.', ',');          //  Bangladesh, Taka
	$currencies['BZD'] = array(2, '.', ',');          //  Belize Dollar
	$currencies['BMD'] = array(2, '.', ',');          //  Bermudian Dollar
	$currencies['BOB'] = array(2, '.', ',');          //  Bolivia, Boliviano
	$currencies['BAM'] = array(2, '.', ',');          //  Bosnia and Herzegovina, Convertible Marks
	$currencies['BWP'] = array(2, '.', ',');          //  Botswana, Pula
	$currencies['BRL'] = array(2, ',', '.');          //  Brazilian Real
	$currencies['BND'] = array(2, '.', ',');          //  Brunei Dollar
	$currencies['CAD'] = array(2, '.', ',');          //  Canadian Dollar
	$currencies['KYD'] = array(2, '.', ',');          //  Cayman Islands Dollar
	$currencies['CLP'] = array(0, '', '.');           //  Chilean Peso
	$currencies['CNY'] = array(2, '.', ',');          //  China Yuan Renminbi
	$currencies['COP'] = array(2, ',', '.');          //  Colombian Peso
	$currencies['CRC'] = array(2, ',', '.');          //  Costa Rican Colon
	$currencies['HRK'] = array(2, ',', '.');          //  Croatian Kuna
	$currencies['CUC'] = array(2, '.', ',');          //  Cuban Convertible Peso
	$currencies['CUP'] = array(2, '.', ',');          //  Cuban Peso
	$currencies['CYP'] = array(2, '.', ',');          //  Cyprus Pound
	$currencies['CZK'] = array(2, '.', ',');          //  Czech Koruna
	$currencies['DKK'] = array(2, ',', '.');          //  Danish Krone
	$currencies['DOP'] = array(2, '.', ',');          //  Dominican Peso
	$currencies['XCD'] = array(2, '.', ',');          //  East Caribbean Dollar
	$currencies['EGP'] = array(2, '.', ',');          //  Egyptian Pound
	$currencies['SVC'] = array(2, '.', ',');          //  El Salvador Colon
	$currencies['ATS'] = array(2, ',', '.');          //  Euro
	$currencies['BEF'] = array(2, ',', '.');          //  Euro
	$currencies['DEM'] = array(2, ',', '.');          //  Euro
	$currencies['EEK'] = array(2, ',', '.');          //  Euro
	$currencies['ESP'] = array(2, ',', '.');          //  Euro
	$currencies['EUR'] = array(2, ',', '.');          //  Euro
	$currencies['FIM'] = array(2, ',', '.');          //  Euro
	$currencies['FRF'] = array(2, ',', '.');          //  Euro
	$currencies['GRD'] = array(2, ',', '.');          //  Euro
	$currencies['IEP'] = array(2, ',', '.');          //  Euro
	$currencies['ITL'] = array(2, ',', '.');          //  Euro
	$currencies['LUF'] = array(2, ',', '.');          //  Euro
	$currencies['NLG'] = array(2, ',', '.');          //  Euro
	$currencies['PTE'] = array(2, ',', '.');          //  Euro
	$currencies['GHC'] = array(2, '.', ',');          //  Ghana, Cedi
	$currencies['GIP'] = array(2, '.', ',');          //  Gibraltar Pound
	$currencies['GTQ'] = array(2, '.', ',');          //  Guatemala, Quetzal
	$currencies['HNL'] = array(2, '.', ',');          //  Honduras, Lempira
	$currencies['HKD'] = array(2, '.', ',');          //  Hong Kong Dollar
	$currencies['HUF'] = array(0, '', '.');           //  Hungary, Forint
	$currencies['ISK'] = array(0, '', '.');           //  Iceland Krona
	$currencies['INR'] = array(2, '.', ',');          //  Indian Rupee
	$currencies['IDR'] = array(2, ',', '.');          //  Indonesia, Rupiah
	$currencies['IRR'] = array(2, '.', ',');          //  Iranian Rial
	$currencies['JMD'] = array(2, '.', ',');          //  Jamaican Dollar
	$currencies['JPY'] = array(0, '', ',');           //  Japan, Yen
	$currencies['JOD'] = array(3, '.', ',');          //  Jordanian Dinar
	$currencies['KES'] = array(2, '.', ',');          //  Kenyan Shilling
	$currencies['KWD'] = array(3, '.', ',');          //  Kuwaiti Dinar
	$currencies['LVL'] = array(2, '.', ',');          //  Latvian Lats
	$currencies['LBP'] = array(0, '', ' ');           //  Lebanese Pound
	$currencies['LTL'] = array(2, ',', ' ');          //  Lithuanian Litas
	$currencies['MKD'] = array(2, '.', ',');          //  Macedonia, Denar
	$currencies['MYR'] = array(2, '.', ',');          //  Malaysian Ringgit
	$currencies['MTL'] = array(2, '.', ',');          //  Maltese Lira
	$currencies['MUR'] = array(0, '', ',');           //  Mauritius Rupee
	$currencies['MXN'] = array(2, '.', ',');          //  Mexican Peso
	$currencies['MZM'] = array(2, ',', '.');          //  Mozambique Metical
	$currencies['NPR'] = array(2, '.', ',');          //  Nepalese Rupee
	$currencies['ANG'] = array(2, '.', ',');          //  Netherlands Antillian Guilder
	$currencies['ILS'] = array(2, '.', ',');          //  New Israeli Shekel
	$currencies['TRY'] = array(2, '.', ',');          //  New Turkish Lira
	$currencies['NZD'] = array(2, '.', ',');          //  New Zealand Dollar
	$currencies['NOK'] = array(2, ',', '.');          //  Norwegian Krone
	$currencies['PKR'] = array(2, '.', ',');          //  Pakistan Rupee
	$currencies['PEN'] = array(2, '.', ',');          //  Peru, Nuevo Sol
	$currencies['UYU'] = array(2, ',', '.');          //  Peso Uruguayo
	$currencies['PHP'] = array(2, '.', ',');          //  Philippine Peso
	$currencies['PLN'] = array(2, '.', ' ');          //  Poland, Zloty
	$currencies['GBP'] = array(2, '.', ',');          //  Pound Sterling
	$currencies['OMR'] = array(3, '.', ',');          //  Rial Omani
	$currencies['RON'] = array(2, ',', '.');          //  Romania, New Leu
	$currencies['ROL'] = array(2, ',', '.');          //  Romania, Old Leu
	$currencies['RUB'] = array(2, ',', '.');          //  Russian Ruble
	$currencies['SAR'] = array(2, '.', ',');          //  Saudi Riyal
	$currencies['SGD'] = array(2, '.', ',');          //  Singapore Dollar
	$currencies['SKK'] = array(2, ',', ' ');          //  Slovak Koruna
	$currencies['SIT'] = array(2, ',', '.');          //  Slovenia, Tolar
	$currencies['ZAR'] = array(2, '.', ' ');          //  South Africa, Rand
	$currencies['KRW'] = array(0, '', ',');           //  South Korea, Won
	$currencies['SZL'] = array(2, '.', ', ');         //  Swaziland, Lilangeni
	$currencies['SEK'] = array(2, ',', '.');          //  Swedish Krona
	$currencies['CHF'] = array(2, '.', '\'');         //  Swiss Franc 
	$currencies['TZS'] = array(2, '.', ',');          //  Tanzanian Shilling
	$currencies['THB'] = array(2, '.', ',');          //  Thailand, Baht
	$currencies['TOP'] = array(2, '.', ',');          //  Tonga, Paanga
	$currencies['AED'] = array(2, '.', ',');          //  UAE Dirham
	$currencies['UAH'] = array(2, ',', ' ');          //  Ukraine, Hryvnia
	$currencies['USD'] = array(2, '.', ',');          //  US Dollar
	$currencies['VUV'] = array(0, '', ',');           //  Vanuatu, Vatu
	$currencies['VEF'] = array(2, ',', '.');          //  Venezuela Bolivares Fuertes
	$currencies['VEB'] = array(2, ',', '.');          //  Venezuela, Bolivar
	$currencies['VND'] = array(0, '', '.');           //  Viet Nam, Dong
	$currencies['ZWD'] = array(2, '.', ' ');          //  Zimbabwe Dollar




	if ($curr == "INR") {
		return formatinr($floatcurr);
	} else {
		return number_format($floatcurr, $currencies[$curr][0], $currencies[$curr][1], $currencies[$curr][2]);
	}
}




function get_type($id)
{
	$name = (DB::table('asset_type')->where('id_type', $id)->first())->name;
	return $name;
}

function get_branch($id)
{
	$name_branch = (DB::table('branch')->where('id_branch', $id)->first())->name_branch;
	return $name_branch;
}

function get_status($id)
{
	$status = DB::table('tbl_status')->where('id_status', $id)->first();
	return $status->name_status;
}

function get_color_status($id)
{
	$status = DB::table('tbl_status')->where('id_status', $id)->first();
	return $status->color;
}

function get_order_fix_no($id)
{
	$no = str_pad($id, 5, '0', STR_PAD_LEFT);
	$order_no =  'FL' . $no;

	return $order_no;
}

function get_order_count_no($id)
{
	$no = str_pad($id, 5, '0', STR_PAD_LEFT);
	$order_no =  'CL' . $no;

	return $order_no;
}

function round_to2dp($value){
	return number_format((float)$value, 2, '.', '');
}

function recheck_permission(){
	$_SESSION['permission'] = DB::table('user_permission')->where('ref_id_user', $_SESSION['id'])->pluck('ref_id_permission')->toArray();
}
