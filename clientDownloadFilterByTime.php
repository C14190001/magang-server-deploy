<?php
session_start();
if (!isset($_SESSION["user"])) {
    echo "<script>window.location.href='login.php';</script>";
} else {
    $FilterFrom = $_POST["From"];
    $FilterTo = $_POST["To"];
    $conn = new mysqli('localhost', 'root', '', 'magang-database');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT DISTINCT 
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
    WHERE client_status.date_time BETWEEN '" . $FilterFrom . "' AND '" . $FilterTo . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $delimiter = ",";
        $filename = "clients_From_" . $FilterFrom . "_To_" . $FilterTo  . ".csv";
        // Create a file pointer 
        $f = fopen('php://memory', 'w');
        // Set column headers 
        $fields = array('Client ID', 'Updated?', 'Client Name', 'CPU', 'iGPU', 'eGPU', 'RAM', 'Memory', 'IP address', 'MAC address', 'Installed Apps', 'Total Uptime');
        fputcsv($f, $fields, $delimiter);

        // Output each row of the data, format line as csv and write to file pointer 
        while ($row = $result->fetch_assoc()) {
            $conn2 = new mysqli('localhost', 'root', '', 'magang-database');
            if ($conn2->connect_error) {
                die("Connection failed: " . $conn2->connect_error);
            }
            $sql2 = "SELECT * FROM `client_status` WHERE `id` = '" . $row["id"] . "' 
            AND `date_time` BETWEEN '" . $FilterFrom . "' AND '" . $FilterTo . "' ORDER BY `date_time` ASC";
            $first_on = FALSE;
            $t_d = 0;
            $t_h = 0;
            $t_m = 0;
            $t_s = 0;
            $last_status = "OFF";
            $result2 = $conn2->query($sql2);
            if ($result2->num_rows > 0) {
                while ($row2 = $result2->fetch_assoc()) {
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
            $conn2->close();
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
    } else {
        echo "<script>close();</script>";
    }

    $conn->close();
}
