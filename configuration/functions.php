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


function addFurniture() {
    global $db;
    if (isset($_POST['add_furniture'])) {
        date_default_timezone_set("America/Sao_Paulo");

        // Pasta onde o arquivo vai ser salvo
        $_UP['pasta1'] = 'c:' . \DIRECTORY_SEPARATOR . 'inetpub/wwwroot/swf/hot_furni/';;
        $_UP['pasta2'] = 'c:' . \DIRECTORY_SEPARATOR . 'inetpub/wwwroot/swf/hot_furni/icons/';

        // Tamanho máximo do arquivo (em Bytes)
        /*$_UP['tamanho1'] = 1024 * 1024 * 40; // 40 MB
        $_UP['tamanho2'] = 1024 * 1024 * 10; // 10 MB

        // Array com as extensões permitidas
        $_UP['extensoes1'] = array('swf');
        $_UP['extensoes2'] = array('png');

        // Array com os tipos de erros de upload do PHP
        $_UP['erros'][0] = 'Não houve erro';
        $_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
        $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especificado no HTML';
        $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
        $_UP['erros'][4] = 'Não foi feito o upload do arquivo';

        $file1 = $_FILES['swf'];
        $file2 = $_FILES['icon'];

        // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
        if ($file1['error'] != 0) {
            Admin::error('Não foi possível fazer o upload, erro: ' . $_UP['erros'][$file1['error']]);
            return; // Para a execução do script
        }
        if ($file2['error'] != 0) {
            Admin::error('Não foi possível fazer o upload, erro: ' . $_UP['erros'][$file2['error']]);
            return; // Para a execução do script
        }

        // Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar

        // Faz a verificação da extensão do arquivo
        $extensao1 = pathinfo($file1['name'], PATHINFO_EXTENSION);
        if (array_search($extensao1, $_UP['extensoes1']) === false) {
            Admin::error('Por favor, envie apenas arquivos com extensão .swf');
            return;
        }
        $extensao2 = pathinfo($file2['name'], PATHINFO_EXTENSION);
        if (array_search($extensao2, $_UP['extensoes2']) === false) {
            Admin::error('Por favor, envie apenas arquivos com extensão .png');
            return;
        }

        // Faz a verificação do tamanho do arquivo
        if ($_UP['tamanho1'] < $file1['size']) {
            Admin::error('O arquivo swf enviado é muito grande, envie arquivos de até 40 MB.');
            return;
        }
        if ($_UP['tamanho2'] < $file2['size']) {
            Admin::error('O ícone enviado é muito grande, envie arquivos de até 10 MB.');
            return;
        }*/

        $itemName = $_POST['item_name'];

        $furnitureExists = $db->prepare('SELECT id FROM furniture WHERE item_name = :itemName');
        $furnitureExists->bindParam(':itemName', $_POST['item_name']);
        $furnitureExists->execute();

        if ($furnitureExists->rowCount() > 0) {
            error_log('Já existe um mobi com este item_name (' . $itemName . ') cadastrado no banco.');
            return;
        }

        if (file_exists($_UP['pasta1'] . $itemName . '.swf')) {
            error_log('Este arquivo já existe no servidor (swf).', 0);
            return;
        }
        if (file_exists($_UP['pasta2'] . $itemName . '_icon.png')) {
            error_log('Este arquivo já existe no servidor (icon).', 0);
            return;
        }

        // Baixa e salva os arquivos swf e icon no servidor
        $time = time();
        $revision = 50000;
        $xml = '<furnitype id="' . $time . '" classname="' . $itemName . '">
<revision>' . $revision . '</revision>
<defaultdir>0</defaultdir>
<xdim>1</xdim>
<ydim>1</ydim>
<name>' . $_POST['public_name'] . '</name>
<description>' . $_POST['description'] . '</description>
<adurl></adurl>
<offerid>-1</offerid>
<buyout>1</buyout>
<rentofferid>-1</rentofferid>
<rentbuyout>0</rentbuyout>
<bc>1</bc>
<excludeddynamic>0</excludeddynamic>
<customparams></customparams>
<canstandon>0</canstandon>
<cansiton>0</cansiton>
<canlayon>0</canlayon>
<furniline>' . $itemName . '</furniline>
</furnitype>';

        $urlMobi = 'https://images.habblet.in/library/hof_furni/' . $itemName . '.swf';
        $urlIcon = 'https://images.habblet.in/library/hof_furni/icons/' . $itemName . '_icon.png';

        $downloadFrom = $_POST['downloadFrom'];

        if ($downloadFrom == "habbocity") {
            $urlMobi = 'https://swf.habbocity.me/dcr/hof_furni/' . $itemName . '.swf';
            $urlIcon = 'https://swf.habbocity.me/dcr/hof_furni/icons2/' . $itemName . '_icon.png';
        } else if ($downloadFrom == "iron") {
            $urlMobi = 'https://cdn.irinc.online/static_global/furniture/' . $itemName . '.swf';
            $urlIcon = 'https://cdn.irinc.online/static_global/furniture/icons/' . $itemName . '_icon.png';
        }

        $destinoMobi = 'C:\inetpub\wwwroot\swf\hof_furni/' . basename($urlMobi);
        $destinoIcon = 'C:\inetpub\wwwroot\swf\hof_furni\icons/' . basename($urlIcon);

        set_error_handler(
            function ($err_severity, $err_msg, $err_file, $err_line, array $err_context) {
                // do not throw an exception if the @-operator is used (suppress)
                if (error_reporting() === 0) return false;

                throw new ErrorException( $err_msg, 0, $err_severity, $err_file, $err_line );
            },
            E_WARNING
        );

        $deuErro = false;

        ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)'); 
      
        try {
            $content = file_get_contents($urlMobi);
            file_put_contents($destinoMobi, $content);

            $msg = 'sucesso no download da swf: ' . $itemName . '.swf\n';

            $handle = fopen("C:\inetpub\wwwroot\OHabbo7\adminpan\logs/furnidata.log", "a");
            fwrite($handle, $msg);
            fclose($handle);
        } catch (Exception $e) {
            $msg = 'falha no download da swf: ' . $itemName . '.swf (' . $e->getMessage() . ')\n';
            error_log($msg, 0);
            $handle = fopen("C:\inetpub\wwwroot\OHabbo7\adminpan\logs/furnidata.log", "a");
            fwrite($handle, $msg);
            fclose($handle);
            return;
        }

        try {
            $content = file_get_contents($urlIcon);
            file_put_contents($destinoIcon, $content);

            $msg = 'sucesso no download do ícone: ' . $itemName . '_icon.png';
            $handle = fopen("C:\inetpub\wwwroot\OHabbo7\adminpan\logs/furnidata.log", "a");
            fwrite($handle, $msg);
            fclose($handle);
        } catch (Exception $e) {
            $msg = 'falha no download do ícone: ' . $itemName . '_icon.png (' . $e->getMessage() . ')\n';
            error_log($msg, 0);

            $handle = fopen("C:\inetpub\wwwroot\OHabbo7\adminpan\logs/furnidata.log", "a");
            fwrite($handle, $msg);
            fclose($handle);
            return;
        }

        restore_error_handler();

        // O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
        
        // insere em furniture
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            $insertFurniture = $db->prepare('INSERT INTO furniture(item_name, public_name, type, width, length, stack_height, can_stack, can_sit, is_walkable, sprite_id, allow_recycle, allow_trade, 
                                                                    allow_marketplace_sell, allow_gift, allow_inventory_stack, interaction_type, interaction_modes_count, vending_ids, effect_id, is_arrow, 
                                                                    foot_figure, stack_multiplier, subscriber, variable_heights, flat_id, revision, description, specialtype, canlayon, requires_rights, song_id) 
                VALUES (:item_name, :public_name, :type, :width, :length, :stack_height, :can_stack, :can_sit, :is_walkable, :sprite_id, :allow_recycle, :allow_trade, 
                        :allow_marketplace_sell, :allow_gift, :allow_inventory_stack, :interaction_type, :interaction_modes_count, :vending_ids, :effect_id, :is_arrow, 
                        :foot_figure, :stack_multiplier, :subscriber, :variable_heights, :flat_id, :revision, :description, :specialtype, :canlayon, :requires_rights, :song_id)');

            $insertFurniture->bindParam(':item_name', $itemName);
            $insertFurniture->bindParam(':public_name', $_POST['public_name']);
            $insertFurniture->bindParam(':type', $_POST['type']);
            $insertFurniture->bindParam(':width', $_POST['width']);
            $insertFurniture->bindParam(':length', $_POST['length']);
            $insertFurniture->bindParam(':stack_height', $_POST['stack_height']);
            $insertFurniture->bindParam(':can_stack', $_POST['can_stack']);
            $insertFurniture->bindParam(':can_sit', $_POST['can_sit']);
            $insertFurniture->bindParam(':is_walkable', $_POST['is_walkable']);
            $insertFurniture->bindParam(':sprite_id', $time); // new
            $insertFurniture->bindParam(':allow_recycle', $_POST['allow_recycle']);
            $insertFurniture->bindParam(':allow_trade', $_POST['allow_trade']);
            $insertFurniture->bindParam(':allow_marketplace_sell', $_POST['allow_marketplace_sell']);
            $insertFurniture->bindParam(':allow_gift', $_POST['allow_gift']);
            $insertFurniture->bindParam(':allow_inventory_stack', $_POST['allow_inventory_stack']);
            $insertFurniture->bindParam(':interaction_type', $_POST['interaction_type']);
            $insertFurniture->bindParam(':interaction_modes_count', $_POST['interaction_modes_count']);
            $insertFurniture->bindParam(':vending_ids', $_POST['vending_ids']);
            $insertFurniture->bindParam(':effect_id', $_POST['effect_id']);
            $insertFurniture->bindValue(':is_arrow', 1);
            $insertFurniture->bindValue(':foot_figure', 0);
            $insertFurniture->bindValue(':stack_multiplier', 0);
            $insertFurniture->bindValue(':subscriber', 0);
            $insertFurniture->bindParam(':variable_heights', $_POST['variable_heights']);
            $insertFurniture->bindValue(':flat_id', -1);
            $insertFurniture->bindParam(':revision', $revision); // new
            $insertFurniture->bindParam(':description', $_POST['description']);
            $insertFurniture->bindValue(':specialtype', 1);
            $insertFurniture->bindParam(':canlayon', $_POST['canlayon']);
            $insertFurniture->bindParam(':requires_rights', $_POST['requires_rights']);
            $insertFurniture->bindParam(':song_id', $_POST['song_id']);

            $insertFurniture->execute();

            $findFurniture = $db->prepare('SELECT id FROM furniture WHERE item_name = :itemName');
            $findFurniture->bindParam(':itemName', $_POST['item_name']);
            $findFurniture->execute();
            $findFurniture = $findFurniture->fetch();

            // insere em catalog_items
            $insertCatalogItem = $db->prepare('INSERT INTO catalog_items(page_id, item_ids, catalog_name, cost_credits, cost_pixels, cost_diamonds, amount, limited_stack, extradata, badge_id) 
                                                             VALUES (:pageId, :itemIds, :catalogName, :costCredits, :costPixels, :costDiamonds, :amount, :limitedStack, :extraData, :badgeId)');
            $insertCatalogItem->bindParam(':pageId', $_POST['page_id']);
            $insertCatalogItem->bindParam(':itemIds', $findFurniture['id']);
            $insertCatalogItem->bindParam(':catalogName', $_POST['catalog_name']);
            $insertCatalogItem->bindParam(':costCredits', $_POST['cost_credits']);
            $insertCatalogItem->bindParam(':costPixels', $_POST['cost_pixels']);
            $insertCatalogItem->bindParam(':costDiamonds', $_POST['cost_diamonds']);
            $insertCatalogItem->bindParam(':amount', $_POST['amount']);
            $insertCatalogItem->bindParam(':limitedStack', $_POST['limited_stack']);
            $insertCatalogItem->bindValue(':extraData', '');
            $insertCatalogItem->bindParam(':badgeId', $_POST['badge_id']);
            $insertCatalogItem->execute();

            $diretory = 'c:' . \DIRECTORY_SEPARATOR . 'inetpub/wwwroot/swf/gamedata/furnidata_temp.xml';
            $handle = fopen("$diretory", "a");
            fwrite($handle, $xml);
            fclose($handle);

            $texto = 'Mobi adicionado com sucesso! ID: ' . $findFurniture['id'] . '. Digite ":reload items" e ":reload catalog" (nessa ordem) no Hotel para atualizar (apenas membros superiores).';
            return ($texto);
    }
}

