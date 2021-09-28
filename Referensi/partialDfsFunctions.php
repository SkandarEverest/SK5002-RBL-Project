<html>
<body>
<?php

function searchForNakedSingle2($SPuzzle){//this function traverses array to find naked single
		
		$compDigits=compatibleDigitsComputation($SPuzzle);
		//printTree($compDigits[1]);
		$i=0;
		while($i<sizeOf($compDigits[1])){//searches for naked single
				
			if (sizeOf($compDigits[1][$i])==1){//naked single has been found
				/*if(violation2($SPuzzle,$compDigits[0][$i][0],$compDigits[0][$i][1],$compDigits[1][$i][0]))
				{
					
					//if a violation of sudoku rules exhists then skip entering value into sudoku puzzle
				} 
				else*/
					$SPuzzle[$compDigits[0][$i][0]][$compDigits[0][$i][1]]=$compDigits[1][$i][0];//store naked single in array
			}
			$i++;
		}
		
	
	return $SPuzzle;
}
function searchRowMatch($Tarray,$m,$n,$value)//searches for a match along the row
{	
	
	for($p=1;$p<=9;$p++){
		
			if($Tarray[$m][$p]==$value)
				return true;//returns true if a match is found
			
		}
	return false;//returns false if no match is found
}

function searchColumnMatch($Tarray,$m,$n,$value)//searches for a match along the column
{	
	for($p=1;$p<=9;$p++){
		
			if($Tarray[$p][$n]==$value)
				return true;//returns true if a match is found
		}
	return false;//returns false if no match is found
}

function searchGridMatch($Tarray,$m,$n,$value)//searches for a match
{
	$h=locateSubGrid($m,$n);
	$start=getGridStartPoint($h);
	$x =$start[0];
	$y=$start[1];
	
	for ($i=$x;$i<=$x+2;$i++){
		for ($j=$y;$j<=$y+2;$j++){//returns true if a match is found and false if no match is found
			if($Tarray[$i][$j]== $value )//searches for subgrid match
				return true;
			}
	}
	
	return false;
}



function thereExistsNulls($comp){
	
	for($v=0;$v<sizeOf($comp);$v++){
		if(sizeOf($comp[$v])==0){
					
					return true;
				}
	}
	return false;
}
function violation2($V,$i,$j,$value){//if a number already is found on a row, column or subgrid. then such a number cannot be inserted in the puzzle
	$a=searchRowMatch($V,$i,$j,$value);
	$b=searchColumnMatch ($V,$i,$j,$value);
	$c=searchGridMatch($V,$i,$j,$value);
	
	if($a || $b || $c )
		return true;
	else 
		return false;
}
function violation3($V,$i,$j,$value){//if a number already is found on a row, column or subgrid. then such a number cannot be inserted in the puzzle
	
	if(is_null($i)|| is_null($j)){
		return true;
	}
		
	$a=searchRowMatch($V,$i,$j,$value);
	$b=searchColumnMatch ($V,$i,$j,$value);
	$c=searchGridMatch($V,$i,$j,$value);
	
	if($a || $b || $c )
		return true;
	else 
		return false;
}

function compatibleDigits($A,$i,$j){//function to compute compatible digits in cells with unknowns
	$a= array(1,2,3,4,5,6,7,8,9);
	
	//displayDigitsList($a);
	for($x=1;$x<=9;$x++)
	{
		if($A[$x][$j]!=0)//remove any number on same column as element
		{			
			$a=array_values(array_diff($a,[$A[$x][$j]]));		
		}
	}
	
	for($y=1;$y<=9;$y++)
	{
		if($A[$i][$y]!=0)//remove any number on same row as element
		{			
			$a=array_values(array_diff($a,[$A[$i][$y]]));				
		}
	}
	$q=locateSubGrid($i,$j);
	$startpoint=getGridStartPoint($q);
	$x=$startpoint[0];
	$y=$startpoint[1];
	
	for ($i=$x;$i<=$x+2;$i++){
		for ($j=$y;$j<=$y+2;$j++){//remove any number on same subgrid as element
			$a=array_values(array_diff($a,[$A[$i][$j]]));
			
		}
	}
	return $a;
}




