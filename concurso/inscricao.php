<?php

# db
# messagem de erro
# tirar não enviar o documento
# CREATE TABLE subscriptions2018 (id INT PRIMARY KEY AUTO_INCREMENT, firstname VARCHAR(65535) NOT NULL, secondname VARCHAR(65535) NOT NULL, rg VARCHAR(65535) NOT NULL, cpf VARCHAR(65535) NOT NULL, cep VARCHAR(65535) NOT NULL, street VARCHAR(65535) NOT NULL, street2 VARCHAR(65535), number VARCHAR(65535), area VARCHAR(65535) NOT NULL, city VARCHAR(65535) NOT NULL, state VARCHAR(2) NOT NULL, email VARCHAR(65535) NOT NULL, ddd1 VARCHAR(65535) NOT NULL, phone1 VARCHAR(65535) NOT NULL, ddd2 VARCHAR(65535), phone2 VARCHAR(65535), role VARCHAR(65535) NOT NULL, degree VARCHAR(65535) NOT NULL, institution VARCHAR(65535) NOT NULL, unity VARCHAR(65535) NOT NULL, category VARCHAR(5) NOT NULL, theme VARCHAR(65535) NOT NULL, title VARCHAR(65535) NOT NULL, date VARCHAR(65535) NOT NULL, video VARCHAR(65535) NOT NULL, summary VARCHAR(65535) NOT NULL, members VARCHAR(65535), partners VARCHAR(65535), agree VARCHAR(3) NOT NULL, pdf VARCHAR(3) NOT NULL, hashkey VARCHAR(200), status VARCHAR(65535) NOT NULL, UNIQUE(hashkey));

$Database_Name = 'instit93_concurso2018';
$Database_Username = 'instit93_con2018';
$Database_Password = 'u^i{o~U$G422';

# File upload configuration

$pdfsent = false;
$validpdf = false;
$errpdf = "";

$nodocument = false;

# Validation Variables

$status = "Preencha o formulário para se inscrever.";

$firstname = "";
$validfirstname = false;
$errfirstname = "";

$secondname = "";
$validsecondname = false;
$errsecondname = "";

$rg = "";
$validrg = false;
$errrg = "";

$cpf = "";
$validcpf = false;
$errcpf = "";

$cep = "";
$validcep = false;
$errcep = "";

$street = "";
$validstreet = false;
$errstreet = "";

$street2 = "";

$number = "";

$area = "";
$validarea = false;
$errarea = "";


$city = "";
$validcity = false;
$errcity = "";

$state = "AC";
$validstate = true;

$email = "";
$validemail= false;
$erremail = "";

$emailverify = "";
$validemailverify = false;
$erremailverify = "";

$ddd1 = "";
$validddd1 = false;
$errddd1 = "";

$phone1 = "";
$validphone1= false;
$errphone1 = "";

$ddd2 = "";
$validddd2 = false;
$errddd2 = "";

$phone2 = "";
$validphone2= false;
$errphone2 = "";

$role = "";
$validrole = false;
$errrole = "";

$degree = "";
$validdegree = false;
$errdegree = "";

$institution = "";
$validinstitution = false;
$errinstitution = "";

$unity = "";
$validunity = false;
$errunity = "";

$category = "EI";
$validcategory = true;

$theme = "";
$validtheme = false;
$errtheme = "";

$title = "";
$validtitle = false;
$errtitle = "";

$date = "";
$validdate = false;
$errdate = "";

$video = "";
$validvideo = false;
$errvideo = "";

$summary = "";
$validsummary = false;
$errsummary = "";

$members = "";
$validmembers = false;
$errmembers = "";

$partners = "";
$validpartners = false;
$errpartners = "";

$agree = false;
$erragree = "";

