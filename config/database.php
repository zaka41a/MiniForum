<?php
use PDO;

return function(array $cfg): PDO {
  return new PDO(
    $cfg['db']['dsn'],
    $cfg['db']['user'],
    $cfg['db']['pass'],
    $cfg['db']['options']
  );
};