function compatibleDigitsComputation2($sudoku){//used to obtain digits that are compatible for unknown cells in subgrids 2 and 5
	$compatibleT=array();
	
	for($i=1;$i<=6;$i++){//traversing the sudoku puzzle
		for($j=4;$j<=6;$j++){
			if($sudoku[$i][$j]==0){
				$z=compatibleDigits($sudoku,$i,$j);//get a vector of compatible digits
				array_push($compatibleT,$z);//add them to array
			}
		}
	}
	
	return $compatibleT;
}

function solved($R){//checks if all the cells have non zero values
	if(sizeOf($R)<1){
		return false;
	}
	for($i=1;$i<=9;$i++){
		for ($j=1;$j<=9;$j++){
			if($R[$i][$j]==0)
				return false;
		}
	}
	return true;
}


function getGridStartPoint($p)///to obtain initial values for x,y the subgrid
{
	switch($p){
		case 1:
		{$x=1;$y=1; break;}
		case 2:
		{$x=1;$y=4; break;}
		case 3:
		{$x=1;$y=7;break;}
		case 4:
		{$x=4;$y=1;break;}
		case 5:
		{$x=4;$y=4;break;}
		case 6:
		{$x=4;$y=7;break;}
		case 7:
		{$x=7;$y=1;break;}
		case 8:
		{$x=7;$y=4;break;}
		case 9:
		{$x=7;$y=7;break;}
		default:
		{$x=0;$y=0;break;}
		
	}
	$point=array($x,$y);
	return $point;
}


function locateSubGrid ($x,$y)
{
	//locate subgrid
					if ($x<=3 && $y<=3){return 1; }
						else
						if($x<=3 && $y<=6)   { return 2;}
						else 
							if($x<=3 && $y<=9) {return 3; }
							else 
							if( $x<=6 && $y<=3){ return 4; }
								 else 
								if($x<=6 && $y<=6){ return 5;}
									else 
									if($x<=6 && $y<=9){return 6;}
										else 
										if ($x<=9 && $y<=3){ return 7; }
											else 
											if ($x<=9 && $y<=6){ return 8; }
												else 
												if($x<=9 && $y<=9) 
													return 9;
													else 
													return -1;
        
					
}

function compatibleDigitsComputation($sudoku){
	$compatibleT=array();
	$location=array();
	for($i=1;$i<=9;$i++){//traversing the sudoku puzzle
		for($j=1;$j<=9;$j++){
			if($sudoku[$i][$j]==0){
				$z=compatibleDigits($sudoku,$i,$j);//get a vector of compatible digits
				array_push($compatibleT,$z);//add them to array
				array_push($location,array($i,$j));
			}
		}
	}
	
	return array($location,$compatibleT);
}

function removeLastInsertion2($Orig,$M,$value){
		/*
			for($i=1;$i<=6;$i++){//search for first occurence of zero in array
				for($j=4;$j<=6;$j++){
					if($M[$i][$j]==0){
						*/
						for($x=6;$x>0;$x--){//starts the  last cell in matrix
							for($y=6;$y>3;$y--){//works backwards unttil a match is found
								if($M[$x][$y]==$value && $Orig[$x][$y]!=$value)
								{
									$M[$x][$y]=0;//value is deleted by assigning 0 to that element
									return $M;
								}
							}
						}/*
					}
				}
	}*/
	return $M;	
}


