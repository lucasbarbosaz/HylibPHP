<?php

function Redirect($url, $local = true) {
    ob_start();

    if ($url == 'reload') {
        header('Refresh: 0');
    } else if ($local == true || $local == null) {
        $goto = $url;
        header('Location: ' . $goto);
    } else {
        $goto = ($local) ? URL . $url : $url;
        header('Location: ' . $goto);
    }

    ob_end_flush();
}

function encrypt($data)
{
    $key  = "secret";
    $data = serialize($data);
    $td   = mcrypt_module_open(MCRYPT_DES, "", MCRYPT_MODE_ECB, "");
    $iv   = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td, $key, $iv);
    $data = base64_encode(mcrypt_generic($td, '!' . $data));
    mcrypt_generic_deinit($td);
    return $data;
}

function decrypt($data)
{
    $key = "secret";
    $td  = mcrypt_module_open(MCRYPT_DES, "", MCRYPT_MODE_ECB, "");
    $iv  = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td, $key, $iv);
    $data = mdecrypt_generic($td, base64_decode($data));
    mcrypt_generic_deinit($td);
    if (substr($data, 0, 1) != '!')
        return false;
    $data = substr($data, 1, strlen($data) - 1);
    return unserialize($data);
}

function CurrentURLPath($type = null) {
    if ($type == null || $type == '1') {
        $url = parse_url(URL_ATUAL, PHP_URL_PATH);
        $url = str_replace('/', '', $url);
    } else if ($type == '2') {
        $url = parse_url(URL_ATUAL, PHP_URL_PATH);
    }  

    return $url;
}

function GenerateRandom($type = "sso", $length = 0)
{
    switch ($type) {
        case "sso":
        $data = GenerateRandom("random", 8) . "-" . GenerateRandom("random", 4) . "-" . GenerateRandom("random", 4) . "-" . GenerateRandom("random", 4) . "-" . GenerateRandom("random", 12);
        return $data;
        break;
        case "app_key":
        $data = strtoupper(GenerateRandom("random", 32)) . ".resin-fe-" . GenerateRandom("random_number", 1);
        return $data;
        break;
        case "random":
        $data     = "";
        $possible = "0123456789abcdefghijklmnopqrstuvxwyz";
        $i        = 0;
        while ($i < $length) {
            $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
            $data .= $char;
            $i++;
        }
        return $data;
        break;
        case "random_number":
        $data     = "";
        $possible = "0123456789";
        $i        = 0;
        while ($i < $length) {
            $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
            $data .= $char;
            $i++;
        }
        return $data;
        break;
    }
}

function str_noaccents($string) {
    $word = $string;
    $word = preg_replace('#Ç#', 'C', $word);
    $word = preg_replace('#ç#', 'c', $word);
    $word = preg_replace('#è|é|ê|ë#', 'e', $word);
    $word = preg_replace('#È|É|Ê|Ë#', 'E', $word);
    $word = preg_replace('#à|á|â|ã|ä|å#', 'a', $word);
    $word = preg_replace('#@|À|Á|Â|Ã|Ä|Å#', 'A', $word);
    $word = preg_replace('#ì|í|î|ï#', 'i', $word);
    $word = preg_replace('#Ì|Í|Î|Ï#', 'I', $word);
    $word = preg_replace('#ð|ò|ó|ô|õ|ö#', 'o', $word);
    $word = preg_replace('#Ò|Ó|Ô|Õ|Ö#', 'O', $word);
    $word = preg_replace('#ù|ú|û|ü#', 'u', $word);
    $word = preg_replace('#Ù|Ú|Û|Ü#', 'U', $word);
    $word = preg_replace('#ý|ÿ#', 'y', $word);
    $word = preg_replace('#Ý#', 'Y', $word);

    return $word;
}

function json_decode_nice($json, $assoc = FALSE){
    $json = str_replace(array("\n","\r"),"",$json);
    $json = preg_replace('/([{,]+)(\s*)([^"]+?)\s*:/','$1"$3":',$json);
    $json = preg_replace('/(,)\s*}$/','}',$json);
    
    return json_decode($json,$assoc);
}

function verifClicked($feed_id, $iduser) {
    global $db;

    $feed_id = (int)$feed_id;
    $iduser = (int)$iduser;
    $verifyLike = $db->prepare("SELECT like_id FROM cms_feed_like WHERE user_id = ? AND feed_id = ?");
    $verifyLike->bindValue(1, $iduser);
    $verifyLike->bindValue(2, $feed_id);
    $verifyLike->execute();
    $check_verifyLike = $verifyLike->rowCount();

    return ($check_verifyLike == 1) ? true : false;
}

function AddClick($feed_id, $iduser) {
    global $db;

    $feed_id = (int)$feed_id;
    $iduser = (int)$iduser;
    $updateLikes = $db->prepare("UPDATE cms_feed SET likes = likes+1 WHERE feed_id = ?");
    $updateLikes->bindValue(1, $feed_id);
    $updateLikes->execute();

    if($updateLikes) {
        $insertLike = $db->prepare("INSERT INTO cms_feed_like (user_id, feed_id) VALUES (?,?)");
        $insertLike->bindValue(1, $iduser);
        $insertLike->bindValue(2, $feed_id);
        $insertLike->execute();

        if($insertLike) {
            return true;
        } else {
            return false;
        }
    }
}

 function returnLike($feed_id) {
    global $db;

    $feed_id = (int)$feed_id;
    $selectTotalLikes = $db->prepare("SELECT likes FROM cms_feed WHERE feed_id = ?");
    $selectTotalLikes->bindValue(1, $feed_id);
    $selectTotalLikes->execute();
    $resultTotalLikes = $selectTotalLikes->fetch(PDO::FETCH_ASSOC);

    return $resultTotalLikes['likes'];
}

function deleteFeed($feed_id) {
    global $db;

    $feed_id = (int)$feed_id;
    $deletePostFeed = $db->prepare("DELETE FROM cms_feed WHERE feed_id = ?");
    $deletePostFeed->bindValue(1, $feed_id);
    $deletePostFeed->execute();

    $deleteFeedLike = $db->prepare("DELETE FROM cms_feed_like WHERE feed_id = ?");
    $deleteFeedLike->bindValue(1, $feed_id);
    $deleteFeedLike->execute();

    return $deletePostFeed;
    return $deleteFeedLike;
}

function deleteBan($id) {
    global $db;

    $id = (int)$id;
    $deleteBan = $db->prepare("DELETE FROM bans WHERE id = ?");
    $deleteBan->bindValue(1, $id);
    $deleteBan->execute();

    return $deleteBan;
}

function deleteFeedPanel($feed_id) {
    global $db;

    $feed_id = (int)$feed_id;
    $deleteFeedPanel = $db->prepare("DELETE FROM cms_feed WHERE feed_id = ?");
    $deleteFeedPanel->bindValue(1, $feed_id);
    $deleteFeedPanel->execute();

    return $deleteFeedPanel;
}
?>
