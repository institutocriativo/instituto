<?php

$Database_Name = 'instit93_concurso2018';
$Database_Username = 'instit93_con2018';
$Database_Password = 'u^i{o~U$G422';
# Validation Variables

$cpf = "";
$validcpf = false;
$errcpf = "";

function validate_input($data) {
    $data = trim($data);
    # $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function verifycpf($cpf) {
    if(strlen($cpf) == 11 and
    $cpf != '00000000000' and
    $cpf != '11111111111' and
    $cpf != '22222222222' and
    $cpf != '33333333333' and
    $cpf != '44444444444' and
    $cpf != '55555555555' and
    $cpf != '66666666666' and
    $cpf != '77777777777' and
    $cpf != '88888888888' and
    $cpf != '99999999999') {
        $d1 = 0;
        for ($i=8; $i >= 0; $i--) {
            $d1 += $cpf{$i} * ($i + 1);
        }
        $d1 = ($d1 % 11) % 10;
        $d2 = 0;
        for ($i=8; $i >= 0; $i--) {
            $d2 += $cpf{$i} * ($i);
        }
        $d2 = (($d2 + ($d1 * 9)) % 11) % 10;
        if ($cpf{9} == $d1 and $cpf{10} == $d2) {
            return true;
        }
    }
    return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf = validate_input($_POST["cpf"]);
    if(is_string($cpf) and $cpf != "" and !(preg_match("/[^0123456789]/", $cpf)) and verifycpf($cpf)) {
        $validcpf = true;
    } else {
        $errcpf = "CPF inválido.";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <link rel="stylesheet" type="text/css" href="inscricao.css"/>
    <title>Inscrição</title>
</head>
<body>
<form method="post" action="consulta.php" enctype="multipart/form-data">
    <h1>Consulta</h1>
    <p>CPF (somente números):</p>
    <input type="text" name="cpf" value="<?php echo $cpf?>"/>
    <p class="error"><?php echo $errcpf; ?></p>
    <input type="submit" class="submit" value="Consultar Projeto"/>
    <div class="result">
    <?php
    if($validcpf) {
        $Database_connection = mysqli_connect("localhost", $Database_Username, $Database_Password, $Database_Name);
        if($Database_connection === false) {
            echo "<p>Não foi possível realizar a consulta.</p>";
        } else {
            mysqli_set_charset($Database_connection,"utf8");
            $subscriptionquery = mysqli_query($Database_connection, 'SELECT id, status FROM subscriptions2018 WHERE cpf LIKE "' . $cpf . '";');
            if(mysqli_num_rows($subscriptionquery)>0) {
                while($row = mysqli_fetch_assoc($subscriptionquery)) {
                    echo "<p> Matrícula: " . ($row["id"] + 100). ", status: " . $row["status"] . "</p>";
                }
            } else {
                echo "<p>Não foi econtrado projetos para este cpf.</p>";
            }
        }
        
    }
    ?>
    </div>
</form>
<div id="header">
    <a href="index.html"><div class="anchor-button">Início</div></a>
</div>
</script>
</body>
</html>