function insertion2($f,$newPuzzle){
	for($i=1;$i<=6;$i++){//traversing the sudoku puzzle
	for($j=4;$j<=6;$j++){//inserts the value in $f at the first zero value in puzzle
		if($newPuzzle[$i][$j]==0){
			$newPuzzle[$i][$j]=$f;
			return $newPuzzle;
			}
		}
	}
	return $newPuzzle;//if no empty cell found return puzzle unchanged
}

function getFirstZeroCoordinatesFromSubGrids($C){//reads the puzzle from left to right and top to bottom and returns first position in the cell with a value of zero
	for($i=1;$i<=6;$i++){
		for ($j=4;$j<=6;$j++){
			if($C[$i][$j]==0)
				return $m=array($i,$j);
		}
	}
}


function startSearch6($count,$sudPuzzle,$timer){
	$count++;
	$sPuzzle=searchForNakedSingle2($sudPuzzle);//search for naked single
	$compatDigits=compatibleDigitsComputation($sPuzzle)[1];
	
	if(solved($sPuzzle)){
		printTree($sPuzzle);
		$timer = microtime(TRUE)-$timer;
		echo "<br/>Time: ",$timer,"<br/>";
		return $sPuzzle;
		//die();		
	}
	if(thereExistsNulls($compatDigits)){
		
		return $sPuzzle;
	}
	while($count<6){//loop 5 times through the 2 methods
	//naked single, hidden single,
		$count++;
		$sPuzzle=searchForNakedSingle2($sPuzzle);
		if(solved($sPuzzle)){
			printTree($sPuzzle);
			$timer = microtime(TRUE)-$timer;
			echo "<br/>Time: ",$timer,"<br/>";
			return $sPuzzle;
			//die();		
		}
		
		$sPuzzle=searchForHiddenSingle2($sPuzzle);
		if(solved($sPuzzle)){
			printTree($sPuzzle);
			$timer = microtime(TRUE)-$timer;
			echo "<br/>Time: ",$timer,"<br/>";
			return $sPuzzle;
			//die();		
		}
		
		
	}	
	$sPuzzle=searchForNakedPair2($sPuzzle);
		if(solved($sPuzzle)){
			printTree($sPuzzle);
			$timer = microtime(TRUE)-$timer;
			echo "<br/>Time: ",$timer,"<br/>";
			return $sPuzzle;
			//die();		
		}
		$compatDigits=compatibleDigitsComputation($sPuzzle)[1];
		if(thereExistsNulls($compatDigits)){
			//echo"count is $count<br/>";
			
			return $sPuzzle;
		}
		//compDigPuzzleForm($compatDigits,$sPuzzle);
		//echo"<br/>";
		//printTree($sPuzzle);
	return $sPuzzle;
}

function printTree($compatibleTree){
	echo "</br>";
	for($i=0;$i<sizeOf($compatibleTree);$i++){//displays the elements of the array containing lists of the compatible digits per cell
		for($j=0; $j<sizeof($compatibleTree[$i]);$j++){
		
			echo " ", $compatibleTree[$i][$j];
		}
		echo "</br>";
	}
}

function printarray2 ($square) {
//prints out the sudoku array
	for( $x=1; $x<=9; $x++) {
		for( $y=1; $y<=9; $y++) {
			echo $square[$x][$y]," " ;
			}
		echo "<br/>" ;
	}
}

function compDigPuzzleForm($coDigits,$puzzl){
	
	echo "</br>displaying compatible digits in puzzle form</br>";
	
	echo"</br>";
	$y=0;
	for($m=1;$m<=9;$m++){//traversing through puzzle
		echo "<br>";
		if(is_null($coDigits[$m])){
					echo "NULL";
					
				}else{
		for($n=1;$n<=9;$n++){//traversing through puzzle
			if($puzzl[$m][$n]==0){//display compatible digits for cells with 0
				
				if ($y<sizeOf($coDigits)){//ensures boundary of compatible digits isn't excluded
					for($k=0;$k<sizeOf($coDigits[$y]);$k++){
						echo $coDigits[$y][$k];
					}
					echo "\t\t";
					$y++;
				}
				
			}
			else
				echo " 0 "."\t\t";
		}
				}
	}
}

