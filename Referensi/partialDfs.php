<html>
<body>
<?php

include('newDfsFunctions.php');
include('sudokuSamples.php');
set_time_limit( 0 ) ;
ini_set('memory_limit','2000M');

$sudoku_arr=$S40;
$compatible_arr=compatibleDigitsComputation2($sudoku_arr);
$depth1=0;
$breadth1=0;
$count1=0;
$original=$sudoku_arr;
$solution_arr=array();
global $timer;
$timer=microtime(TRUE);
echo "<br/>Time: ",microtime(TRUE),"<br/>";

function hybridBPnP($count,$depth,$breadth,$compatible_array,$solution_array,$sudoku_array,$OrigS,$time1){
			
			///first a search is done for the solution using pencil and paper method
			echo "<br/>SEARCH HAS BEGUN<br/>";
			$solution=startSearch6($count,$sudoku_array,$time1);			
		
			if(solved($solution)){//checks if sudoku has been solved
				echo"<br/>";
				printarray2($solution);
				$time2=microtime(TRUE)-$time1;
				echo "<br/>Time: ",$time2,"<br/>";
				die();
			}
			else{//a call is made to the partialDFS method
						  
				$sudoku_array=$solution;
				//printarray2($solution);
				$OrigS=$solution;
				$compatible_array=compatibleDigitsComputation4($sudoku_array);
				DFS4 ($count,$depth,$breadth,$compatible_array,$solution_array,$sudoku_array,$OrigS,$time1);
				return;
			}
	
}

function DFS ($count,$depth,$breadth,$compatible_array,$solution_array,$sudoku_array,$OrigS,$time3,$final){//traversing through the tree using dfs algorithm
	$count++;
	$element=$compatible_array[$depth][$breadth];//picking an element from the array of compatible digits
	$z=getFirstZeroCoordinatesFromSubGrids($sudoku_array);//getting the first empty cell in the puzzle
	$x=$z[0];
	$y=$z[1];
	//echo"<br/>VALUE OF ELEMENT IS $element, x and y are $x,$y";
	
	if(!violation3($sudoku_array,$x,$y,$element)){//checks if element violates constraints
		//echo"ENTERED NOT VIOLATION<br/>";
		//echo"VALUE OF BREADTH AND DEPTH IS $breadth, $depth<br/>";
		//printTree($compatible_array);
		
		$sudoku_array=insertion2($element,$sudoku_array);//enters element,
		//printarray2($sudoku_array);
		array_push($solution_array,$element);
		//echo"</br";
		
		$depth=$depth+1;
		//echo"<br/>";
		//printTree($compatible_array);
		//echo"<br/>";
		//printTree($sudoku_array);
		if($depth==sizeOf($compatible_array)){//checks if subgrds 2 and 5 are filled
		///echo"<br/>-=======================================Depth is size of compatible array<br/>";
		///printarray2($sudoku_array);
			/*if(checkForMatch($sudoku_array,$final)){
				echo"------------------------------------------------FOUND MATCH---------------------------------<br/>";
				printarray2($sudoku_array);
			}*/
			
			$solution=startSearch2(0,$sudoku_array,$time3);
			if(solved($solution)){
				echo"<br/>";
				printarray2($solution);
				$time2=microtime(TRUE)- $time3;
				echo "<br/>Time: ",$time2,"<br/>";
				die();
		
			}
			else
			{
					$depth=$depth-1;//moves up  the tree
					$v=$solution_array[sizeOf($solution_array)-1];//gets the last element in the solution array
					
					array_pop($solution_array);//removes the last element in the solution array
					$breadth=array_search($v,$compatible_array[$depth],true);
					$breadth=$breadth+1;//increment breadth to explore next value
					$sudoku_array=removeLastInsertion2($OrigS,$sudoku_array,$v);
					
					if($breadth<=sizeOf($compatible_array[$depth])-1)//tests if next element in array of compatible digits is suitable
							{
								DFS($count,$depth,$breadth,$compatible_array,$solution_array,$sudoku_array,$OrigS,$time3,$final);//recursively calls DFS
							}
							else{
									while($breadth>sizeOf($compatible_array[$depth])-1)
									{
										
										$depth=$depth-1;//moves up  the tree
										$v=$solution_array[sizeOf($solution_array)-1];//gets the last element in the solution array
										
										array_pop($solution_array);//removes the last element in the solution array
										$breadth=array_search($v,$compatible_array[$depth],true);
										$breadth=$breadth+1;//increment breadth to explore next value
										$sudoku_array=removeLastInsertion2($OrigS,$sudoku_array,$v);
									}
									
								DFS($count,$depth,$breadth,$compatible_array,$solution_array,$sudoku_array,$OrigS,$time3,$final);
							}					
			}
		}
		$breadth=0;
		DFS($count,$depth,$breadth,$compatible_array,$solution_array,$sudoku_array,$OrigS,$time3,$final);
	}
	else{
	//	echo"VALUE OF BREADTH AND DEPTH IS $breadth, $depth<br/>";
		//printTree($compatible_array);
		//printarray2($sudoku_array);
		$breadth=$breadth+1;//explore next element on branch
		if($breadth<=sizeOf($compatible_array[$depth])-1)//tests if next element in array of compatible digits is suitable
		{
			
			DFS($count,$depth,$breadth,$compatible_array,$solution_array,$sudoku_array,$OrigS,$time3,$final);//recursively calls DFS
		}
		else{
				while($breadth>sizeOf($compatible_array[$depth])-1)
				{
					
					$depth=$depth-1;//moves up  the tree
					if($depth==-1){
						echo"UNSOLVABLE------------<br/>";
						die();
					}
					$v=$solution_array[sizeOf($solution_array)-1];//gets the last element in the solution array
					array_pop($solution_array);//removes the last element in the solution array
					$breadth=array_search($v,$compatible_array[$depth],true);
					$breadth=$breadth+1;//increment breadth to explore next value
					$sudoku_array=removeLastInsertion2($OrigS,$sudoku_array,$v);
					//echo"entered remove last insertion for value $v <br/>";
					//printarray2($sudoku_array);
				}
				
			DFS($count,$depth,$breadth,$compatible_array,$solution_array,$sudoku_array,$OrigS,$time3,$final);
		}
	}
}


