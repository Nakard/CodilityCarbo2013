<?php
function findPrefixLength($s, $a, $b)
{
	$len = 0;
	$n = strlen($s);
	for($i = 0; $i + $a < $n && $i + $b < $n; $i++)
	{
		if($s[$i+$a] == $s[$i+$b])
			$len++;
		else
			break;
	}
	return $len;
}
function Z_algo($s)
{
	$L = 0;
	$R = 0;
	$n = strlen($s);
	$z = array_fill(0, $n, 0);
	$z[0] = $n;
	if($n > 1)
	{
		$z[1] = findPrefixLength($s, 0, 1);
	}
	if($z[1] > 0)
	{
		$L = 1;
		$R = $z[1];
	}
	for($i = 2; $i < $n; $i++)
	{
		if($i > $R)
		{
			$z[$i] = findPrefixLength($s, 0, $i);
			if($z[$i] > 0)
			{
				$L = $i;
				$R = $i + $z[$i] - 1;
			}
		}
		else
		{
			$k = $i-$L;
			if($z[$k] < $R-$i+1)
			{
				$z[$i] = $z[$k];
			}
			else
			{
				$p = findPrefixLength($s, $R-$i+1,$R+1);
				$z[$i] = $R-$i+1+$p;
				$L = $i;
				$R = $i + $z[$i] -1;
			}
		}
	}
	return $z;
}

function solution($S)
{
	$z = Z_algo($S);
	$n = strlen($S);
	$cnt = array_fill(0, $n+1, 0);
	for($i = 0; $i < $n; ++$i)
	{
		++$cnt[$z[$i]];
	}
	$previous = 0;
	for($i = $n; $i > 0; --$i)
	{
		$cnt[$i] += $previous;
		$previous = $cnt[$i];
	}
	$ans = 0;
	for($i = 1; $i <= $n; ++$i)
	{
		$test = $cnt[$i] * $i;
		$ans = max($ans, $test);
	}

	return $ans > 1000000000 ? 1000000000 : $ans;
}