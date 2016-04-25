function makePass($word=''){
  $dbSalt = '$2a$07$'.substr(hash('whirlpool',$word),0,22);
  $dbPass = crypt($word, $dbSalt);
 return substr($dbPass,12);
}