<?php
  function myencrypt($value)
    {
    if(!$value){return false;}

    $key = 'aNdRgUkXp2s5v8y/B?E(H+MbQeShVmYq';

    $text = $value;
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv);

    return trim(base64_encode($crypttext));
   }

  function mydecrypt($value)
    {
    if(!$value) {return false;}

    $key = 'aNdRgUkXp2s5v8y/B?E(H+MbQeShVmYq';

    $crypttext = base64_decode($value);
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $crypttext, MCRYPT_MODE_ECB, $iv);

    return trim($decrypttext);
   }

   /*for run
      $encrypted = myencrypt($text);
      $decrypted = mydecrypt($encrypted);
   */
?>
