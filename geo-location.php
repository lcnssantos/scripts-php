<?php 
/*
@author: Luciano Souza Santos
@email: luciano.ssants@gmail.com

@purpose: This class is used to determine if a point is inside of polygon.

@parameters:

	$pol: an array with coordinates of the polygon
	$point: an array with coordinates of the point
	
*/
class GEO
{
	private $pol;
	private $point;
	
	public function setPoint($point)
	{
		$this->point = $point;
	}
	
	public function setPolygon($pol)
	{
		$this->pol = $pol;
	}
	
	private function lineCross($r1,$r2)
	{
		if(($r1['p']['x']==$r1['q']['x']))
			$a1 = 10000000;
		else
			$a1 = ($r1['p']['y']-$r1['q']['y'])/($r1['p']['x']-$r1['q']['x']);
		if($r2['a']['x']==$r2['b']['x'])
			$a2 = 10000000;
		else
			$a2 = ($r2['a']['y']-$r2['b']['y'])/($r2['a']['x']-$r2['b']['x']);
		
		$eq1['a'] = $a1;
		$eq2['a'] = $a2;
		
		$eq1['b'] = -$a1*$r1['q']['x']+$r1['q']['y'];
		
		$eq2['b'] = -$a2*$r2['b']['x']+$r2['b']['y'];
		
		$x = ($eq2['b']-$eq1['b'])/($eq1['a']-$eq2['a']);
		
		
		$y = $a1*$x+$eq1['b'];
		

		
		if(($x > $r2['a']['x'] && $x < $r2['b']['x']) || ($x > $r2['b']['x'] && $x < $r2['a']['x']))
		{
			if(($y > $r2['a']['y'] && $y < $r2['b']['y']) || ($y > $r2['b']['y'] && $y < $r2['a']['y']))
			{
				if(($x > $r1['p']['x'] && $x < $r1['q']['x']) || ($x > $r1['q']['x'] && $x < $r1['p']['x']))
				{
					if(($y > $r1['p']['y'] && $y < $r1['q']['y']) || ($y > $r1['q']['y'] && $y < $r1['p']['y']))
					{
						return true;
					}
				}
			}
		}
		else
			return false;
		
	}
	public function pointInsidePolygon()
	{
		$pol = $this->pol;
		$point = $this->point;
		
		if($pol == "" || $point == "")
			return false;
		
		$polx = $pol[0];
		$poly = $pol[1];
		
		$i = sizeof($polx);
		
		$polx[$i] = $polx[0];
		$poly[$i] = $poly[0];

		$a = 0;
		for($i=0;isset($polx[$i+1]);$i++)
		{
			$r1['p']['x'] = $point[0];
			$r1['p']['y'] = $point[1];
			$r1['q']['x'] = 0;
			$r1['q']['y'] = 0;

			$r2['a']['x'] = $polx[$i];
			$r2['a']['y'] = $poly[$i];
			$r2['b']['x'] = $polx[$i+1];
			$r2['b']['y'] = $poly[$i+1];
				
			if(lineCross($r1,$r2))
			{
				$a++;
			}
		}
		if(($a%2) != 0)
		{
			return true;
		}
		else
			return false;
	}	
}

?>
