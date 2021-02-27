<?php

$url = "https://vedicscripturesapi.herokuapp.com/gita";

$ch = file_get_contents($url."/chapters");
$chp = json_decode($ch,true);

//var_dump($chp);
//echo count($chp);
$i=0;
for($i=17; $i < count($chp); $i++){
	//echo $chp[$i]["chapter_number"]." ";
	//echo $chp[$i]["verses_count"]."<br/>";

	

	for($vn=0; $vn < $chp[$i]["verses_count"]; $vn++){

		$vurl = $url."/".($i+1)."/".($vn+1);
		//echo $vurl;
		$verse = file_get_contents($vurl);
		$versep = json_decode($verse,true);

		$sloka = $versep["slok"];
		//var_dump($versep);
		


		makedirs($i+1);
		$fp = fopen(($i+1).'/'.($vn+1).'.json', 'w');
		fwrite($fp, ($verse));   // here it will print the array pretty
		fclose($fp);

		makedirs(($i+1).'/'.($vn+1));
		$fp1 = fopen(($i+1).'/'.($vn+1).'/'.($vn+1).'.json', 'w');
		fwrite($fp1, ($sloka));
		fclose($fp1);


		$sloka_html = str_replace("\n", "<br/>", $sloka);

		$html = '<html>

<head>
 <meta charset="utf-8">

</head>

<body>
'.$sloka_html.'

</body>';


		$fp2 = fopen(($i+1).'/'.($vn+1).'/index.html', 'w');
		fwrite($fp2, ($html));
		fclose($fp2);


	}


}

function makedirs($dirpath, $mode=0777) {
    return is_dir($dirpath) || mkdir($dirpath, $mode, true);
}


?>