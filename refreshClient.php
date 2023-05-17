<?php
include 'config.php';
session_start();
if (!isset($_SESSION["user"])) {
    
} else {
    $cId = $_POST["Id"];
    $conn = new mysqli($ServerIP, $Username, $Password, $DbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `clients`.`id` AS 'id', 
        `clients`.`updated?` AS 'update',
        `client_specs`.`name` AS 'name',
        `client_specs`.`cpu` AS 'cpu',
        `client_specs`.`i-gpu` AS 'igpu',
        `client_specs`.`e-gpu` AS 'egpu',
        `client_specs`.`ram` AS 'ram',
        `client_specs`.`memory` AS 'mem',
        `client_specs`.`ip` AS 'ip',
        `client_specs`.`mac` AS 'mac'
        FROM clients LEFT JOIN client_specs ON `clients`.`id` = `client_specs`.`id`
        WHERE `clients`.`id` = " . $cId;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
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
            $conn2 = new mysqli($ServerIP, $Username, $Password, $DbName);
            if ($conn2->connect_error) {
                die("Connection failed: " . $conn2->connect_error);
            }
            $sql2 = "SELECT `client_status`.`status` AS 'status',
                        `client_status`.`date_time` AS `dt`
                        FROM `client_status` WHERE `client_status`.`id` = '" . $row["id"] . "'
                        ORDER BY `date_time` DESC LIMIT 1";
            $result2 = $conn2->query($sql2);
            if ($result2->num_rows > 0) {
                while ($row2 = $result2->fetch_assoc()) {
                    if ($row2["status"] == "ON") {
                        //Get last on
                        $last_on = new DateTime($row2["dt"]);

                        //Get current time
                        $conn3 = new mysqli($ServerIP, $Username, $Password, $DbName);
                        if ($conn3->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        $sql3 = "SELECT CURRENT_TIMESTAMP as 'dt'";
                        $result3 = $conn3->query($sql3);
                        if ($result3->num_rows > 0) {
                            while ($row3 = $result3->fetch_assoc()) {
                                $curr_time = new DateTime($row3["dt"]);
                            }
                        }
                        $conn3->close();

                        //Subtract time
                        $total_uptime = $last_on->diff($curr_time);
                        echo $total_uptime->format("%d Days %H Hours %i Minutes %s Seconds");
                        echo " (ON)";
                    } else if ($row2["status"] == "OFF") {
                        //Get last OFF
                        $last_off = new DateTime($row2["dt"]);

                        //Get last ON
                        $conn3 = new mysqli($ServerIP, $Username, $Password, $DbName);
                        if ($conn3->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        $sql3 = "SELECT `client_status`.`date_time` AS 'dt' FROM `client_status`
                            WHERE `client_status`.`id` = '" . $row["id"] . "' AND `client_status`.`status` = 'ON'
                            ORDER BY `date_time` DESC LIMIT 1";
                        $result3 = $conn3->query($sql3);
                        if ($result3->num_rows > 0) {
                            while ($row3 = $result3->fetch_assoc()) {
                                $last_on = new DateTime($row3["dt"]);
                            }
                        }
                        $conn3->close();

                        //Subtract time
                        $total_uptime = $last_off->diff($last_on);
                        echo $total_uptime->format("%d Days %H Hours %i Minutes %s Seconds");
                        echo " (OFF)";
                    }
                }
            }
            $conn2->close();
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
    $conn->close();
}
