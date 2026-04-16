<?php

$length = 20;
$width = 10;

function area_of_rectangle() {
    global $length, $width; // bring variables inside function
    return $length * $width;
}

echo "The area of rectangle is: " . area_of_rectangle();



// function area_of_square ($side){

// return $side**2;

// };
//  echo "area of square is:" .area_of_square(4);



// function greeting() {
//     echo "Hello user Keane";
// }

// greeting();


// function greeting($name){

// echo "hello user".$name;
// }

// greeting('keanne');
?>