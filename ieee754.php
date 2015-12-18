<?php
	// Ejercicio basado en https://en.wikipedia.org/wiki/Single-precision_floating-point_format
	// <img class="mwe-math-fallback-image-inline tex" alt="= (-1)^\text{sign}(1.b_{22}b_{21}...b_{0})_2 \times 2^{e-127}" src="//upload.wikimedia.org/math/a/d/0/ad0e49bef104fe3b4140dfa885a47cb2.png">
	// <img class="mwe-math-fallback-image-inline tex" alt="\text{value} = (-1)^\text{sign}\left(1 + \sum_{i=1}^{23} b_{23-i} 2^{-i} \right)\times 2^{(e-127)}" src="//upload.wikimedia.org/math/5/b/6/5b6995dd974771cb8fe63f3a4908d351.png">

	function echo_array ($a) {
		for ($i = 31; $i >= 0; $i--) {
			echo ($a [$i] == 0)? "0" : "1";
		}
	}

	function array_ieee754 ($bit) {
		$f = 1;
		for ($i = 0; $i < 23; $i++) {
			$f += bit ($bit[22 - $i], $i);
		}
		$e = 0;
		for ($i = 0; $i < 8; $i++) {
			$e += $bit[$i + 23] * pow ( 2, $i );
		}
		$f *= pow (2, $e - 127);
		if ($bit[31] == 1) {
			$f *= -1;
		}
		return ($f);
	}

	function bit($nro, $i) {
		return ($nro * pow (2, ($i + 1) * -1));
	}

	function ieee754_array ($nro) {
		$aux = array (
			 0 => 0.00000011920928955078125,
			 1 => 0.0000002384185791015625,
			 2 => 0.000000476837158203125,
			 3 => 0.00000095367431640625,
			 4 => 0.0000019073486328125,
			 5 => 0.000003814697265625,
			 6 => 0.00000762939453125,
			 7 => 0.0000152587890625,
			 8 => 0.000030517578125,
			 9 => 0.00006103515625,
			10 => 0.0001220703125,
			11 => 0.000244140625,
			12 => 0.00048828125,
			13 => 0.0009765625,
			14 => 0.001953125,
			15 => 0.00390625,
			16 => 0.0078125,
			17 => 0.015625,
			18 => 0.03125,
			19 => 0.0625,
			20 => 0.125,
			21 => 0.25,
			22 => 0.5
		);
		$bit = array (
			 0 => 0,
			 1 => 0,
			 2 => 0,
			 3 => 0,
			 4 => 0,
			 5 => 0,
			 6 => 0,
			 7 => 0,
			 8 => 0,
			 9 => 0,
			10 => 0,
			11 => 0,
			12 => 0,
			13 => 0,
			14 => 0,
			15 => 0,
			16 => 0,
			17 => 0,
			18 => 0,
			19 => 0,
			20 => 0,
			21 => 0,
			22 => 0,
			23 => 0,
			24 => 0,
			25 => 0,
			26 => 0,
			27 => 0,
			28 => 0,
			29 => 0,
			30 => 0,
			31 => 0
		);
		if ($nro < 0) {
			$bit[31] = 1;
			$nro *= -1;
		}
		$m = $nro;
		$e = 0;
		while (($e < 128) && $m < 1) {
			$e++;
			$m = $nro / pow (2, $e * -1);
		}
		$e = 127 - $e;
		$m -= 1;
		for ($i = 0; $i < 8; $i++) {
			$bit[$i + 23] = $e % 2;
			$e = intval ($e / 2);
		}
		for ($i = 0; $i < 23; $i++) {
			if ($m >= $aux[22 - $i]) {
				$bit[22 - $i] = 1;
				$m -= $aux[22 - $i];
			}
		}
		return ($bit);
	}

	$a = array (
		 0 => 0,
		 1 => 0,
		 2 => 0,
		 3 => 0,
		 4 => 0,
		 5 => 0,
		 6 => 0,
		 7 => 0,
		 8 => 0,
		 9 => 0,
		10 => 0,
		11 => 0,
		12 => 0,
		13 => 0,
		14 => 0,
		15 => 0,
		16 => 0,
		17 => 0,
		18 => 0,
		19 => 0,
		20 => 0,
		21 => 0,
		22 => 0,
		23 => 0,
		24 => 0,
		25 => 0,
		26 => 0,
		27 => 0,
		28 => 0,
		29 => 0,
		30 => 0,
		31 => 0
	);
	if (isset($_GET['numero'])) {
		$nro = $_GET['numero'];
		for ($indice = 0; $indice < 32; $indice++) {
			$a[$indice] = ($nro[$indice] == "0"?0:1);
		}
		echo array_ieee754 ($a) . "\n";
	} else {
		echo "Error: Script del servidor sin parámetro requerido.\n";
	}
	exit (0);
?>