function validate_input($data) {
    $data = trim($data);
    # $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function printVar($name,$value) {
    return "<p>" . $name . ":" . validate_input($value) . "</p>";
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

function sendMail($email, $hash) {
    $to=$email;
    $subject='Concurso Instituto Criativo';
    $content='<!DOCTYPE html>
    <html lang="pt-BR">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Premio de educação criativa e inovadora</title>
    <style>
        body {
            font-family: sans-serif;
        }
    </style>
    </head>
    <body>
    <h3>Muito obrigado por se increver no Prêmio de Educação Criativa e Inovadora do Instituto Criativo</h3>
    <p>Registramos seu projeto em nosso sistema, agora é só aguardar o resultado!<br/>
    Seu número de matrícula do projeto é <strong>'. $hash .'</strong>.</p>
    <p>Para consultar sua inscrição, acesse <a href="http://institutocriativo.org.br/concurso">institutocriativo.org.br/concurso</a> e clique em consultar inscrição.<br/>
    É necessário apenas o CPF do responsável e o número de matrícula do projeto.</p>
    <p>Atenciosamente,<br/>
    Organização do Prêmio de Educação Criativa e Inovadora do Instituto Criativo</p>
    <p><a href="http://institutocriativo.org.br/">Instituto Criativo</a></p>
    </body>
    </html>';
    $headers='From: Concurso2018 <concurso2018@institutocriativo.org.br>' . "\r\n";
    $headers.='Reply-To: Concurso2018 <concurso2018@institutocriativo.org.br>' . "\r\n";
    $headers.='Bcc: Concurso2018 <concurso2018@institutocriativo.org.br>' . "\r\n";
    $headers.='X-Mailer: PHP/' . phpversion() ."\r\n";
    $headers.= 'MIME-Version: 1.0' . "\r\n";
    $header .= "Content-Transfer-Encoding: 8bit \r\n";
    $header .= "Date: ".date("r (T)")." \r\n";
    $headers.= 'Content-type: text/html; charset=UTF-8 '. "\r\n";

    if (mail($to, $subject, $content, $headers)) {
    return "Sua matrícula foi concluída. Email enviado para <" . $email . ">, pode demorar até 30 minutos para chegar. Por favor checar sua caixa de spam caso ele não apareça na caixa principal.";
    } else {
    return "Sua matrícula foi concluída, mas ocorreu um erro ao enviar o email de confirmação. A matrícula do seu projeto é " . $hash . " e pode acompanhar-lo na seção de 'consultar inscrição' apresentando o seu CPF. Por favor, anote a matrícula em algum lugar seguro.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = "Por favor revisar o formulário, corrigir os alertas e clicar em finalizar inscrição novamente. Caso tenha enviado o documento PDF, selecione o arquivo novamente.";
    $firstname = validate_input($_POST["firstname"]);
    if(is_string($firstname) and $firstname != "") {
        $validfirstname = true;
    } else {
        $errfirstname = "Primeiro nome em branco.";
    }
    $secondname = validate_input($_POST["secondname"]);
    if(is_string($secondname) and $secondname != "") {
        $validsecondname = true;
    } else {
        $errsecondname = "Segundo nome em branco.";
    }
    $rg = validate_input($_POST["rg"]);
    if(is_string($rg) and $rg != "") {
        $validrg = true;
    } else {
        $errrg = "RG em branco.";
    }
    $cpf = validate_input($_POST["cpf"]);
    if(is_string($cpf) and $cpf != "" and !(preg_match("/[^0123456789]/", $cpf)) and verifycpf($cpf)) {
        $validcpf = true;
    } else {
        $errcpf = "CPF inválido.";
    }
    $cep = validate_input($_POST["cep"]);
    if(is_string($cep) and $cep != "" and !(preg_match("/[^0123456789]/", $cep)) and strlen($cep) == 8) {
        $validcep = true;
    } else {
        $errcep = "CEP inválido.";
    }
    $street = validate_input($_POST["street"]);
    if(is_string($street) and $street != "") {
        $validstreet = true;
    } else {
        $errstreet = "Logradouro em branco.";
    }
    $number = validate_input($_POST["number"]);
    $street2 = validate_input($_POST["street2"]);
    $area = validate_input($_POST["area"]);
    if(is_string($area) and $area != "") {
        $validarea = true;
    } else {
        $errarea = "Bairro em branco.";
    }
    $city = validate_input($_POST["city"]);
    if(is_string($city) and $city != "") {
        $validcity = true;
    } else {
        $errcity = "Cidade em branco.";
    }
    $statecode = validate_input($_POST["state"]);
    if(is_string($statecode) and $statecode != "") {
        switch ($statecode) {
            case "AC" :
                $state = "AC";
                break;
            case "AL" :
                $state = "AL";
                break;
            case "AP" :
                $state = "AP";
                break;
            case "AM" :
                $state = "AM";
                break;
            case "BA" :
                $state = "BA";
                break;
            case "CE" :
                $state = "CE";
                break;
            case "DF" :
                $state = "DF";
                break;
            case "ES" :
                $state = "ES";
                break;
            case "GO" :
                $state = "GO";
                break;
            case "MA" :
                $state = "MA";
                break;
            case "MT" :
                $state = "MT";
                break;
            case "MS" :
                $state = "MS";
                break;
            case "MG" :
                $state = "MG";
                break;
            case "PA" :
                $state = "PA";
                break;
            case "PB" :
                $state = "PB";
                break;
            case "PR" :
                $state = "PR";
                break;
            case "PE" :
                $state = "PE";
                break;
            case "PI" :
                $state = "PI";
                break;
            case "RJ" :
                $state = "RJ";
                break;
            case "RN" :
                $state = "RN";
                break;
            case "RS" :
                $state = "RS";
                break;
            case "RO" :
                $state = "RO";
                break;
            case "RR" :
                $state = "RR";
                break;
            case "SC" :
                $state = "SC";
                break;
            case "SP" :
                $state = "SP";
                break;
            case "SE" :
                $state = "SE";
                break;
            case "TO" :
                $state = "TO";
                break;
            default:
                $state = "AC";
                break;
        }
    }
    $email = validate_input($_POST["email"]);
    if(is_string($email) and $email != "" and filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validemail = true;
    } else {
        $erremail = "E-mail inválido.";
    }
    $emailverify = validate_input($_POST["emailverify"]);
    if(is_string($emailverify) and $emailverify == $email) {
        $validemailverify = true;
    } else {
        $erremailverify = "E-mails não coincidem.";
    }
    $ddd1 = validate_input($_POST["ddd1"]);
    if(is_string($ddd1) and $ddd1 != "" and !(preg_match("/[^0123456789]/", $ddd1)) and strlen($ddd1) == 2) {
        $validddd1 = true;
    } else {
        $errddd1 = "DDD inválido.";
    }
    $phone1 = validate_input($_POST["phone1"]);
    if(is_string($phone1) and $phone1 != "" and !(preg_match("/[^0123456789]/", $phone1)) and (strlen($phone1) == 8 or strlen($phone1) == 9)) {
        $validphone1 = true;
    } else {
        $errphone1 = "Telefone inválido.";
    }
    $ddd2 = validate_input($_POST["ddd2"]);
    if((is_string($ddd2) and $ddd2 != "" and !(preg_match("/[^0123456789]/", $ddd2)) and strlen($ddd2) == 2) or strlen($ddd2) == 0) {
        $validddd2 = true;
    } else {
        $errddd2 = "DDD inválido.";
    }
    $phone2 = validate_input($_POST["phone2"]);
    if((is_string($phone2) and $phone2 != "" and !(preg_match("/[^0123456789]/", $phone2)) and (strlen($phone2) == 8 or strlen($phone2) == 9)) or strlen($phone2) == 0) {
        $validphone2 = true;
    } else {
        $errphone2 = "Telefone inválido.";
    }
    $role = validate_input($_POST["role"]);
    if(is_string($role) and $role != "") {
        $validrole = true;
    } else {
        $errrole = "Cargo em branco.";
    }
    $degree = validate_input($_POST["degree"]);
    if(is_string($degree) and $degree != "") {
        $validdegree = true;
    } else {
        $errdegree = "Formação em branco.";
    }
    $institution = validate_input($_POST["institution"]);
    if(is_string($institution) and $institution != "") {
        $validinstitution = true;
    } else {
        $errinstitution = "Instituição em branco.";
    }
    $unity = validate_input($_POST["unity"]);
    if(is_string($unity) and $unity != "") {
        $validunity = true;
    } else {
        $errunity = "Unidade em branco.";
    }
    $categorycode = validate_input($_POST["category"]);
    if(is_string($categorycode) and $categorycode != "") {
        switch ($categorycode) {
            case "EI":
                $category = "EI";
                break;
            case "EFI":
                $category = "EFI";
                break;
            case "EFII":
                $category = "EFII";
                break;
            case "EM":
                $category = "EM";
                break;
            case "EJA":
                $category = "EJA";
                break;
            case "ES":
                $category = "ES";
                break;
            case "XA":
                $category = "XA";
                break;
            case "HI":
                $category = "HI";
                break;
            default:
                $category = "EI";
        }
    }
    if (isset($_FILES["pdfdocument"])) {
        $file = $_FILES["pdfdocument"];
        $pdfsent = true;
        $pdf_path = "pdf2018/";
        $pdf_name = $cpf . $category . ".pdf";
        $extension = pathinfo(strtolower(basename($file['name'])), PATHINFO_EXTENSION);
        $validpdfname = true;
        if (file_exists($pdf_path . $pdf_name)) {
            $validpdfname = false;
            $errpdf = "Erro interno";
        }
        $validpdfsize = false;
        if ($file["size"] < 5000000) {
            $validpdfsize = true;
        } else {
            $errpdf = "Arquivo muito grande.";
        }
        $validpdfextension = false;
        if ($extension == "pdf") {
            $validpdfextension = true;
        } else {
            $errpdf = "Favor enviar um arquivo PDF.";
        }
        if ($validpdfname and $validpdfextension and $validpdfsize) $validpdf = true;
    }
    $theme = validate_input($_POST["theme"]);
    if(is_string($theme) and $theme != "") {
        $validtheme = true;
    } else {
        $errtheme = "Tema em branco.";
    }
    $title = validate_input($_POST["title"]);
    if(is_string($title) and $title != "") {
        $validtitle = true;
    } else {
        $errtitle = "Título em branco.";
    }
    $date = validate_input($_POST["date"]);
    if(is_string($date) and $date != "") {
        $validdate = true;
    } else {
        $errdate = "Data inválida.";
    }
    $video = validate_input($_POST["video"]);
    if (is_string($video) and $video != "" and filter_var($video, FILTER_VALIDATE_URL)) {
        $validvideo = true; 
    } else {
        $errvideo = "Link inválido.";
    }
    $summary = validate_input($_POST["summary"]);
    if (is_string($summary) and $summary != "" and count(preg_split('/\s+/i', trim(preg_replace('/[^A-Z0-9ãõçâêôáéíóúàü\-]/i', " ", $summary)))) < 250) {
        $validsummary = true; 
    } else {
        $errsummary = "Resumo contém palavras demais ou é inválido.";
    }
    if (isset($_POST["agree"]) and $_POST["agree"] == "1") {
        $agree = true;
    } else {
        $erragree = "Caixa de ciência dos termos não foi marcada.";
    }
    $partners = validate_input($_POST["partners"]);
    $members = validate_input($_POST["members"]);
    
    if($validfirstname and $validsecondname and $validrg and $validcpf and $validcep and $validstreet and $validarea and $validcity and $validstate and $validemail and $validemailverify and $validddd1 and $validphone1 and $validddd2 and $validphone2 and $validrole and $validdegree and $validinstitution and $validunity and $validcategory and $validtheme and $validtitle and $validdate and $validvideo and $validsummary and $agree and ($validpdf or $nodocument)) {
        $status = "Ocorreu um erro e sua matrícula não pode ser concluída, por favor, contate concurso2018@institutocriativo.org.br com o assunto 'Erro de conexão' relatando o ocorrido.";
        $Database_connection = mysqli_connect("localhost", $Database_Username, $Database_Password, $Database_Name);
        if($Database_connection === false) {
            $status = "Ocorreu um erro e sua matrícula não pode ser concluída, por favor, contate concurso2018@institutocriativo.org.br com o assunto 'Erro de conexão' relatando o ocorrido.";
        } else {
            $hash = $cpf . $category;
            mysqli_set_charset($Database_connection,"utf8");
            $sql = 'INSERT INTO subscriptions2018 (firstname , secondname, rg, cpf, cep, street, street2, 
            number, area, city, state, email, ddd1, phone1, ddd2, phone2, role, degree, institution, 
            unity, category, theme, title, date, video, summary, members, partners, agree, pdf, hashkey, status) 
            VALUES ("'. $Database_connection->real_escape_string($firstname) .'",
            "'. $Database_connection->real_escape_string($secondname) .'",
            "'. $Database_connection->real_escape_string($rg) .'",
            "'. $Database_connection->real_escape_string($cpf) .'",
            "'. $Database_connection->real_escape_string($cep) .'",
            "'. $Database_connection->real_escape_string($street) .'",
            "'. $Database_connection->real_escape_string($street2) .'",
            "'. $Database_connection->real_escape_string($number) .'",
            "'. $Database_connection->real_escape_string($area) .'",
            "'. $Database_connection->real_escape_string($city) .'",
            "'. $Database_connection->real_escape_string($state) .'",
            "'. $Database_connection->real_escape_string($email) .'",
            "'. $Database_connection->real_escape_string($ddd1) .'",
            "'. $Database_connection->real_escape_string($phone1) .'",
            "'. $Database_connection->real_escape_string($ddd2) .'",
            "'. $Database_connection->real_escape_string($phone2) .'",
            "'. $Database_connection->real_escape_string($role) .'",
            "'. $Database_connection->real_escape_string($degree) .'",
            "'. $Database_connection->real_escape_string($institution) .'",
            "'. $Database_connection->real_escape_string($unity) .'",
            "'. $Database_connection->real_escape_string($category) .'",
            "'. $Database_connection->real_escape_string($theme) .'",
            "'. $Database_connection->real_escape_string($title) .'",
            "'. $Database_connection->real_escape_string($date) .'",
            "'. $Database_connection->real_escape_string($video) .'",
            "'. $Database_connection->real_escape_string($summary) .'",
            "'. $Database_connection->real_escape_string($members) .'",
            "'. $Database_connection->real_escape_string($partners) .'",
            "'. $Database_connection->real_escape_string(($agree)?"1":"0") .'",
            "'. $Database_connection->real_escape_string(($nodocument)?"1":"0") .'",
            "'. $Database_connection->real_escape_string($hash) .'", "Enviado");';
            if(mysqli_query($Database_connection, $sql)){
                $status = "Sua inscrição foi incluida em nosso sistema, mas não foi possível concluir-la, por favor, contate concurso2018@institutocriativo.org.br com o assunto 'Inscrição não conluída' relatando o ocorrido.";
                $subscriptionquery = mysqli_query($Database_connection, 'SELECT id FROM subscriptions2018 WHERE hashkey LIKE "' . $hash . '";');
                $subscriptionrow = mysqli_fetch_assoc($subscriptionquery);
                $subscriptionid = $subscriptionrow["id"] + 100;
                if (!$nodocument) {
                    if (move_uploaded_file($file["tmp_name"], $pdf_path . $pdf_name)) {
                        $status = sendMail($email, $subscriptionid);
                    } else {
                        $status = "Sua inscrição foi quase concluída, mas ocorreu um erro ao salvar seu arquivo pdf, por favor, contate concurso2018@institutocriativo.org.br com o assunto 'Erro ao salvar documento' relatando o ocorrido, o documento em anexo, CPF e a categoria do seu projeto.";
                    }
                } else {
                    $status = sendMail($email, $subscriptionid);
                }
            } else{
                $status = "Você já inscreveu um projeto nessa categoria, pelo regulamento, só pode inscrever outros projetos em outras categorias.";
            }
        }
        
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
<form method="post" action="inscricao.php" enctype="multipart/form-data">
    <h1>Inscrição</h1>
    <h3><?php echo htmlspecialchars($status);?></h3>
    <p class="error">! = campo obrigatório</p>
    <h2>Dados do responsável</h2>
    <p>Primeiro nome (ex: João):</p>
    <input type="text" name="firstname" value="<?php echo $firstname;?>"/>
    <p class="error">! <?php echo $errfirstname; ?></p>
    <p>Segundo nome (ex: Silveira Silva):</p>
    <input type="text" name="secondname" value="<?php echo $secondname;?>"/>
    <p class="error">! <?php echo $errsecondname; ?></p>
    <p>RG ou RNE (ex: 00.000.000-0):</p>
    <input type="text" name="rg" value="<?php echo $rg?>"/>
    <p class="error">! <?php echo $errrg; ?></p>
    <p>CPF (somente números):</p>
    <input type="text" name="cpf" value="<?php echo $cpf?>"/>
    <p class="error">! <?php echo $errcpf; ?></p>
    <h3>Endereço:</h3>
    <p>CEP (somente números):</p>
    <input type="text" name="cep" value="<?php echo $cep?>"/>
    <p class="error">! <?php echo $errcep; ?></p>
    <p>Logradouro:</p>
    <input type="text" name="street" value="<?php echo $street?>"/>
    <p class="error">! <?php echo $errstreet; ?></p>
    <p>Número:</p>
    <input type="text" name="number" value="<?php echo $number?>"/>
    <p class="error"></p>
    <p>Complemento:</p>
    <input type="text" name="street2" value="<?php echo $street2?>"/>
    <p class="error"></p>
    <p>Bairro:</p>
    <input type="text" name="area" value="<?php echo $area?>"/>
    <p class="error">! <?php echo $errarea; ?></p>
    <p>Cidade:</p>
    <input type="text" name="city" value="<?php echo $city?>"/>
    <p class="error">! <?php echo $errcity; ?></p>
    <p>Estado:</p>
    <select name="state">
        <option value="AC" <?php if($state == "AC") echo "selected"; ?>>AC</option>
        <option value="AL" <?php if($state == "AL") echo "selected"; ?>>AL</option>
        <option value="AP" <?php if($state == "AP") echo "selected"; ?>>AP</option>
        <option value="AM" <?php if($state == "AM") echo "selected"; ?>>AM</option>
        <option value="BA" <?php if($state == "BA") echo "selected"; ?>>BA</option>
        <option value="CE" <?php if($state == "CE") echo "selected"; ?>>CE</option>
        <option value="DF" <?php if($state == "DF") echo "selected"; ?>>DF</option>
        <option value="ES" <?php if($state == "ES") echo "selected"; ?>>ES</option>
        <option value="GO" <?php if($state == "GO") echo "selected"; ?>>GO</option>
        <option value="MA" <?php if($state == "MA") echo "selected"; ?>>MA</option>
        <option value="MT" <?php if($state == "MT") echo "selected"; ?>>MT</option>
        <option value="MS" <?php if($state == "MS") echo "selected"; ?>>MS</option>
        <option value="MG" <?php if($state == "MG") echo "selected"; ?>>MG</option>
        <option value="PA" <?php if($state == "PA") echo "selected"; ?>>PA</option>
        <option value="PB" <?php if($state == "PB") echo "selected"; ?>>PB</option>
        <option value="PR" <?php if($state == "PR") echo "selected"; ?>>PR</option>
        <option value="PE" <?php if($state == "PE") echo "selected"; ?>>PE</option>
        <option value="PI" <?php if($state == "PI") echo "selected"; ?>>PI</option>
        <option value="RJ" <?php if($state == "RJ") echo "selected"; ?>>RJ</option>
        <option value="RN" <?php if($state == "RN") echo "selected"; ?>>RN</option>
        <option value="RS" <?php if($state == "RS") echo "selected"; ?>>RS</option>
        <option value="RO" <?php if($state == "RO") echo "selected"; ?>>RO</option>
        <option value="RR" <?php if($state == "RR") echo "selected"; ?>>RR</option>
        <option value="SC" <?php if($state == "SC") echo "selected"; ?>>SC</option>
        <option value="SP" <?php if($state == "SP") echo "selected"; ?>>SP</option>
        <option value="SE" <?php if($state == "SE") echo "selected"; ?>>SE</option>
        <option value="TO" <?php if($state == "TO") echo "selected"; ?>>TO</option>
    </select>
    <p class="error">!</p>
    <h3>Contato:</h3>
    <p>E-mail:</p>
    <input type="text" name="email" value="<?php echo $email;?>"/>
    <p class="error">! <?php echo $erremail;?></p>
    <p>Repetir e-mail:</p>
    <input type="text" name="emailverify"  value="<?php echo $emailverify;?>"/>
    <p class="error">! <?php echo $erremailverify;?></p>
    <p>Telefone principal (Apenas números):</p>
    (0<input type="text" class="ddd" name="ddd1" value="<?php echo $ddd1;?>"/>)
    <input type="text" class="phone" name="phone1"  value="<?php echo $phone1;?>"/>
    <p class="error">! <?php echo $errddd1 . $errphone1;?></p>
    <p>Telefone secundário  (Apenas números):</p>
    (0<input type="text" class="ddd" name="ddd2" value="<?php echo $ddd2;?>"/>)
    <input type="text" class="phone" name="phone2" value="<?php echo $phone2;?>"/>
    <p class="error"><?php echo $errddd2 . $errphone2;?></p>
    <p>Cargo:</p>
    <input type="text" name="role" value="<?php echo $role;?>"/>
    <p class="error">! <?php echo $errrole;?></p>
    <p>Formação Acadêmica:</p>
    <input type="text" name="degree" value="<?php echo $degree;?>"/>
    <p class="error">! <?php echo $errdegree;?></p>
    <h3>Comprovante de docência, discente ou certificado de hipnoterapeuta</h3>
    <p>Documento no formato PDF com tamanho máximo de 5MB</p>
    <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
    <input type="file" name="pdfdocument"/>
    <p class="error">! <?php echo $errpdf; ?></p>
    <h2>Dados da Instituição</h2>
    <p>Nome da instituição:</p>
    <input type="text" name="institution" value="<?php echo $institution;?>"/>
    <p class="error">! <?php echo $errinstitution; ?></p>
    <p>Unidade administrativa:</p>
    <input type="text" name="unity" value="<?php echo $unity;?>"/>
    <p class="error">! <?php echo $errunity; ?></p>
    <h2>Dados do Projeto</h2>
    <p>Categoria do projeto:</p>
    <select name="category">
        <option value="EI" <?php if($category == "EI") echo "selected"; ?>>Educação Infantil</option>
        <option value="EFI" <?php if($category == "EFI") echo "selected"; ?>>Educação Fundamental I</option>
        <option value="EFII" <?php if($category == "EFII") echo "selected"; ?>>Educação Fundamental II</option>
        <option value="EM" <?php if($category == "EM") echo "selected"; ?>>Ensino Médio</option>
        <option value="EJA" <?php if($category == "EJA") echo "selected"; ?>>Educação de Jovens e Adultos</option>
        <option value="ES" <?php if($category == "ES") echo "selected"; ?>>Ensino Superior</option>
        <option value="XA" <?php if($category == "XA") echo "selected"; ?>>Xadrez</option>
        <option value="HI" <?php if($category == "HI") echo "selected"; ?>>Hipnoterapia</option>
    </select>
    <p class="error"></p>
    <p>Tema do projeto:</p>
    <input type="text" name="theme" value="<?php echo $theme;?>"/>
    <p class="error">! <?php echo $errtheme; ?></p>
    <p>Título da iniciativa:</p>
    <input type="text" name="title" value="<?php echo $title;?>"/>
    <p class="error">! <?php echo $errtitle; ?></p>
    <p>Data da implatação:</p>
    <span class="observation">A iniciativa deve ter no máximo 1 (um) ano de implantação, estar em implantação.</span><br/>
    <input type="date" name="date" value="<?php echo $date;?>"/>
    <p class="error">! <?php echo $errdate?></p>
    <p>Link do video ou reportagem sobre o projeto (ex: http://www.example.com/):</p>
    <input type="text" name="video" value="<?php echo $video;?>"/>
    <p class="error">! <?php echo $errvideo?></p>
    <h3>Resumo da Iniciativa:</h3>
    <span class="observation">Resumo da iniciativa com no máximo 250 palavras em parágrafo único e citando a criatividade e inovação visadas pela iniciativa.</span><br/>
    <textarea id="summary" type="text" name="summary" onkeyup="wordcount();" ><?php echo $summary;?></textarea>
    <p>Número de palavras: <span id="count"></span></p>
    <p class="error">! <?php echo $errsummary?></p>
    <p>Integrantes da equipe de desenvolvimento da iniciativa (caso haja, constar nome, CPF e cargo)</p>
    <textarea class="members" name="members"><?php echo $members;?></textarea>
    <p>Parceiros da iniciativa (caso haja)</p>
    <span class="observation">Órgãos, instituições e/ou entidades parceiras no desenvolvimento da iniciativa.</span><br/>
    <textarea class="partners" name="partners"><?php echo $partners;?></textarea>
    <p><input type="checkbox" name="agree" value="1" <?php if ($agree) echo "checked";?>/> Afirmo que li o regulamento que dispõe sobre o Concurso Cultural Prêmio Instituto Criativo de Educação, Criatividade e Inovação, a que estabelece procedimentos para as inscrições e apresentação dos trabalhos no Concurso Cultural Prêmio de Educação, Criatividade e Inovação – 2018 e todas as instruções para o preenchimento da Ficha de Inscrição e do Relato da Iniciativa. Estou ciente das regras estabelecidas e sou inteiramente responsável pelas informações prestadas.</p>
    <p class="error"><?php echo $erragree; ?></p>
    <input type="submit" class="submit" value="Finalizar inscrição"/>
    <br/>
    <br/>
</form>
<div id="header">
    <a href="index.html"><div class="anchor-button">Início</div></a>
</div>
<script>
const wordcount = () => {
    const text = document.querySelector("#summary");
    const count = document.querySelector("#count");
    count.innerText = text.value.replace(/[^A-Z0-9ãõçâêôáéíóúàü\-]/ig, " ").trim().split(/\s+/).length;
};

wordcount();
</script>
</body>
</html>
