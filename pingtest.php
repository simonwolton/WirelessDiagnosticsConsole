<?php
$host="221.181.104.12";
exec("ping -c 1 " . $host, $output, $result);
if ($result == 0)
{
	echo ("<br><br>");
	preg_match("/time=(\d*)/", $output[1], $pingLatency);
	echo ("<br><br>");
	if ($pingLatency > 200)
		echo "The target is latent!";
	else
		echo "Latency was " . $pingLatency[1] . "ms. Doesn't look latent!";
}
else echo "Cannot connect";
?>