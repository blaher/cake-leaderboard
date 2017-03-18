<?php
  date_default_timezone_set('America/New_York');
  require_once('config.php');

  $endpoint = $config['host'].'/affiliates/api/5/reports.asmx/CampaignSummary';

  $weekly_affiliates = array();
  $monthly_affiliates = array();
  $yearly_affiliates = array();

  // Daily
  foreach ($config['affiliate_ids'] as $affiliate_id=>$array) {
    $params = array(
      'api_key' => $array['api_key'],
      'affiliate_id' => $affiliate_id,
      'start_date' => date('m/d/Y 00:00:00'),
      'end_date' => date('m/d/Y 00:00:00', strtotime('+1 day')),
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

    $daily_affiliates[$array['name']] = $data->d->summary->revenue;
  }

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

  arsort($daily_affiliates);
  arsort($weekly_affiliates);
  arsort($monthly_affiliates);
  arsort($yearly_affiliates);
?>

<html>
<head>
  <script
    src="https://code.jquery.com/jquery-3.2.0.min.js"
    integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I="
    crossorigin="anonymous"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>

  <script>
    $(document).ready(function(){
      var options = {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Daily'
        },
        plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                  enabled: true,
                  format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                  style: {
                      color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                  }
              }
          }
        }
      };

      options.series = [{
          name: 'Affiliates',
          colorByPoint: true,
          data: [
            <?php foreach ($daily_affiliates as $name=>$amount): ?>
              {
                name: '<?php echo $name; ?>',
                y: <?php echo $amount; ?>
              },
            <?php endforeach; ?>
          ]
      }];
      Highcharts.chart('daily_graph', options);

      options.series = [{
          name: 'Affiliates',
          colorByPoint: true,
          data: [
            <?php foreach ($weekly_affiliates as $name=>$amount): ?>
              {
                name: '<?php echo $name; ?>',
                y: <?php echo $amount; ?>
              },
            <?php endforeach; ?>
          ]
      }];
      Highcharts.chart('weekly_graph', options);

      options.series = [{
          name: 'Affiliates',
          colorByPoint: true,
          data: [
            <?php foreach ($monthly_affiliates as $name=>$amount): ?>
              {
                name: '<?php echo $name; ?>',
                y: <?php echo $amount; ?>
              },
            <?php endforeach; ?>
          ]
      }];
      Highcharts.chart('monthly_graph', options);

      options.series = [{
          name: 'Affiliates',
          colorByPoint: true,
          data: [
            <?php foreach ($yearly_affiliates as $name=>$amount): ?>
              {
                name: '<?php echo $name; ?>',
                y: <?php echo $amount; ?>
              },
            <?php endforeach; ?>
          ]
      }];
      Highcharts.chart('yearly_graph', options);
    });
  </script>
</head>

<body>

<h1>Daily</h1>
<ol>
  <?php foreach ($daily_affiliates as $name=>$amount): ?>
    <li><strong><?php echo $name; ?></strong> - $<?php echo number_format($amount); ?></li>
  <?php endforeach; ?>
</ol>
<div id="daily_graph"></div>

<h1>Weekly</h1>
<ol>
  <?php foreach ($weekly_affiliates as $name=>$amount): ?>
    <li><strong><?php echo $name; ?></strong> - $<?php echo number_format($amount); ?></li>
  <?php endforeach; ?>
</ol>
<div id="weekly_graph"></div>

<h1>Monthly</h1>
<ol>
  <?php foreach ($monthly_affiliates as $name=>$amount): ?>
    <li><strong><?php echo $name; ?></strong> - $<?php echo number_format($amount); ?></li>
  <?php endforeach; ?>
</ol>
<div id="monthly_graph"></div>

<h1>Yearly</h1>
<ol>
  <?php foreach ($yearly_affiliates as $name=>$amount): ?>
    <li><strong><?php echo $name; ?></strong> - $<?php echo number_format($amount); ?></li>
  <?php endforeach; ?>
</ol>
<div id="yearly_graph"></div>

</body></html>
