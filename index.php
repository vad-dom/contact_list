<?php
    require_once 'settings.php';
    
    // переменная result_code передается в javascript
    // чтобы выводить там сообщения об ошибках БД
    // либо о том, что в БД нет данных
    $contacts = new Contacts();
    $result_code = 0;
    if ($contacts->dbIsNull()) $result_code = 1;
    else {
        $result = $contacts->getFullContactList();
        if ($result && $result['result']) {
            if (count($result['result_data']) > 0) $contact_list = $result['result_data'];
            else $result_code = 2;
        } else $result_code = 3;
    } 
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Книга контактов</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Обзор, добавление и удаление контактов" />
        <meta name="keywords" content="контакты, список контактов, книга контактов" />
        <link type="text/css" rel="stylesheet" href="css/style.css" />
        <script type="text/javascript" src="js/jquery-3.6.0.min.js" defer></script>
        <script type="text/javascript" src="js/jquery.maskedinput.min.js" defer></script>
        <script type="text/javascript" defer>
            const result_code = <?=$result_code?>;
        </script>
        <script type="text/javascript" src="js/functions.js" defer></script>
    </head>

    <body>
        <main>
            <div class="wrapper">
                <section id="add_contact" class="info_block">
                    <h2>Добавить контакт</h2>
                    <form id="contact_data" name="contact_data" method="post">
                        <div>
                            <input 
                                type="text" 
                                name="contact_name" 
                                id="contact_name" 
                                placeholder="Имя" 
                                pattern="^[A-Za-zА-Яа-яЁё][A-Za-zА-Яа-яЁё\d\-\s]*[A-Za-zА-Яа-яЁё\d]$" 
                                title="Допускаются только буквы, цифры, пробелы и дефисы" 
                                autofocus 
                                maxlength="255" 
                                required
                            >
                            <input 
                                type="text" 
                                name="contact_phone" 
                                id="contact_phone"
                                placeholder="Телефон" 
                                maxlength="15" 
                                required
                            >
                        </div>
                        <div class="error_submit">
                            <p id="error_text"></p>
                            <input type="submit" name="submit" value="Добавить">
                        </div>
                    </form>
                </section>
                <section id="contact_list" class="info_block">
                    <h2>Список контактов</h2>
                    <ul>
                        <?php if ($result_code == 0) { ?>
                            <?php foreach ($contact_list as $key => $item) { ?>
                                <?php $phone_1st = substr($item['contact_phone'], 0, 3); ?>
                                <?php $phone_2nd = substr($item['contact_phone'], 3, 2); ?>
                                <?php $phone_3rd = substr($item['contact_phone'], 5, 2); ?>
                                <?php $contact_phone = "$phone_1st $phone_2nd $phone_3rd"; ?>
                                <li>
                                    <div class="name_delete">
                                        <h3><?=$item['contact_name']?></h3>
                                        <i class="icon-cancel" data-id="<?=$item['id']?>"></i>
                                    </div>
                                    <p>8 <?=$item['contact_code'].' '.$contact_phone?></p>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </section>
            </div>
        </main>
    </body>
</html>