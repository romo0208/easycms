<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$caption = $controller->getCaption();
$body = $controller->getBody();
$video = $controller->getVideo();
?>
<script src="src/ckeditor/ckeditor.js"></script>
<form action="" method="post" enctype="multipart/form-data">                      
    <table class="form2">
        <tr>
            <td class="center" colspan="2">
                <p class="type3"><?php echo "Редактировать пост \"" . $caption . "\"" ?></p>
            </td>
        </tr>
        <tr>
            <td>
                Заголовок: 
            </td>
            <td>
                <textarea rows="7" cols="90" maxlength="400" name="caption"><?php echo $caption ?></textarea>
            </td>
        </tr>
        <tr>
            <td>
                Текст сообщения: 
            </td>
            <td>
                <textarea class="ckeditor" rows="15" cols="90" maxlength="1000000" name="body"><?php echo $body ?></textarea>
            </td>
        </tr>
        <tr>
            <td>
                Загрузить изображение: <input type="file" name="picture" onchange="readURL(this);"/>
            </td>
            <td class="center">
                <img id="blah" src="src/none.png" alt="your image" />
            </td>
        </tr>
        <tr>
            <td>
                Ссылка на видео: 
            </td>
            <td>
                <input name="video" type="text" size ="20" class="form" value="<?php echo $video ?>"/>
            </td>
        </tr>

        <tr>
            <td class = "center"colspan = "2"><button type = "submit" name = "submit">Редактировать</button></td>
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