function DFS4 ($count,$depth,$breadth,$compatible_array,$solution_array,$sudoku_array,$OrigS,$time3){//traversing through the tree using dfs algorithm
	$count++;
	$element=$compatible_array[$depth][$breadth];//picking an element from the array of compatible digits
	$z=getFirstZeroCoordinatesFromSubGrids4($sudoku_array);//getting the first empty cell in the puzzle
	$x=$z[0];
	$y=$z[1];
	//echo"<br/>VALUE OF ELEMENT IS $element, x and y are $x,$y";
	
	if(!violation3($sudoku_array,$x,$y,$element)){//checks if elements violates constraints
		
		$sudoku_array=insertion4($element,$sudoku_array);//enters element,
		//printarray2($sudoku_array);
		array_push($solution_array,$element);
		//echo"</br";
		
		$depth=$depth+1;
		//echo"<br/>";
		///printTree($compatible_array);
		///echo"<br/>";
		///printTree($sudoku_array);
		if($depth==sizeOf($compatible_array)){//checks if subgrds 2 and 5 are filled
		
			$solution=startSearch6(0,$sudoku_array,$time3);
			if(solved($solution)){
				echo"<br/>";
				printarray2($solution);
				$time2=microtime(TRUE)- $time3;
				echo "<br/>Time: ",$time2,"<br/>";
				die();
		
			}
			else
			{
					$depth=$depth-1;//moves up  the tree
					$v=$solution_array[sizeOf($solution_array)-1];//gets the last element in the solution array
					
					array_pop($solution_array);//removes the last element in the solution array
					$breadth=array_search($v,$compatible_array[$depth],true);
					$breadth=$breadth+1;//increment breadth to explore next value
					$sudoku_array=removeLastInsertion4($OrigS,$sudoku_array,$v);
					
					if($breadth<=sizeOf($compatible_array[$depth])-1)//tests if next element in array of compatible digits is suitable
							{
								DFS4($count,$depth,$breadth,$compatible_array,$solution_array,$sudoku_array,$OrigS,$time3);//recursively calls DFS
							}
							else{
									while($breadth>sizeOf($compatible_array[$depth])-1)
									{
										
										$depth=$depth-1;//moves up  the tree
										$v=$solution_array[sizeOf($solution_array)-1];//gets the last element in the solution array
										
										array_pop($solution_array);//removes the last element in the solution array
										$breadth=array_search($v,$compatible_array[$depth],true);
										$breadth=$breadth+1;//increment breadth to explore next value
										$sudoku_array=removeLastInsertion4($OrigS,$sudoku_array,$v);
									}
									
								DFS4($count,$depth,$breadth,$compatible_array,$solution_array,$sudoku_array,$OrigS,$time3);
							}					
			}
		}
		$breadth=0;
		DFS4($count,$depth,$breadth,$compatible_array,$solution_array,$sudoku_array,$OrigS,$time3);
	}
	else{
		
		$breadth=$breadth+1;//explore next element on branch
		if($breadth<=sizeOf($compatible_array[$depth])-1)//tests if next element in array of compatible digits is suitable
		{
			
			DFS4($count,$depth,$breadth,$compatible_array,$solution_array,$sudoku_array,$OrigS,$time3);//recursively calls DFS
		}
		else{
				while($breadth>sizeOf($compatible_array[$depth])-1)
				{
					
					$depth=$depth-1;//moves up  the tree
					if($depth==-1){
						echo"UNSOLVABLE------------<br/>";
						die();
					}
					$v=$solution_array[sizeOf($solution_array)-1];//gets the last element in the solution array
					array_pop($solution_array);//removes the last element in the solution array
					$breadth=array_search($v,$compatible_array[$depth],true);
					$breadth=$breadth+1;//increment breadth to explore next value
					$sudoku_array=removeLastInsertion4($OrigS,$sudoku_array,$v);
					
				}
				
			DFS4($count,$depth,$breadth,$compatible_array,$solution_array,$sudoku_array,$OrigS,$time3);
		}
	}
}



hybridBPnP($count1,$depth1,$breadth1,$compatible_arr,$solution_arr,$sudoku_arr,$original,$timer);



?>

</body>
</html>