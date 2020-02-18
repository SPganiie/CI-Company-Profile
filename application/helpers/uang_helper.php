<?php

// mengubah inputan menjadi angka saja .ex : 1.000.000 => 1000000
function ubah_jadi_angka($string)
{
  $uang = preg_replace("/[^0-9]/", "", $string);

  return $uang;
}

// mengubah angka menjadi format indonesia . ex : Rp 1.000.000
function uang_separator($string)
{
  $nilaiRupiah  = "";
  $jumlahAngka  = strlen($string);
  while($jumlahAngka > 3)
  {
    $nilaiRupiah = ".".substr($string,-3).$nilaiRupiah;
    $sisaNilai   = strlen($string) - 3;
    $string      = substr($string,0,$sisaNilai);
    $jumlahAngka = strlen($string);
  }

  $nilaiRupiah       = $string.$nilaiRupiah;
  return $nilaiRupiah;
}

// mengubah angka menjadi format indonesia . ex : Rp 1.000.000
function uang_indo($string, $cur = true)
{
  $nilaiRupiah	= "";
  $jumlahAngka	= strlen($string);
  while($jumlahAngka > 3)
  {
    $nilaiRupiah = ".".substr($string,-3).$nilaiRupiah;
    $sisaNilai   = strlen($string) - 3;
    $string      = substr($string,0,$sisaNilai);
    $jumlahAngka = strlen($string);
  }

  $nilaiRupiah       = "Rp ". $string.$nilaiRupiah.",-";
  return $nilaiRupiah;
}

function cur_rp($val = null, $cur = true)
{
  if($val == null)
    return '0';

  $hsl  = number_format($val, 2, ',', '.');

  return ($cur == true ? 'Rp ' : '') . $hsl;
}

?>