function addCatalogPage() {
    global $db;
    if (isset($_POST['addCatalogPage'])) {
        $caption = $_POST['caption'];

        if (strlen($caption) < 2 || strlen($caption) > 50) {
            error_log('O título da página deve ter no mínimo 2 e no máximo 50 caracteres.', 0);
            return;
        }

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $select = $db->prepare('SELECT id FROM catalog_pages WHERE caption = :caption AND parent_id = :parentId');
        $select->bindParam(':caption', $caption);
        $select->bindValue(':parentId', 423423581);
        $select->execute();

        if ($select->RowCount() > 0) {
            error_log('Já existe uma página com este título.', 0);
            return;
        }

        $insert = $db->prepare('INSERT INTO catalog_pages(parent_id, caption, icon_image, min_rank, order_num, page_layout, page_images, page_texts) 
                                    VALUES(:parentId, :caption, :iconImage, :minRank, :orderNum, :pageLayout, :pageImages, :pageTexts)');
        $insert->bindValue(':parentId', 423423581);
        $insert->bindParam(':caption', $caption);
        $insert->bindValue(':iconImage', 289481);
        $insert->bindValue(':minRank', 7);
        $insert->bindValue(':orderNum', 1);
        $insert->bindValue(':pageLayout', 'default_3x3');
        $insert->bindValue(':pageImages', '');
        $insert->bindValue(':pageTexts', '');
        $insert->execute();

        $texto = 'Página adicionada com sucesso!';

        return($texto);
    }
}
function deleteCatalogPage()
{
    global $db;
    if(isset($_GET['delete'])) 
    { 
        $deletePage = $db->prepare("DELETE FROM catalog_pages WHERE id = :id AND parent_id = :parentId");
        $deletePage->bindParam(':id', $_GET['delete']);
        $deletePage->bindValue(':parentId', 423423581);
        $deletePage->execute();
        return('Página removida! Digite ":reload catalog" no Hotel para atualizar (apenas membros superiores).');
    }
}
?>