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
    $cId = $_POST["Id"];

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
    $stmt->execute([$cId]);
    foreach ($stmt as $row) {
        echo "<b>[ " . $row["id"] . " ] " . $row["name"] . " ( ";
        if ($row["update"] == "1") {
            echo " Updated ";
        } else {
            echo " Not Updated ";
        }
        echo ")</b><br><br>";
        echo "<button type='button' onclick='updateClient(" . $row["id"] . ")'>Update client</button>";
        echo "<b>   </b>";
        echo "<button type='button' onclick='refreshClient(" . $row["id"] . ")'>Refresh</button>";

        echo "<p> Uptime: <br>• ";

        //Get last Status
        $stmt2 = $pdo->prepare("SELECT `client_status`.`status` AS 'status',
        `client_status`.`date_time` AS `dt`
        FROM `client_status` WHERE `client_status`.`id` = ? AND  `client_status`.`status` = ? OR `client_status`.`status` = ?
        ORDER BY `date_time` DESC LIMIT 1");
        $stmt2->execute([$row["id"],"ON","OFF"]);
        foreach ($stmt2 as $row2) {
            if ($row2["status"] == "ON") {
                //Get last on
                $last_on = new DateTime($row2["dt"]);

                //Get current time
                $stmt3 = $pdo->prepare("SELECT CURRENT_TIMESTAMP as 'dt'");
                $stmt3->execute();
                foreach ($stmt3 as $row3) {
                    $curr_time = new DateTime($row3["dt"]);
                }

                //Subtract time
                $total_uptime = $last_on->diff($curr_time);
                echo $total_uptime->format("%d Days %H Hours %i Minutes %s Seconds");
                echo " (ON)";
            } else if ($row2["status"] == "OFF") {
                //Get last OFF
                $last_off = new DateTime($row2["dt"]);

                //Get last ON
                $stmt3 = $pdo->prepare("SELECT `client_status`.`date_time` AS 'dt' FROM `client_status`
                WHERE `client_status`.`id` = ? AND `client_status`.`status` = 'ON'
                ORDER BY `date_time` DESC LIMIT 1");
                $stmt3->execute([$row["id"]]);
                foreach ($stmt3 as $row3) {
                    $last_on = new DateTime($row3["dt"]);
                }

                //Subtract time
                $total_uptime = $last_off->diff($last_on);
                echo $total_uptime->format("%d Days %H Hours %i Minutes %s Seconds");
                echo " (OFF)";
            }
        }
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
