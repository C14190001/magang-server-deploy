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
    $clientId = $_POST["clientId"];
    $FilterFrom = $_POST["from"];
    $FilterTo = $_POST["to"];

    $stmt = $pdo->prepare("SELECT `clients`.`id` AS 'id', 
    `clients`.`updated?` AS 'update',
    `client_specs`.`name` AS 'name',
    `client_specs`.`cpu` AS 'cpu',
    `client_specs`.`i-gpu` AS 'igpu',
    `client_specs`.`e-gpu` AS 'egpu',
    `client_specs`.`ram` AS 'ram',
    `client_specs`.`memory` AS 'mem',
    `client_specs`.`ip` AS 'ip',
    `client_specs`.`mac` AS 'mac'
    FROM clients 
    LEFT JOIN client_specs ON `clients`.`id` = `client_specs`.`id`
    WHERE `clients`.`id` = ?");
    $stmt->execute([$clientId]);
    foreach ($stmt as $row) {
        echo "<div class='grid-item' id='" . $row["id"] . "'>
                    <b>[ " . $row["id"] . " ] " . $row["name"] . " ( ";
        if ($row["update"] == "1") {
            echo " Updated ";
        } else {
            echo " Not Updated ";
        }
        echo ")</b><br><br>";
        // echo "<button type='button' onclick='updateClient(" . $row["id"] . ")'>Update client</button>";
        // echo "<b>   </b>";
        // echo "<button type='button' onclick='refreshClient(" . $row["id"] . ")'>Refresh</button>";

        echo "<p> Total Uptime: <br>• ";
        $stmt2 = $pdo->prepare("SELECT * FROM `client_status` WHERE `id` = ? 
        AND `date_time` BETWEEN ? AND ? ORDER BY `date_time` ASC");
        $stmt2->execute([$row["id"], $FilterFrom, $FilterTo]);
        $first_on = FALSE;
        $t_d = 0;
        $t_h = 0;
        $t_m = 0;
        $t_s = 0;
        $last_status = "OFF";
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
        echo $t_d, " Days ";
        echo $t_h, " Hours ";
        echo $t_m, " Minutes ";
        echo $t_s, " Seconds ";
        echo "</p>";

        echo "
                <p>CPU: <br>• " . $row["cpu"] . "</p>
                <p>I-GPU: <br>• " . $row["igpu"] . "</p>
                <p>E-GPU: <br>• " . $row["egpu"] . "</p>
                <p>RAM: <br>• " . $row["ram"] . " GB</p>
                <p>Memory: <br>• " . $row["mem"] . " GB</p>

                <p>IP address: <br>";
        $str = $row["ip"];
        $b = 0;
        for ($i = 0; $i < strlen($str); $i++) {
            if ($str[$i] == '/') {
                echo "• ";
                echo substr($str, $b, ($i - $b));
                if ($i < strlen($str) - 1) {
                    echo "<br>";
                }
                $b = $i + 1;
            }
        }

        echo "</p><p>MAC address: <br>";
        $str = $row["mac"];
        $b = 0;
        for ($i = 0; $i < strlen($str); $i++) {
            if ($str[$i] == '/') {
                echo "• ";
                echo substr($str, $b, ($i - $b));
                if ($i < strlen($str) - 1) {
                    echo "<br>";
                }
                $b = $i + 1;
            }
        }

        echo "</p>";
        echo "<div id='client-apps-" . $row["id"] . "'>";
        echo "<p>Installed apps:   ";
        echo "<button type='button' onclick=getClientApps(" . $row["id"] . ")>Show</button>";
        echo "</p></div></div>";
    }
}