function display($V){
	$i=0;
	while($i<sizeOf($V)){
		echo" $V[$i]";
		$i++;
	}
	echo"<br/>";
	return;
}
function getCompDigits($Compat,$location){
	for($m=0;$m<sizeOf($Compat[0]);$m++){
		if($location===$Compat[0][$m])
			return $Compat[1][$m];
	}
}

function setCompDigits($Compats,$location,$value){
	$Compat=$Compats;
	for($m=0;$m<sizeOf($Compat[0]);$m++){
		if($location===$Compat[0][$m]){
			
			$Compat[1][$m]=array_values(array_diff($Compat[1][$m],$Compat[1][$m]));//clear array
			foreach($value as $p){
				array_push($Compat[1][$m],$p);//instert values into array
				
			}
			return $Compat;
		}
	}
}
function thereExistNakedSingle($compDig){//checks if there exists a naked single in the array of compatible digits
	for($e=0; $e<sizeOf($compDig); $e++){
		if(sizeOf($compDig[$e])==1){//traps naked single
			
			return true;
		}
	}
	return false;
}

function searchForNakedPair2($SPuzzle){//searches  for hidden single
	$array_of_pairs=array(array());
	$matched_pairs=array(array());
	$array_of_compatibleDigits=compatibleDigitsComputation($SPuzzle);
	$Puzzle2=$SPuzzle;
	//search through rows
	for($i=1;$i<=9;$i++){
		for($j=1;$j<=9;$j++){//searching row i
			if($SPuzzle[$i][$j]==0){
				if(sizeOf($array_of_compatibleDigits)>0){
					$compatDigits=getCompDigits($array_of_compatibleDigits,array($i,$j));//get compatible digits for that cell
					if(sizeOf($compatDigits)==2){
						array_push($array_of_pairs,array($compatDigits[0],$compatDigits[1]));//enter pair into array to store pairs
						for($v=0;$v<sizeOf($array_of_pairs)-1;$v++){//search for match
							if($array_of_pairs[$v]===$compatDigits){
								array_push($matched_pairs,$compatDigits);//enter matched pairs in array
							}//close if condition to search for pair match
						}//close for loop for search for match
					}//close if condition for search for pair
				}//close if
			}//close if
			
		}//close $j
		if(sizeOf($matched_pairs)>0){//remove naked pairs from other cells with compatible digits 
		//echo"-----------------------------------------------------------------------------------------------------------FOUND NAKED---------------<br/>";
			//printTree($matched_pairs);
			for($m=0;$m<sizeOf($matched_pairs);$m++){
				for($p=1;$p<=9;$p++){//remove naked pairs from other cells
					if($SPuzzle[$i][$p]==0){
						$compatDigits=getCompDigits($array_of_compatibleDigits,array($i,$p));//get compatible digits for that cell
						if($compatDigits!==$matched_pairs[$m]&& sizeOf($compatDigits)>1){
							$newValue=array_values(array_diff($compatDigits,$matched_pairs[$m]));//
							//echo "old value is compatDigits";
							//display($compatDigits);
							//echo"new value is br/>";
							//display($newValue);
							$array_of_compatibleDigits=setCompDigits($array_of_compatibleDigits,array($i,$p),$newValue);
							//printTree($array_of_compatibleDigits[1]);
							
						}
					}
				}
			}
		}
		$array_of_pairs=array(array());//reset
		$matched_pairs=array(array());
	
	}//close i
	$array_of_pairs=array(array());//reset
	$matched_pairs=array(array());
	
	//searching through columns
	
	for($j=1;$j<=9;$j++){
		for($i=1;$i<=9;$i++){//searching column j
			if($SPuzzle[$i][$j]==0){
				if(sizeOf($array_of_compatibleDigits)>0){
					$compatDigits=getCompDigits($array_of_compatibleDigits,array($i,$j));//get compatible digits for that cell
					if(sizeOf($compatDigits)==2){
						array_push($array_of_pairs,array($compatDigits[0],$compatDigits[1]));//enter pair into array to store pairs
						for($v=0;$v<sizeOf($array_of_pairs)-1;$v++){//search for match
							if($array_of_pairs[$v]===$compatDigits){
								array_push($matched_pairs,$compatDigits);//enter matched pairs in array
							}//close if condition to search for pair match
						}//close for loop for search for match
					}//close if condition for search for pair
				}//close if
			}//close if
			
		}//close $i
		if(sizeOf($matched_pairs)>0){//remove naked pairs from other cells with compatible digits 
		///echo"-----------------------------------------------------------------------------------------------------------FOUND NAKED---------------<br/>";
			//printTree($matched_pairs);
			for($m=0;$m<sizeOf($matched_pairs);$m++){
				for($p=1;$p<=9;$p++){//remove naked pairs from other cells
					if($SPuzzle[$p][$j]==0){
						$compatDigits=getCompDigits($array_of_compatibleDigits,array($i,$p));//get compatible digits for that cell
						if($compatDigits!==$matched_pairs[$m] && sizeOf($compatDigits)>1 ){
							$newValue=array_values(array_diff($compatDigits,$matched_pairs[$m]));//
							//echo "old value is compatDigits";
							//display($compatDigits);
							//echo"new value is <br/>";
							//display($newValue);
							$array_of_compatibleDigits=setCompDigits($array_of_compatibleDigits,array($i,$p),$newValue);
							//printTree($array_of_compatibleDigits[1]);
						}
					}
				}
			}
		}//close if
		$array_of_pairs=array(array());//reset
		$matched_pairs=array(array());	
	}//close j
	
	$array_of_pairs=array(array());//reset
	$matched_pairs=array(array());
	//searching through sub grid
	for($p=0;$p<=2;$p++){//moving along a band of subgrids
			for($q=0;$q<=2;$q++){////moving down a stack of subgrids
			$x=$p*3+1;
			$y=$q*3+1;
				for ($i=$x;$i<=$x+2;$i++){	//moving down a column in a subgrid							
						for ($j=$y;$j<=$y+2;$j++){//moving along a row in a subgrid
							if($SPuzzle[$i][$j]==0){
								if(sizeOf($array_of_compatibleDigits)>0){
									$compatDigits=getCompDigits($array_of_compatibleDigits,array($i,$j));//get compatible digits for that cell
									if(sizeOf($compatDigits)==2){
										array_push($array_of_pairs,array($compatDigits[0],$compatDigits[1]));//enter pair into array to store pairs
										for($v=0;$v<sizeOf($array_of_pairs)-1;$v++){//search for match
											if($array_of_pairs[$v]===$compatDigits && sizeOf($compatDigits)>1){
												array_push($matched_pairs,$compatDigits);//enter matched pairs in array
											}//close if condition to search for pair match
										}//close for loop for search for match
									}//close if condition for search for pair
								}//close if
							}//close if

						}//close j
					}//close i
				if(sizeOf($matched_pairs)>0){//remove naked pairs from other cells with compatible digits 
			//		echo"-----------------------------------------------------------------------------------------------------------FOUND NAKED---------------<br/>";
				//	printTree($matched_pairs);
					for($m=0;$m<sizeOf($matched_pairs);$m++){
						for ($i=$x;$i<=$x+2;$i++){	//moving down a column in a subgrid							
						for ($j=$y;$j<=$y+2;$j++){//moving along a row in a subgrid
							if($SPuzzle[$i][$j]==0){
								$compatDigits=getCompDigits($array_of_compatibleDigits,array($i,$j));//get compatible digits for that cell
								if($compatDigits!==$matched_pairs[$m] && sizeOf($compatDigits)>1){
									//echo "old value is compatDigits";
									//display($compatDigits);
									$newValue=array_values(array_diff($compatDigits,$matched_pairs[$m]));//
									//echo"new value is <br/>";
									//display($newValue);
									$array_of_compatibleDigits=setCompDigits($array_of_compatibleDigits,array($i,$j),$newValue);
									//printTree($array_of_compatibleDigits[1]);
									//compDigPuzzleForm($array_of,$puzzl)
								}
							}//close if
						}//close j
						}//close i
					}//close m
				}//close if
			$array_of_pairs=array(array());//reset
			$matched_pairs=array(array());

			}//close q
	}//close p
	
		//-----------filter naked singles------------
		$compDigits=$array_of_compatibleDigits;
		$i=0;
		while($i<sizeOf($compDigits[1])){//searches for naked single
				
			if (sizeOf($compDigits[1][$i])==1){//naked single has been found
				if(violation2($SPuzzle,$compDigits[0][$i][0],$compDigits[0][$i][1],$compDigits[1][$i][0]))
				{
					//if a violation of sudoku rules exhists then skip entering value into sudoku puzzle
				} 
				else
					$SPuzzle[$compDigits[0][$i][0]][$compDigits[0][$i][1]]=$compDigits[1][$i][0];//store naked single in array
			}
			$i++;
		}
		
	return $SPuzzle;
}
function searchForHiddenSingle2($SPuzzle){//searches  for hidden single
	$array_of_location=array(array());
	$count_digits=array(0,0,0,0,0,0,0,0,0,0);
	$array_of_compatibleDigits=compatibleDigitsComputation($SPuzzle);
	$Puzzle2=$SPuzzle;
	//search through rows
	for($i=1;$i<=9;$i++){
		for($j=1;$j<=9;$j++){//searching row i
			if($SPuzzle[$i][$j]==0){
				if(sizeOf($array_of_compatibleDigits)>0){
					$compatDigits=getCompDigits($array_of_compatibleDigits,array($i,$j));
					for($n=0;$n<sizeOf($compatDigits);$n++){
						$count_digits[$compatDigits[$n]]++;
						$array_of_location[$compatDigits[$n]]=array($i,$j);
					}//close loop n
				}//close if
			}//close if
			
		}//close $j
		for($q=1;$q<=9;$q++){//store hidden single in puzzle
			if($count_digits[$q]==1){
							
				$Puzzle2[$array_of_location[$q][0]][$array_of_location[$q][1]]=$q;
			}
		}
		$array_of_location=array(array());//reset
		$count_digits=array(0,0,0,0,0,0,0,0,0,0);
		//$array_of_compatibleDigits=compatibleDigitsComputation2($SPuzzle);//recompute compatible digits
	}//close $i
	$SPuzzle=$Puzzle2;
	//$array_of_location=array(array());//reset
	//$count_digits=array(0,0,0,0,0,0,0,0,0,0);
	$array_of_compatibleDigits=compatibleDigitsComputation2($SPuzzle);//recompute compatible digits
	//search through columns
	for($j=1;$j<=9;$j++){
		for($i=1;$i<=9;$i++){//searching column j
			if($SPuzzle[$i][$j]==0){
				if(sizeOf($array_of_compatibleDigits)>0){
					$compatDigits=getCompDigits($array_of_compatibleDigits,array($i,$j));
					for($n=0;$n<sizeOf($compatDigits);$n++){
						$count_digits[$compatDigits[$n]]++;
						$array_of_location[$compatDigits[$n]]=array($i,$j);
					}//close loop n
				}
			}//close if
			
		}//close $i
		for($q=1;$q<=9;$q++){//store hidden single in puzzle
			if($count_digits[$q]==1){
				$Puzzle2[$array_of_location[$q][0]][$array_of_location[$q][1]]=$q;
			}
		}
		$array_of_location=array(array());//reset
		$count_digits=array(0,0,0,0,0,0,0,0,0,0);
		//$array_of_compatibleDigits=compatibleDigitsComputation2($SPuzzle);//recompute compatible digits
	}//close $j
	$SPuzzle=$Puzzle2;
	//$array_of_location=array(array());//reset
	//$count_digits=array(0,0,0,0,0,0,0,0,0,0);
	$array_of_compatibleDigits=compatibleDigitsComputation2($SPuzzle);//recompute compatible digits
	//search through grids
	for($p=0;$p<=2;$p++){//moving along a band of subgrids
			for($q=0;$q<=2;$q++){////moving down a stack of subgrids
			$x=$p*3+1;
			$y=$q*3+1;
				for ($i=$x;$i<=$x+2;$i++){	//moving down a column in a subgrid							
						for ($j=$y;$j<=$y+2;$j++){//moving along a row in a subgrid
							if($SPuzzle[$i][$j]==0){
								if(sizeOf($array_of_compatibleDigits)>0){
									$compatDigits=getCompDigits($array_of_compatibleDigits,array($i,$j));
									for($n=0;$n<sizeOf($compatDigits);$n++){
										$count_digits[$compatDigits[$n]]++;
										$array_of_location[$compatDigits[$n]]=array($i,$j);
									}//close loop n
								}
							}//close if
							
						}
				}
				for($q=1;$q<=9;$q++){//store hidden single in puzzle
					if($count_digits[$q]==1){
						$Puzzle2[$array_of_location[$q][0]][$array_of_location[$q][1]]=$q;
					}
				}
				$array_of_location=array(array());//reset
				$count_digits=array(0,0,0,0,0,0,0,0,0,0);
				//$array_of_compatibleDigits=compatibleDigitsComputation2($SPuzzle);//recompute compatible digits
			}
	}
	$SPuzzle = $Puzzle2;
	return $SPuzzle;
}

