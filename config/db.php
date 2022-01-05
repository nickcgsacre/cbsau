<?php
//error_reporting(E_ALL ^ E_DEPRECATED ^ E_NOTICE ^ E_WARNING ^ E_STRICT);
error_reporting(1);
//if(isset($_POST['notify_box'])){ $notify = $_POST['notify_box']; }


include_once(__DIR__."/config.php");

header('Content-Type: text/html; charset=utf-8');
session_start();
// conexão com o banco		
$conexao = new PDO('mysql:host='.$server.';dbname='.$banco.'', $usuario, $senha);
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conexao->query("SET NAMES 'utf8'");
$conexao->query('SET character_set_connection=utf8');
$conexao->query('SET character_set_client=utf8');
$conexao->query('SET character_set_results=utf8');
$conexao->query('SET lc_time_names=pt_BR');
// termina conexão com o banco


// PEGA AS INFORMAÇÕES DO SITE
$stmt = $conexao->prepare('SELECT * FROM config WHERE id = :id');
$stmt->execute(array('id' => 1));
$cfg = $stmt->fetchAll()[0];

define("SSL", $cfg['certificado']);
define("TITULO_SISTEMA", "CBSAÚDE");
define("NOME_SISTEMA", "CBSAUDE");
define("URL_SISTEMA", "//localhost/cb/");
define("EMAIL", $cfg['email']);
define("CHAVE", $cfg['chave']);
define("ANALYTICS", $cfg['analytics']);
define("REGISTROS", $cfg['registros']);
define("SESSAO", $cfg['sessao']);
define("TENTATIVAS", $cfg['tentativas']);
define("VERSAO", "0.0.1");
define("TEMPO_REAL", false);
define("VALOR_UPF", $cfg['valor_upf']);
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
if($cfg['timezone'] != '') {
	date_default_timezone_set(''.$cfg['timezone'].'');
} else {
	date_default_timezone_set('America/Rio_Branco');
}

//REMOVE CARACTERES INVÁLIDOS
function slug($string, $replacement = '-') {
    $translations = array(
        '/ä|æ|ǽ/' => 'ae',
        '/ö|œ/' => 'oe',
        '/ü/' => 'ue',
        '/Ä/' => 'Ae',
        '/Ü/' => 'Ue',
        '/Ö/' => 'Oe',
        '/À|Á|Â|Ã|Ä|Å|Ǻ|Ā|Ă|Ą|Ǎ/' => 'A',
        '/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª/' => 'a',
        '/Ç|Ć|Ĉ|Ċ|Č/' => 'C',
        '/ç|ć|ĉ|ċ|č/' => 'c',
        '/Ð|Ď|Đ/' => 'D',
        '/ð|ď|đ/' => 'd',
        '/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě/' => 'E',
        '/è|é|ê|ë|ē|ĕ|ė|ę|ě/' => 'e',
        '/Ĝ|Ğ|Ġ|Ģ/' => 'G',
        '/ĝ|ğ|ġ|ģ/' => 'g',
        '/Ĥ|Ħ/' => 'H',
        '/ĥ|ħ/' => 'h',
        '/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ/' => 'I',
        '/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı/' => 'i',
        '/Ĵ/' => 'J',
        '/ĵ/' => 'j',
        '/Ķ/' => 'K',
        '/ķ/' => 'k',
        '/Ĺ|Ļ|Ľ|Ŀ|Ł/' => 'L',
        '/ĺ|ļ|ľ|ŀ|ł/' => 'l',
        '/Ñ|Ń|Ņ|Ň/' => 'N',
        '/ñ|ń|ņ|ň|ŉ/' => 'n',
        '/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ/' => 'O',
        '/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º/' => 'o',
        '/Ŕ|Ŗ|Ř/' => 'R',
        '/ŕ|ŗ|ř/' => 'r',
        '/Ś|Ŝ|Ş|Š/' => 'S',
        '/ś|ŝ|ş|š|ſ/' => 's',
        '/Ţ|Ť|Ŧ/' => 'T',
        '/ţ|ť|ŧ/' => 't',
        '/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ/' => 'U',
        '/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ/' => 'u',
        '/Ý|Ÿ|Ŷ/' => 'Y',
        '/ý|ÿ|ŷ/' => 'y',
        '/Ŵ/' => 'W',
        '/ŵ/' => 'w',
        '/Ź|Ż|Ž/' => 'Z',
        '/ź|ż|ž/' => 'z',
        '/Æ|Ǽ/' => 'AE',
        '/ß/' => 'ss',
        '/Ĳ/' => 'IJ',
        '/ĳ/' => 'ij',
        '/Œ/' => 'OE',
        '/ƒ/' => 'f'
    );

    $quotedReplacement = preg_quote($replacement, '/');

    $merge = array(
        '/[^\s\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',
        '/\\s+/' => $replacement,
        sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
    );

    $map = $translations + $merge;
    return strtolower(preg_replace(array_keys($map), array_values($map), $string));
}

///DEFINE A ROTA
$ROTA = explode(".php", $_GET['cod']);
$ROTA = implode("", $ROTA);
$ROTA = explode('/', $ROTA);