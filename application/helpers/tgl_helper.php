<?php

// mengubah tgl format mySql menjadi dd-mm-yyyy
function dd_mm_yyyy($string)
{
	$pch 	= explode("-",$string);
	$format	= $pch[2]."-".$pch[1]."-".$pch[0];

	return $format;
}

function tgl_sql($string)
{
	$tgl = substr($string,0,2);
	$bln = substr($string,3,2);
	$thn = substr($string,6,4);

	return $thn."-".$bln."-".$tgl;
}

function tgl($string, $datetime = false, $timeonly = false)
{
	$tgl = substr($string,8,2);
	$bln = substr($string,5,2);
	$thn = substr($string,0,4);

	if($string > 0 && $thn != '0000')
	{
		if($datetime == true)
			$time = substr($string, 11);

		if($datetime == true && $timeonly == true)
			return $time;
		else
			return $tgl."-".$bln."-".$thn . ($datetime == true && $timeonly == false ? $time : '');
	}
}

// mengubah tgl format mySql menjadi dd Januari yyyy
function tgl_indo($string = null)
{
	if($string != null)
	{
		$tgl = substr($string,8,2);
		$bln = substr($string,5,2);
		$thn = substr($string,0,4);

		if($bln != '00')
		{
			switch($bln)
			{
				case "01" :
					$bulan = "Januari";
				break;

				case "02" :
					$bulan = "Februari";
				break;

				case "03" :
					$bulan = "Maret";
				break;

				case "04" :
					$bulan = "April";
				break;
				case "05" :
					$bulan = "Mei";
				break;

				case "06" :
					$bulan = "Juni";
				break;

				case "07" :
					$bulan = "Juli";
				break;

				case "08" :
					$bulan = "Agustus";
				break;

				case "09" :
					$bulan = "September";
				break;

				case "10" :
					$bulan = "Oktober";
				break;

				case "11" :
					$bulan = "November";
				break;

				case "12" :
					$bulan = "Desember";
				break;
			}

			return $tgl." ".$bulan." ".$thn;
		}
		else
		{
			return '-';
		}
	}
	else
	{
		return '-';
	}
}

function bulan_indo($string)
{
	$string = (strlen($string) == '1') ? '0'. $string : $string;

	switch($string)
	{
		case "01" :
			return "Januari";
		break;

		case "02" :
			return "Februari";
		break;

		case "03" :
			return "Maret";
		break;

		case "04" :
			return "April";
		break;
		case "05" :
			return "Mei";
		break;

		case "06" :
			return "Juni";
		break;

		case "07" :
			return "Juli";
		break;

		case "08" :
			return "Agustus";
		break;

		case "09" :
			return "September";
		break;

		case "10" :
			return "Oktober";
		break;

		case "11" :
			return "November";
		break;

		case "12" :
			return "Desember";
		break;
	}

	return $bulan;
}

function bulan($string)
{
	$string = (strlen($string) == '1') ? '0'. $string : $string;

	switch($string)
	{
		case "01" :
			return "JAN";
		break;

		case "02" :
			return "FEB";
		break;

		case "03" :
			return "MAR";
		break;

		case "04" :
			return "APR";
		break;
		case "05" :
			return "MEI";
		break;

		case "06" :
			return "JUN";
		break;

		case "07" :
			return "JUL";
		break;

		case "08" :
			return "AGT";
		break;

		case "09" :
			return "SEP";
		break;

		case "10" :
			return "OKT";
		break;

		case "11" :
			return "NOV";
		break;

		case "12" :
			return "DES";
		break;
	}

	return $bulan;
}

// validasi ,  bahwa format tanggal harus yyyy-mm-dd atau dd-mm-yyyy
function validasi_format_tgl($string, $tipe='dmy')
{
	if ($tipe == 'dmy')
		$pola = '/^\d{2}+\-\d{2}\-\d{4}$/';
	elseif ($tipe == 'ymd')
		$pola = '/^\d{4}+\-\d{2}\-\d{2}$/';

	if ( ! preg_match($pola, $string))
		die('Unknown date value or format in a parameters that you\'re send');

}

function drop_bulan($text = '- Pilih bulan', $min = null, $max = null)
{
	if($text != null)
		$bulan[''] 	= $text;

	$min = ($min == null) ? '1' : $min;
	$max = ($max == null) ? '12' : $max;

	for($i = $min; $i <= $max; $i++)
	{
		$bln 			= (strlen($i) == '1') ? '0'. $i : $i;
		$bulan[$bln] 	= bulan_indo($bln);
	}

	return $bulan;
}

function hitung_umur($tgl)
{
	$pecah1 	= explode("-", $tgl);
	$date1 		= $pecah1[2];
	$month1 	= $pecah1[1];
	$year1 		= $pecah1[0];
	// memecah string tanggal akhir untuk mendapatkan

	// tanggal, bulan, tahun
	$pecah2 	= explode("-", date('Y-m-d'));
	$date2 		= $pecah2[2];
	$month2 	= $pecah2[1];
	$year2 		= $pecah2[0];

	// mencari total selisih hari dari tanggal awal dan akhir
	$jd1 = GregorianToJD($month1, $date1, $year1);
	$jd2 = GregorianToJD($month2, $date2, $year2);

	$selisih = $jd2 - $jd1;

	$tahun 	= (int)($selisih/365);
	$bulan 	= (int)(($selisih%365)/30);
	$hari 	= ($selisih%365)%30;

	$tahun 	= $tahun == 0 ? '' : $tahun.' tahun ';
	$bulan 	= $bulan == 0 ? '' : $bulan.' bulan ';

	return $tahun.$bulan.$hari.' hari';
}



?>
