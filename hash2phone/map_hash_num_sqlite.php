<?php

$sqlite_path = '/s/o/phones.db';
$db = new SQLite3($sqlite_path);

$time_start = microtime(true);

if (!$_GET['hash']) {

  $res = $db->query('SELECT count(*) FROM map');
  if (!$res) {
    echo 'Err =(';
    exit;
  }

  if ($row = $res->fetchArray()) {
    echo "current: {$row[0]}";
  }

} else {
  $hash = $_GET['hash'];
  $stm = $db->prepare('SELECT phone FROM map WHERE hash = ?');
  $stm->bindValue(1, $hash, SQLITE3_TEXT);
  $res = $stm->execute();

  if (!$res) {
    echo 'Err  =(';
    exit;
  }

  $candidates = $res->fetchArray(SQLITE3_NUM);

  $time_end = microtime(true);
  $time     = $time_end - $time_start;

  echo json_encode(compact('candidates', 'time'));

}
