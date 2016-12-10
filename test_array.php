<?php

$name = "chy";
$age = 26;
$phone = "010-2271-xxxx";
$live = "gyeonggido";
$hobby = array(
    "rapping",
    "singing",
    "excercise",
    "coding"
);
$lotto = array(
    'origin' => array(5,10,13,25,30,35),
    'bonus' => 24
);
// 5 10 13 25 30 35 24

// echo "<pre>";
// print_r($hobby);
// echo "</pre>";
//
//
// echo "<pre>";
// print_r($lotto);
// echo "</pre>";


// foreach ($hobby as $hobby_value) {
//     foreach ($lotto as $key => $lotto_value) {
//         $arr = array(
//             'name' => $name,
//             'age' => $age,
//             'phone' => $phone,
//             'live' => $live,
//             'hobby' => $hobby_value,
//             'lotto' => $lotto_value
//         );
//         echo "<pre>";
//         print_r($arr);
//         echo "</pre>";
//     }
//     echo "<pre>";
//     print_r($arr);
//     echo "</pre>";
// }

// echo "<pre>";
// var_dump($arr);
// echo "</pre>";
foreach($hobby as $hobby_value) {
    var_dump($hobby_value);
    echo "</pre>";
    $arr[$name][$age][$phone][$live][$hobby_value] = array(
        'name' => $name,
        'age' => $age,
        'phone' => $phone,
        'live' => $live,
        'hobby' => $hobby_value,
        'lotto' => $lotto
    );
}
// echo "<pre>";
// print_r($arr);
// echo "</pre>";

// echo "<pre>arr";
// var_dump($arr);
// echo "</pre>";

// foreach ($arr as $key) {
//     echo $key.'&#9;';
//     echo $arr.'&#9;';
//     echo "<pre>arr";
//     var_dump($arr);
//     echo "</pre>";
//     echo "<pre>key";
//     var_dump($key);
//     echo "</pre>";
//
// }
foreach ($arr as $key => $value) {
    echo "<br/>";
    echo $key.'&#9;';
    foreach ($value as $value_key => $age) {
        echo $value_key.'&#9;';
        foreach ($age as $age_key => $phone) {
            echo $age_key.'&#9;';
            foreach ($phone as $phone_key => $live) {
                echo $phone_key.'&#9;';
                foreach ($live as $live_key => $hobby) {
                        echo "<pre>live";
                        var_dump($live);
                        echo "</pre>";

                        echo "<pre>live_key";
                        var_dump($live_key);
                        echo "</pre>";

                        echo "<pre>hobby";
                        var_dump($hobby);
                        echo "</pre>";
                }
            }
        }
    }
}


 ?>
