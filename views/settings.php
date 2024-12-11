<?php
$postsonpage = $controller->getPostsOnPage();
$adminemail = $controller->getAdminEmail();
?>
<form action="" method="post" enctype="multipart/form-data">
    <table class='form'>
        <tr>
            <td class = 'center' colspan = '2'><p class='type3'>Настройки</p></td>
        </tr>
        <tr>
            <td>
                Название сайта:
            </td>
            <td><input type="text" name="sitename" class="form" value="<?php echo $title ?>"/>
            </td>
        </tr>
        <tr>
            <td>
                "Шапка" сайта:
                <input type="file" name="picture" onchange="readURL(this);"/>
            </td>
            <td>
                <img id="blah" src="/src/none.png" alt="your image" />
            </td>
        </tr>
        <tr>
            <td>
                Домен:
            </td>
            <td><input type="text" name="domain" class="form" value="<?php echo $domain ?>"/>
            </td>
        </tr>
        <tr>
            <td>
                Ключевые слова:
            </td>
            <td><input type="text" name="keywords" class="form" value="<?php echo $keywords ?>"/>
            </td>
        </tr>
        <tr>
            <td>
                Количество записей на странице:
            </td>
            <td><input type="text" name="postsonpage" class="form" value="<?php echo $postsonpage ?>"/>
            </td>
        </tr>
        <tr>
            <td>
                E-mail администратора:
            </td>
            <td><input type="text" name="adminemail" class="form" value="<?php echo $adminemail ?>"/>
            </td>
        </tr>
        <tr>
            <td>
                Посты могут оставлять только администраторы:
            </td>
            <td>
                <?php if ($controller->areUserPostsOn()): ?>
                    <input type="checkbox" name="userpostson" checked="checked"/>
                <?php else: ?>
                    <input type="checkbox" name="userpostson"/>
                <?php endif; ?>
            </td>
        </tr>

        <tr>
            <td>
                "Яндекс.Метрика ID":
            </td>
            <td><input type="text" name="metric" class="form" value="<?php echo $metricid ?>"/>
            </td>
        </tr>

        <tr class = "center">
            <td class = "center" colspan = "2">
                <button type = "submit" name="submit">Применить</button>
            </td>
        </tr>
        <?php if (!empty($message)): ?>
            <tr>
                <td  class="center" colspan="2">
                    <p class="type5">
                        <?php echo $message ?>
                    </p>
                </td>
            </tr>
        <?php endif; ?>
    </table>
</form>   