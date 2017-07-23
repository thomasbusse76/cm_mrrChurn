<?php
require('./vendor/autoload.php');

ChartMogul\Configuration::getDefaultConfiguration()
->setAccountToken('2bb03f684bbc42051654721dfbf34375')
->setSecretKey('3dbbe4120d1328eee0f3fe4a129b96cb');

$mrrChurn =  (ChartMogul\Metrics::mrrChurnRate([
    'start-date'  => '2015-08-01',
    'end-date'    => '2016-08-31',
]));

//converting the object into an array
$mrrChurnEntries = $mrrChurn->toArray()['entries'];

//Sorting the array by churn rate in descending order
usort($mrrChurnEntries, function($a, $b) {
	if ($a['mrr_churn_rate'] == $b['mrr_churn_rate']) {
		return 0;
	}

	return ($a['mrr_churn_rate'] > $b['mrr_churn_rate']) ? -1 : 1;
});

// print the 3 months with the highest Churn rates
echo '<br /><br />The three months with the highest churn rates are:<br /><br />';

for ($x = 0; $x < 3; $x++) {
	$time = strtotime($mrrChurnEntries[$x]["date"]);
	$month = date("F", $time);
	$year = date("Y", $time);
  print_r("-" . $month . " " . $year . " (" . $mrrChurnEntries[$x]["mrr_churn_rate"] . "%) <br />");
}

?>
