<?php 
	header("Content-type: image/png");
	include dirname(__FILE__)."/libchart/classes/libchart.php";

	if (count($_GET) < 6){
		$width = (count($_GET)) * 150;
	} else {
		$width = 900;
	}

	$chart = new VerticalBarChart($width, 300);

	$chart->getPlot()->getPalette()->setBackgroundColor(array(
		new Color(255, 255, 255),
		new Color(255, 255, 255),
		new Color(255, 255, 255),
		new Color(255, 255, 255)
	));

	$dataSet = new XYDataSet();

	if ($_GET) {
  		foreach ($_GET as $key => $value) {
			if ($key != 'chart_title'){
				$dataSet->addPoint(new Point(str_replace("_", " ", "$key"), "$value"));
			}
  		}
	}


	$chart->setDataSet($dataSet);

	$chart->getPlot()->getPalette()->setBarColor(array(
		new Color(2, 78, 0),
		new Color(148, 170, 36),
		new Color(233, 191, 49),
		new Color(240, 127, 41),
		new Color(243, 63, 34),
		new Color(190, 71, 47),
		new Color(135, 81, 60),
		new Color(128, 78, 162),
		new Color(121, 75, 255),
		new Color(142, 165, 250),
		new Color(162, 254, 239),
		new Color(137, 240, 166),
		new Color(104, 221, 71),
		new Color(98, 174, 35),
		new Color(93, 129, 1)
	));

	$chart->setTitle("");
	$chart->render();
?>