function compatibleDigitsComputation4($sudoku){//used to obtain digits that are compatible for unknown cells in subgrids 2 and 5
	$compatibleT=array();
	
	for($i=1;$i<=9;$i++){//traversing the sudoku puzzle
		for($j=4;$j<=6;$j++){
			if($sudoku[$i][$j]==0){
				$z=compatibleDigits($sudoku,$i,$j);//get a vector of compatible digits
				array_push($compatibleT,$z);//add them to array
			}
		}
	}
	
	return $compatibleT;
}


function insertion4($f,$newPuzzle){
	for($i=1;$i<=9;$i++){//traversing the sudoku puzzle
	for($j=4;$j<=6;$j++){//inserts the value in $f at the first zero value in puzzle
		if($newPuzzle[$i][$j]==0){
			$newPuzzle[$i][$j]=$f;
			return $newPuzzle;
			}
		}
	}
	return $newPuzzle;//if no empty cell found return puzzle unchanged
}

function getFirstZeroCoordinatesFromSubGrids4($C){//reads the puzzle from left to right and top to bottom and returns first position in the cell with a value of zero
	for($i=1;$i<=9;$i++){
		for ($j=4;$j<=6;$j++){
			if($C[$i][$j]==0)
				return $m=array($i,$j);
		}
	}
}


function removeLastInsertion4($Orig,$M,$value){
		/*
			for($i=1;$i<=6;$i++){//search for first occurence of zero in array
				for($j=4;$j<=6;$j++){
					if($M[$i][$j]==0){
						*/
						for($x=9;$x>0;$x--){//starts the  last cell in matrix
							for($y=6;$y>3;$y--){//works backwards unttil a match is found
								if($M[$x][$y]==$value && $Orig[$x][$y]!=$value)
								{
									$M[$x][$y]=0;//value is deleted by assigning 0 to that element
									return $M;
								}
							}
						}/*
					}
				}
	}*/
	return $M;	
}

?>

</body>
</html>