<?php

function strip_zeros_from_date( $marked_string="" ) {
  // first remove the marked zeros
  $no_zeros = str_replace('*0', '', $marked_string);
  // then remove any remaining marks
  $cleaned_string = str_replace('*', '', $no_zeros);
  return $cleaned_string;
}

function l_zero($num){
  return ($num >= 10) ? $num : "0" . $num;
}

function redirect_to( $location = NULL ) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

function output_message($message="") {
  if (!empty($message)) { 
    return "<p class=\"message\">{$message}</p>";
  } else {
    return "";
  }
}

function stripped_text($str, $len){
  if(strlen($str) <= $len)
    return $str;
  else{
    return substr($str, 0, $len - 3) . "...";
  }
}

function nicetime($date){
  if(empty($date)) {
      return "No date provided";
  }

  $unix_date = strtotime($date);
    
  //    // check validity of date
  // if(empty($unix_date)) {    
  //     return "Bad date";
  // }

  return date("M d, Y", $unix_date);
}
function remTime($date)
{
    if(empty($date)) {
        return "No date provided";
    }
    
    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths         = array("60","60","24","7","4.35","12","10");
    
    $now             = time();
    $unix_date       = strtotime($date);
    
       // check validity of date
    if(empty($unix_date)) {    
        return "Bad date";
    }

    // is it future date or past date
    if($now > $unix_date) {    
        $difference     = $now - $unix_date;
        $tense         = "ago";
        
    } else {
        $difference     = $unix_date - $now;
        $tense         = "from now";
    }
    
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
    
    $difference = round($difference);
    
    if($difference != 1) {
        $periods[$j].= "s";
    }
    
    return "$difference $periods[$j] {$tense}";
}

function get_random_id($records){
  $ids = array();

  foreach ($records as $record) {
    $ids[] = $record->id;
  }

  return $ids[array_rand($ids)];
}

function include_layout_template($template="") {
  include(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$template);
}

function RGBToHSL($RGB) {
  // $r = 0xFF & ($RGB >> 0x10);
  // $g = 0xFF & ($RGB >> 0x8);
  // $b = 0xFF & $RGB;
  $r = $RGB[0];
  $g = $RGB[1];
  $b = $RGB[2];

  $r = ((float)$r) / 255.0;
  $g = ((float)$g) / 255.0;
  $b = ((float)$b) / 255.0;

  $maxC = max($r, $g, $b);
  $minC = min($r, $g, $b);

  $l = ($maxC + $minC) / 2.0;

  if($maxC == $minC)
  {
    $s = 0;
    $h = 0;
  }
  else
  {
    if($l < .5)
    {
      $s = ($maxC - $minC) / ($maxC + $minC);
    }
    else
    {
      $s = ($maxC - $minC) / (2.0 - $maxC - $minC);
    }
    if($r == $maxC)
      $h = ($g - $b) / ($maxC - $minC);
    if($g == $maxC)
      $h = 2.0 + ($b - $r) / ($maxC - $minC);
    if($b == $maxC)
      $h = 4.0 + ($r - $g) / ($maxC - $minC);

    $h = $h / 6.0; 
  }

  $h = (int)round(255.0 * $h);
  $s = (int)round(255.0 * $s);
  $l = (int)round(255.0 * $l);

  return (object) Array('hue' => $h, 'saturation' => $s, 'lightness' => $l);
}
?>