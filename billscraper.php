<?php
  $chambers = array("senate", "house", "both");
  $query = "https://api.propublica.org/congress/v1/115/";
  $results = [];
  // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
  function getApi ($chamber, $datquery) {
    $ch = curl_init();
    $fullquery = $datquery . $chamber . "/bills/major.json";
    curl_setopt($ch, CURLOPT_URL, $_ENV["datquery"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);


    $headers = array();
    $headers[] = "X-Api-Key: ng7dbvmURF4yv9GxugL0Z5y61GWWeL2Kawb5zb4P";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close ($ch);
    return $results;
  }
  foreach ($chambers as $chamberiteration) {
    $json = json_decode(getApi ($chamberiteration, $query), true);
    for ($i = 0; $i < count($json['results']['bills']); $i++) {
      $location = $json['results']['bills'][$i];
      $repeat = False;
      foreach ($location as $billcheck) {
        if ($billcheck['number'] == $location[$i]['number']) {
          $repeat = True;
        }
      }
      if ($repeat == False) {
        $results[] = array($location['number'], $location['title'], $location['last_major_action'], $location['last_major_action_date']);
      }
    }
  }
  echo '<pre>'; print_r($results); echo '</pre>';
?>
