<?php
date_default_timezone_set('Asia/Jakarta');


$data = '15:00:00';

$now = strtotime('today');
//echo strtotime('now');// this outputs 1446820684
//echo $dataTimestamp; //this outputs 1954886400
//echo $data; //this outputs 31-12-13

//if $data is empty

if (empty($data)){
echo 'no results';
}
//if $data is not empty but date is less than today
elseif (!empty($data) && $data <= '11:00:00'  && $data >= '00:00:00') {
echo 'first';
}elseif (!empty($data) && $data >= '12:00:00' && $data <= '13:59:59') {
  echo 'mid';
}elseif (!empty($data) && $data >= '14:00:00' && $data <= '23:59:59') {
  echo 'last';
}
//everything else
else {
echo 'active';
}
