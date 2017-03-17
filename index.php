<?php
  require_once('config.php');

  $endpoint = $config['host'].'/affiliates/api/5/reports.asmx/CampaignSummary';

  $weekly_affiliates = array();
  $monthly_affiliates = array();
  $yearly_affiliates = array();

  // Weekly
  $day = date('w');
  foreach ($config['affiliate_ids'] as $affiliate_id=>$array) {
    $params = array(
      'api_key' => $array['api_key'],
      'affiliate_id' => $affiliate_id,
      'start_date' => date('m/d/Y 00:00:00', strtotime('-'.$day.' days')),
      'end_date' => date('m/d/Y 00:00:00', strtotime('+1 month')),
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

    $weekly_affiliates[$array['name']] = $data->d->summary->revenue;
  }

  // Monthly
  foreach ($config['affiliate_ids'] as $affiliate_id=>$array) {
    $params = array(
      'api_key' => $array['api_key'],
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

    $monthly_affiliates[$array['name']] = $data->d->summary->revenue;
  }

  // Yearly
  foreach ($config['affiliate_ids'] as $affiliate_id=>$array) {
    $params = array(
      'api_key' => $array['api_key'],
      'affiliate_id' => $affiliate_id,
      'start_date' => date('01/01/Y 00:00:00'),
      'end_date' => date('01/01/Y 00:00:00', strtotime('+1 year')),
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

    $yearly_affiliates[$array['name']] = $data->d->summary->revenue;
  }

  arsort($monthly_affiliates);
  arsort($yearly_affiliates);
?>

<html><body>

<h1>Weekly</h1>
<ol>
  <?php foreach ($weekly_affiliates as $name=>$amount): ?>
    <li><?php echo $name; ?></li>
  <?php endforeach; ?>
</ol>

<h1>Monthly</h1>
<ol>
  <?php foreach ($monthly_affiliates as $name=>$amount): ?>
    <li><?php echo $name; ?></li>
  <?php endforeach; ?>
</ol>

<h1>Yearly</h1>
<ol>
  <?php foreach ($yearly_affiliates as $name=>$amount): ?>
    <li><?php echo $name; ?></li>
  <?php endforeach; ?>
</ol>

</body></html>
