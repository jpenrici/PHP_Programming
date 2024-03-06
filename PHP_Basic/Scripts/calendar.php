<?php

function calendar($year = 2024, $month = 01): array
{
    // Days of the week
    $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    // List of months
    $months = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    // First day
    $first = "$year-$month-01";
    // Day in the week of the first day
    $start = date('w', strtotime($first));
    // Total days
    $last  = date('t', strtotime($first));

    $numbers = array_merge($days, array_fill(0, $start, ""));
    for ($i = 1; $i <= $last; $i++) {
        array_push($numbers, $i);
    }

    return [
        'year'     => $year,
        'month'    => $months[$month],
        'start'    => $days[$start],
        'total'    => $last,
        'calendar' => $numbers
    ];
}

function test()
{
    $data = calendar(2024, 2);
    // var_dump($data);

    echo "<h1>" . $data['month'] . " " . $data['year'] . "</h1>";
    echo "<table border='1'>";
    $line = "<tr>";
    for ($i = 0; $i < count($data['calendar']); $i++) {
        $line .= "<td>" . $data['calendar'][$i] . "</td>";
        if ($i % 7 == 6) {
            $line .= "</tr><tr>";
        }
    }
    echo $line;
}

// Main
test();
