<?php 
	header("Content-type: image/png");
	include dirname(__FILE__)."/libchart/classes/libchart.php";

	$chart = new PieChart(500, 300);

	$dataSet = new XYDataSet();

	$chart->getPlot()->getPalette()->setBackgroundColor(array(
		new Color(255, 255, 255),
		new Color(255, 255, 255),
		new Color(255, 255, 255),
		new Color(255, 255, 255)
	));

	$chart->getPlot()->getPalette()->setAxisColor(array(
		new Color(255, 255, 255),
		new Color(255, 255, 255)
	));

	if ($_GET) {
  		foreach ($_GET as $key => $value) {
			if ($key != 'chart_title'){
				$dataSet->addPoint(new Point(str_replace("_", " ", "$key"), "$value"));
			}
  		}
	}


	$chart->setDataSet($dataSet);

	$chart->setTitle($_GET[""]);
	$chart->render();
?>