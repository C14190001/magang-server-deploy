<?php
include 'config.php';
date_default_timezone_set('Asia/Jakarta');

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
    echo "<script>window.location.href='login.php';</script>";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_unset();
    session_destroy();
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    html,
    body {
        height: 100%;
    }

    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: left;
        vertical-align: text-top;
        padding: 5px;
    }
</style>
<script src="jquery.min.js"></script>
<script>
    //PDO
    function updateClient(clientId) {
        $.ajax({
            type: "POST",
            url: "clientUpdate.php",
            data: ({
                Id: clientId,
            }),
        }).done(function(msg) {
            alert(msg);
        });
    }

    //PDO
    function refreshClient(clientId) {
        document.getElementById(clientId).innerHTML = "<p>Loading...</p>";
        $.ajax({
            type: "POST",
            url: "refreshClient.php",
            data: ({
                Id: clientId,
            }),
        }).done(function(msg) {
            document.getElementById(clientId).innerHTML = msg;
        });
    }

    //PDO
    function getClientApps(clientButtonId) {
        $btnId = "client-apps-";
        $btnId += clientButtonId;
        document.getElementById($btnId).innerHTML = "<p>Loading apps...</p>";
        $.ajax({
            type: "POST",
            url: "getClientApps.php",
            data: ({
                Id: clientButtonId,
            }),
        }).done(function(msg) {
            document.getElementById($btnId).innerHTML = msg;
        });
    }

    //PDO
    function showClientDetails(clientId) {
        document.getElementById("client_details").innerHTML = "Loading...";
        $.ajax({
            type: "POST",
            url: "getClientDetails.php",
            data: ({
                clientId: clientId,
            }),
        }).done(function(msg) {
            document.getElementById("client_details").innerHTML = msg;
        });
    }

    function showClientDetails2(clientId, From, To) {
        document.getElementById("client_details").innerHTML = "Loading...";
        $.ajax({
            type: "POST",
            url: "getClientDetails2.php",
            data: ({
                clientId: clientId,
                from: From,
                to: To,
            }),
        }).done(function(msg) {
            document.getElementById("client_details").innerHTML = msg;
        });
    }

    //PDO
    function clientFilterByTime() {
        let FilterFrom = document.getElementById("filterbyTime_From").value;
        let FilterTo = document.getElementById("filterbyTime_To").value;
        if (FilterFrom == "" || FilterTo == "") {
            alert("Please fill out the date time first!")
        } else {
            document.getElementById("client_list").innerHTML = "Loading...";
            FilterFrom = FilterFrom.replace("T", " ");
            FilterTo = FilterTo.replace("T", " ");
            $.ajax({
                type: "POST",
                url: "filterByTime2.php", //FilterByTime2.php (Tunjukkan List)
                data: ({
                    From: FilterFrom,
                    To: FilterTo,
                }),
            }).done(function(msg) {
                document.getElementById("client_tilte").innerHTML = "Showing clients from " + FilterFrom + " to " + FilterTo + "";
                document.getElementById("client_list").innerHTML = msg;
                document.getElementById("clientDownloadBtn").innerHTML = "";
                document.getElementById("client_details").innerHTML = "Select client on the left for details.";
            });
        }
    }
</script>

<body>
    <form class="form-inline" method="post">
        <?php
        echo "<table style='width:100%;'><tr><th style='width:75%'>";
        echo "Client Dashboard. Welcome, " . $_SESSION["user"] . "!</th><td>";
        echo "<input type='submit' value='Logout' style='width:100%'></input></td><td>";
        echo "<input type='button' onclick='window.location.reload();' value='Refresh All' style='width:100%'></input></td></tr></table>";
        ?>
    </form>
    <form action='clientDownloadFilterByTime.php' method='POST' target="_blank">
        <table style='width:100%;'>
            <tr>
                <td>
                    Filter by time range
                </td>
                <td style="text-align: center;">
                    From
                    <?php
                    echo "<input type='datetime-local' name='From' id='filterbyTime_From' max='" . date('Y-m-d H:i') . "' required></input>";
                    ?>
                    to
                    <?php
                    echo "<input type='datetime-local' name='To' id='filterbyTime_To' max='" . date('Y-m-d H:i') . "' required ></input>";
                    ?>
                </td>
                <td>
                    <input type='button' onclick='clientFilterByTime()' value='Filter' style='width:100%'></input>
                </td>
                <td>
                    <input type='submit' value='Download .CSV (Filtered)' style='width:100%'></input>
                </td>
            </tr>
        </table>
    </form>
    <br>
    <table style="width:100%;">
        <caption id='client_tilte'>Showing all clients</caption>
        <tr>
            <td colspan="2">
                <div id='clientDownloadBtn'>
                    <form action='clientDownloadMain.php'>
                        <input type='submit' value='Download .CSV' style='width:100%'></input>
                    </form>
                </div>
            </td>
        </tr>
        <tr>
            <th>Clients</th>
            <th style="width:80%">Details</th>
        </tr>
        <tr>
            <td id='client_list'>
                <?php
                $stmt = $pdo->prepare("SELECT `clients`.`id` AS 'id', 
                 `client_specs`.`name` AS 'name',
                 `client_specs`.`ip` AS 'ip'
                 FROM clients
                 INNER JOIN `client_specs` ON `client_specs`.`id` = `clients`.`id`");
                $stmt->execute();
                foreach ($stmt as $row) {
                    $subs_ip = "";
                    $str = $row["ip"];
                    $b = 0;
                    for ($i = 0; $i < strlen($str) && $i < 25; $i++) {
                        if ($str[$i] == '/') {
                            $subs_ip = $subs_ip . substr($str, $b, ($i - $b));
                            if ($i < strlen($str) - 1) {
                                $subs_ip = $subs_ip . ", ";
                            }
                            $b = $i + 1;
                        }
                        if ($i >= 24) {
                            $subs_ip = $subs_ip . "...";
                        }
                    }
                    echo '<input type="button" onclick=showClientDetails("' . $row['id'] . '");
                        style="width:100%; text-align: left;"
                        value="[' . $row['id'] . '] ' . $row['name'] . ' (' . $subs_ip . ')"></input>';
                    echo '<br><br>';
                }
                ?>
            </td>
            <td id='client_details'>
                Select client on the left for details.
            </td>
        </tr>
    </table>
</body>

</html>