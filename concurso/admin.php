<?php
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}
include "config.php";

# Login variables

$login = false;
$detail = false;

function validate_input($data) {
    $data = trim($data);
    # $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if($session !== "" and strcmp($_COOKIE["hash"],$session) == 0) {
    $login = "true";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $method = validate_input($_POST["method"]);
    switch ($method) {
        case 'login':
            if($password !== "" and strcmp($_POST["user"], "admin") == 0 and strcmp($_POST["hash"], $password) == 0) {
                $newsession = hash("sha256", $password . time());
                $Database_connection = mysqli_connect("localhost", $Database_Username, $Database_Password, $Database_Name);
                if($Database_connection === false) {
                } else {
                    mysqli_set_charset($Database_connection,"utf8");
                    if(mysqli_query($Database_connection, 'UPDATE admin2018 SET session = "' . $newsession . '" WHERE username LIKE "admin"')) {
                        $login = true;
                    } else {
                        $status = "Error creating new session";
                    }
                }
                setcookie("hash", $newsession, time() + (60*60*24));
            }
            break;
        case 'logout':
            setcookie("hash", "", time());
            $Database_connection = mysqli_connect("localhost", $Database_Username, $Database_Password, $Database_Name);
            if($Database_connection === false) {
            } else {
                mysqli_set_charset($Database_connection,"utf8");
                if(mysqli_query($Database_connection, 'UPDATE admin2018 SET session = "" WHERE username LIKE "admin"')) {
                }
            }
            $login = false;
            break;
        case 'newpassword':
            if($_POST["oldpassword"] == $password and $_POST["user"] == "admin") {
                setcookie("hash", "", time());
                $Database_connection = mysqli_connect("localhost", $Database_Username, $Database_Password, $Database_Name);
                if($Database_connection === false) {
                } else {
                    mysqli_set_charset($Database_connection,"utf8");
                    if(mysqli_query($Database_connection, 'UPDATE admin2018 SET password = "' . $Database_connection->real_escape_string($_POST["newpassword"]) . '", session = "" WHERE username LIKE "admin"')) {
                    }
                }
                $login = false;
            }
            break;
        case 'update':
            if(isset($_POST["id"]) and !(preg_match("/[^0123456789]/", validate_input($_POST["id"])))) {
                $Database_connection = mysqli_connect("localhost", $Database_Username, $Database_Password, $Database_Name);
                if($Database_connection === false) {
                    $status =  "Error connecting to DB";
                } else {
                    mysqli_set_charset($Database_connection,"utf8");
                    if(mysqli_query($Database_connection, 'UPDATE subscriptions2018 SET status = "'. $Database_connection->real_escape_string($_POST["status"]) . '" WHERE id = ' . (validate_input($_POST["id"])-100) . ';')){
                        $status = "Status updated";
                    } else {
                        $status = "Error updating status";
                    }
                }
            } else {
                $status = "Invalid data to update";
            }
        break;
        default:
            $status = "Invalid method";
            break;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" and isset($_GET["id"]) and !(preg_match("/[^0123456789]/", $_GET["id"]))) {
    #view an specific project
    $detail = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <link rel="stylesheet" type="text/css" href="admin.css"/>
    <title>Painel de Administração</title>
</head>
<body>
<div id="container">
<?php echo $status;?>
<?php
if($login) {
    readfile("panel.htm");
    if($detail) {
        $Database_connection = mysqli_connect("localhost", $Database_Username, $Database_Password, $Database_Name);
        if($Database_connection === false) {
            echo "<p>Não foi possível realizar a consulta.</p>";
        } else {
            mysqli_set_charset($Database_connection,"utf8");
            $subscriptionquery = mysqli_query($Database_connection, 'SELECT id, firstname , secondname, rg, cpf, cep, street, street2, 
            number, area, city, state, email, ddd1, phone1, ddd2, phone2, role, degree, institution, 
            unity, category, theme, title, date, video, summary, members, partners, pdf, status FROM subscriptions2018 WHERE id LIKE "' . ($_GET["id"]-100) . '";');
            if(mysqli_num_rows($subscriptionquery)>0) {
                echo "<script>";
                while($row = mysqli_fetch_assoc($subscriptionquery)) {
                    echo "addDetailed(` " . ($row["id"] + 100). "`,`" . 
                    validate_input($row["firstname"]) . "`,`" . 
                    validate_input($row["secondname"]) . "`,`" . 
                    validate_input($row["rg"]) . "`,`" .
                    validate_input($row["cpf"]) . "`,`" . 
                    validate_input($row["cep"]) . "`,`" . 
                    validate_input($row["street"]) . "`,`" . 
                    validate_input($row["street2"]) . "`,`" . 
                    validate_input($row["number"]) . "`,`" . 
                    validate_input($row["area"]) . "`,`" . 
                    validate_input($row["city"]) . "`,`" . 
                    validate_input($row["state"]) . "`,`" . 
                    validate_input($row["email"]) . "`,`" . 
                    validate_input($row["ddd1"]) . "`,`" . 
                    validate_input($row["phone1"]) . "`,`" . 
                    validate_input($row["ddd2"]) . "`,`" . 
                    validate_input($row["phone2"]) . "`,`" . 
                    validate_input($row["role"]) . "`,`" . 
                    validate_input($row["degree"]) . "`,`" . 
                    validate_input($row["institution"]) . "`,`" . 
                    validate_input($row["unity"]) . "`,`" . 
                    validate_input($row["category"]) . "`,`" . 
                    validate_input($row["theme"]) . "`,`" . 
                    validate_input($row["title"]) . "`,`" . 
                    validate_input($row["date"]) . "`,`" . 
                    validate_input($row["video"]) . "`,`" . 
                    validate_input($row["summary"]) . "`,`" . 
                    validate_input($row["members"]) . "`,`" . 
                    validate_input($row["partners"]) . "`,`" . 
                    validate_input($row["pdf"]) . "`,`" . 
                    validate_input($row["status"]) . "`)";
                }
                echo "</script>";
            } else {
                echo "<p>Não foi econtrar o projeto especificado.</p>";
            }
        }
    } else {
        $Database_connection = mysqli_connect("localhost", $Database_Username, $Database_Password, $Database_Name);
        if($Database_connection === false) {
            echo "<p>Não foi possível realizar a consulta.</p>";
        } else {
            mysqli_set_charset($Database_connection,"utf8");
            $subscriptionquery = mysqli_query($Database_connection, 'SELECT id, title, cpf, category, status FROM subscriptions2018;');
            if(mysqli_num_rows($subscriptionquery)>0) {
                echo "<script>";
                while($row = mysqli_fetch_assoc($subscriptionquery)) {
                    echo "addProject('" . ($row["id"] + 100). "','" . $row["title"] . "','" . $row["cpf"] . "','" . $row["category"] . "','" . $row["status"] . "');";
                }
                echo "</script>";
            } else {
                echo "<p>Não foi econtrado nenhum projeto cadatrado.</p>";
            }
        }    
    }
} else {
    readfile("login.htm");
}
?>
</div>
<div id="header">
    <a href="admin.php"><div class="anchor-button">Início</div></a>
</div>
</body>
</html>