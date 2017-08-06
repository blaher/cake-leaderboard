<?php
  date_default_timezone_set('America/New_York');
  require_once('config.php');

  $endpoint = $config['host'].'/affiliates/api/5/reports.asmx/CampaignSummary';

  $daily_affiliates = array();
  $weekly_affiliates = array();
  $monthly_affiliates = array();
  $yearly_affiliates = array();
  $previous_daily_affiliates = array();
  $previous_weekly_affiliates = array();
  $previous_monthly_affiliates = array();
  $previous_yearly_affiliates = array();
  $lifetime_affiliates = array();

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

    if (isset($array['parent'])) {
      $daily_affiliates[$config['affiliate_ids'][$array['parent']]['name']] += $data->d->summary->revenue;
    } else {
      $daily_affiliates[$array['name']] = $data->d->summary->revenue;
    }
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

    if (isset($array['parent'])) {
      $weekly_affiliates[$config['affiliate_ids'][$array['parent']]['name']] += $data->d->summary->revenue;
    } else {
      $weekly_affiliates[$array['name']] = $data->d->summary->revenue;
    }
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

    if (isset($array['parent'])) {
      $monthly_affiliates[$config['affiliate_ids'][$array['parent']]['name']] += $data->d->summary->revenue;
    } else {
      $monthly_affiliates[$array['name']] = $data->d->summary->revenue;
    }
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

    if (isset($array['parent'])) {
      $yearly_affiliates[$config['affiliate_ids'][$array['parent']]['name']] += $data->d->summary->revenue;
    } else {
      $yearly_affiliates[$array['name']] = $data->d->summary->revenue;
    }
  }

  // Previous Daily
  foreach ($config['affiliate_ids'] as $affiliate_id=>$array) {
    $params = array(
      'api_key' => $array['api_key'],
      'affiliate_id' => $affiliate_id,
      'start_date' => date('m/d/Y 00:00:00', strtotime('-1 day')),
      'end_date' => date('m/d/Y 00:00:00'),
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

    if (isset($array['parent'])) {
      $previous_daily_affiliates[$config['affiliate_ids'][$array['parent']]['name']] += $data->d->summary->revenue;
    } else {
      $previous_daily_affiliates[$array['name']] = $data->d->summary->revenue;
    }
  }

  // Previous Weekly
  $day = date('w');
  foreach ($config['affiliate_ids'] as $affiliate_id=>$array) {
    $params = array(
      'api_key' => $array['api_key'],
      'affiliate_id' => $affiliate_id,
      'start_date' => date('m/d/Y 00:00:00', strtotime('-'.($day+7).' days')),
      'end_date' => date('m/d/Y 00:00:00', strtotime('-'.$day.' days')),
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

    if (isset($array['parent'])) {
      $previous_weekly_affiliates[$config['affiliate_ids'][$array['parent']]['name']] += $data->d->summary->revenue;
    } else {
      $previous_weekly_affiliates[$array['name']] = $data->d->summary->revenue;
    }
  }

  // Previous Monthly
  foreach ($config['affiliate_ids'] as $affiliate_id=>$array) {
    $params = array(
      'api_key' => $array['api_key'],
      'affiliate_id' => $affiliate_id,
      'start_date' => date('m/01/Y 00:00:00', strtotime('-1 month')),
      'end_date' => date('m/01/Y 00:00:00'),
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

    if (isset($array['parent'])) {
      $previous_monthly_affiliates[$config['affiliate_ids'][$array['parent']]['name']] += $data->d->summary->revenue;
    } else {
      $previous_monthly_affiliates[$array['name']] = $data->d->summary->revenue;
    }
  }

  // Previousl Yearly
  foreach ($config['affiliate_ids'] as $affiliate_id=>$array) {
    $params = array(
      'api_key' => $array['api_key'],
      'affiliate_id' => $affiliate_id,
      'start_date' => date('01/01/Y 00:00:00', strtotime('-1 year')),
      'end_date' => date('01/01/Y 00:00:00'),
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

    if (isset($array['parent'])) {
      $previous_yearly_affiliates[$config['affiliate_ids'][$array['parent']]['name']] += $data->d->summary->revenue;
    } else {
      $previous_yearly_affiliates[$array['name']] = $data->d->summary->revenue;
    }
  }

  // Lifetime
  foreach ($config['affiliate_ids'] as $affiliate_id=>$array) {
    $params = array(
      'api_key' => $array['api_key'],
      'affiliate_id' => $affiliate_id,
      'start_date' => date('01/01/1969 00:00:00'),
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

    if (isset($array['parent'])) {
      $lifetime_affiliates[$config['affiliate_ids'][$array['parent']]['name']] += $data->d->summary->revenue;
    } else {
      $lifetime_affiliates[$array['name']] = $data->d->summary->revenue;
    }
  }

  arsort($daily_affiliates);
  arsort($weekly_affiliates);
  arsort($monthly_affiliates);
  arsort($yearly_affiliates);
  arsort($previous_daily_affiliates);
  arsort($previous_weekly_affiliates);
  arsort($previous_monthly_affiliates);
  arsort($previous_yearly_affiliates);
  arsort($lifetime_affiliates);
?>

<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

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
            text: ''
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

      options.series = [{
          name: 'Affiliates',
          colorByPoint: true,
          data: [
            <?php foreach ($previous_daily_affiliates as $name=>$amount): ?>
              {
                name: '<?php echo $name; ?>',
                y: <?php echo $amount; ?>
              },
            <?php endforeach; ?>
          ]
      }];
      Highcharts.chart('previous_daily_graph', options);

      options.series = [{
          name: 'Affiliates',
          colorByPoint: true,
          data: [
            <?php foreach ($previous_weekly_affiliates as $name=>$amount): ?>
              {
                name: '<?php echo $name; ?>',
                y: <?php echo $amount; ?>
              },
            <?php endforeach; ?>
          ]
      }];
      Highcharts.chart('previous_weekly_graph', options);

      options.series = [{
          name: 'Affiliates',
          colorByPoint: true,
          data: [
            <?php foreach ($previous_monthly_affiliates as $name=>$amount): ?>
              {
                name: '<?php echo $name; ?>',
                y: <?php echo $amount; ?>
              },
            <?php endforeach; ?>
          ]
      }];
      Highcharts.chart('previous_monthly_graph', options);

      options.series = [{
          name: 'Affiliates',
          colorByPoint: true,
          data: [
            <?php foreach ($previous_yearly_affiliates as $name=>$amount): ?>
              {
                name: '<?php echo $name; ?>',
                y: <?php echo $amount; ?>
              },
            <?php endforeach; ?>
          ]
      }];
      Highcharts.chart('previous_yearly_graph', options);

      options.series = [{
          name: 'Affiliates',
          colorByPoint: true,
          data: [
            <?php foreach ($lifetime_affiliates as $name=>$amount): ?>
              {
                name: '<?php echo $name; ?>',
                y: <?php echo $amount; ?>
              },
            <?php endforeach; ?>
          ]
      }];
      Highcharts.chart('lifetime_graph', options);
    });
  </script>

  <title>Cake Leaderboard</title>
</head>

<body>

<div class="container">
  <div class="row">
    <div class="col-sm-12 col-md-6">
      <h1>Daily</h1>
      <ol>
        <?php foreach ($daily_affiliates as $name=>$amount): ?>
          <li><strong><?php echo $name; ?></strong> - $<?php echo number_format($amount); ?></li>
        <?php endforeach; ?>
        <li><strong>Ben Sandy</strong> - $0</li>
      </ol>
    </div>
    <div class="col-sm-12 col-md-6">
      <div id="daily_graph" style="height:200px"></div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <h1>Yesterday</h1>
      <ol>
        <?php foreach ($previous_daily_affiliates as $name=>$amount): ?>
          <li><strong><?php echo $name; ?></strong> - $<?php echo number_format($amount); ?></li>
        <?php endforeach; ?>
        <li><strong>Ben Sandy</strong> - $0</li>
      </ol>
    </div>
    <div class="col-sm-12 col-md-6">
      <div id="previous_daily_graph" style="height:200px"></div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <h1>Weekly</h1>
      <ol>
        <?php foreach ($weekly_affiliates as $name=>$amount): ?>
          <li><strong><?php echo $name; ?></strong> - $<?php echo number_format($amount); ?></li>
        <?php endforeach; ?>
        <li><strong>Ben Sandy</strong> - $0</li>
      </ol>
    </div>
    <div class="col-sm-12 col-md-6">
      <div id="weekly_graph" style="height:200px"></div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <h1>Last Week</h1>
      <ol>
        <?php foreach ($previous_weekly_affiliates as $name=>$amount): ?>
          <li><strong><?php echo $name; ?></strong> - $<?php echo number_format($amount); ?></li>
        <?php endforeach; ?>
        <li><strong>Ben Sandy</strong> - $0</li>
      </ol>
    </div>
    <div class="col-sm-12 col-md-6">
      <div id="previous_weekly_graph" style="height:200px"></div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <h1>Monthly</h1>
      <ol>
        <?php foreach ($monthly_affiliates as $name=>$amount): ?>
          <li><strong><?php echo $name; ?></strong> - $<?php echo number_format($amount); ?></li>
        <?php endforeach; ?>
        <li><strong>Ben Sandy</strong> - $0</li>
      </ol>
    </div>
    <div class="col-sm-12 col-md-6">
      <div id="monthly_graph" style="height:200px"></div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <h1>Last Month</h1>
      <ol>
        <?php foreach ($previous_monthly_affiliates as $name=>$amount): ?>
          <li><strong><?php echo $name; ?></strong> - $<?php echo number_format($amount); ?></li>
        <?php endforeach; ?>
      </ol>
    </div>
    <div class="col-sm-12 col-md-6">
      <div id="previous_monthly_graph" style="height:200px"></div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <h1>Yearly</h1>
      <ol>
        <?php foreach ($yearly_affiliates as $name=>$amount): ?>
          <li><strong><?php echo $name; ?></strong> - $<?php echo number_format($amount); ?></li>
        <?php endforeach; ?>
      </ol>
    </div>
    <div class="col-sm-12 col-md-6">
      <div id="yearly_graph" style="height:200px"></div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <h1>Last Year</h1>
      <ol>
        <?php foreach ($previous_yearly_affiliates as $name=>$amount): ?>
          <li><strong><?php echo $name; ?></strong> - $<?php echo number_format($amount); ?></li>
        <?php endforeach; ?>
      </ol>
    </div>
    <div class="col-sm-12 col-md-6">
      <div id="previous_yearly_graph" style="height:200px"></div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-12 col-md-6">
      <h1>Lifetime</h1>
      <ol>
        <?php foreach ($lifetime_affiliates as $name=>$amount): ?>
          <li><strong><?php echo $name; ?></strong> - $<?php echo number_format($amount); ?></li>
        <?php endforeach; ?>
      </ol>
    </div>
    <div class="col-sm-12 col-md-6">
      <div id="lifetime_graph" style="height:200px"></div>
    </div>
  </div>
</div>

</body></html>
