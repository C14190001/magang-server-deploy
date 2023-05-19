<?php
include 'config.php';
$dsn = "mysql:host=$ServerIP;dbname=$DbName;charset=$DBCharset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $pdo = new PDO($dsn, $Username, $Password, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
session_start();
if (!isset($_SESSION["user"])) {
} else {
    $FilterFrom = $_POST["From"];
    $FilterTo = $_POST["To"];

    $stmt = $pdo->prepare("SELECT DISTINCT 
    `clients`.`id` AS 'id', 
    `clients`.`updated?` AS 'update', 
    `client_specs`.`name` AS 'name', 
    `client_specs`.`cpu` AS 'cpu', 
    `client_specs`.`i-gpu` AS 'igpu', 
    `client_specs`.`e-gpu` AS 'egpu', 
    `client_specs`.`ram` AS 'ram', 
    `client_specs`.`memory` AS 'mem', 
    `client_specs`.`ip` AS 'ip', 
    `client_specs`.`mac` AS 'mac', 
    `client_apps`.`apps` AS 'apps' 
    FROM clients 
    INNER JOIN client_specs ON `clients`.`id` = `client_specs`.`id` 
    INNER JOIN client_status ON `clients`.`id` = `client_status`.`id` 
    INNER JOIN client_apps ON `clients`.`id` = `client_apps`.`id`
    WHERE client_status.date_time BETWEEN ? AND ?");
    $stmt->execute([$FilterFrom, $FilterTo]);

    $delimiter = ",";
    $filename = "clients_From_" . $FilterFrom . "_To_" . $FilterTo  . ".csv";
    // Create a file pointer 
    $f = fopen('php://memory', 'w');
    // Set column headers 
    $fields = array('Client ID', 'Updated?', 'Client Name', 'CPU', 'iGPU', 'eGPU', 'RAM', 'Memory', 'IP address', 'MAC address', 'Installed Apps', 'Total Uptime');
    fputcsv($f, $fields, $delimiter);

    // Output each row of the data, format line as csv and write to file pointer 
    foreach ($stmt as $row) {
        $first_on = FALSE;
        $t_d = 0;
        $t_h = 0;
        $t_m = 0;
        $t_s = 0;
        $last_status = "OFF";

        $stmt2 = $pdo->prepare("SELECT * FROM `client_status` WHERE `id` = ? 
        AND `date_time` BETWEEN ? AND ? ORDER BY `date_time` ASC");
        $stmt2->execute([$row["id"], $FilterFrom, $FilterTo]);
        foreach ($stmt2 as $row2) {
            if ($row2["status"] == "ON" && !$first_on) {
                $on = new DateTime($row2["date_time"]);
                $first_on = TRUE;
            }
            if ($row2["status"] == "OFF" && $first_on) {
                $uptime = $on->diff(new DateTime($row2["date_time"]));
                $t_d += $uptime->format("%d");
                $t_h += $uptime->format("%h");
                $t_m += $uptime->format("%i");
                $t_s += $uptime->format("%s");
                $first_on = FALSE;
            }
            $last_status = $row2["status"];
        }

        if ($last_status == "ON") {
            $uptime = $on->diff(new DateTime($FilterTo . ":00"));
            $t_d += $uptime->format("%d");
            $t_h += $uptime->format("%h");
            $t_m += $uptime->format("%i");
            $t_s += $uptime->format("%s");
        }

        while ($t_s > 60) {
            $t_m++;
            $t_s -= 60;
        }
        while ($t_m > 60) {
            $t_h++;
            $t_m -= 60;
        }
        while ($t_h > 24) {
            $t_d++;
            $t_h -= 24;
        }
        ////Total Uptime yang benar
        $total_uptime_str = $t_d . " Days " . $t_h . " Hours " . $t_m . " Minutes " . $t_s . " Seconds ";

        $lineData = array($row['id'], $row['update'], $row['name'], $row['cpu'], $row['igpu'], $row['egpu'], $row['ram'], $row['mem'], $row['ip'], $row['mac'], $row['apps'], $total_uptime_str);
        fputcsv($f, $lineData, $delimiter);
    }


    // Move back to beginning of file 
    fseek($f, 0);

    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

    //output all remaining data on a file pointer 
    fpassthru($f);
}
