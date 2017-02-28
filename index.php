<?php
  require_once('config.php');

  $endpoint = $config['host'].'/affiliates/api/5/reports.asmx/CampaignSummary';

  $affiliates = array();

  foreach ($config['affiliate_ids'] as $affiliate_id) {
    $params = array(
      'api_key' => $config['api_key'],
      'affiliate_id' => $affiliate_id,
      'start_date' => date('m/01/Y 00:00:00'),
      'end_date' => date('m/01/Y 00:00:00', strtotime('+1 month')),
      'sub_affiliate' => '',
      'conversion_type' => 'all',
      'start_at_row' => 1,
      'row_limit' => 1,
      'sort_field' => 'offer_id',
      'sort_descending' => 'FALSE'
    );
    $params = json_encode($params);

    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length: '.strlen($params)
    ));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = json_decode(curl_exec($ch));
    curl_close($ch);

    $affiliates[$affiliate_id] = array(
      'name' => '',
      'revenue' => $data->d->summary->revenue
    );
  }

  var_dump($affiliates);
