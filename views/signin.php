<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form action="" method="post" enctype="multipart/form-data">
    <table class="form">                                            
        <tr>
            <td colspan="2" class="center">
                <p class="type3">Авторизация</p>
            </td>
        </tr>
        <tr>
            <td>Логин: </td>
            <td class="center">                                                    
                <input type="text" name="login"/>   

            </td>
        </tr>
        <tr>
            <td>Пароль: </td>
            <td class="center">
                <input type="password" name="password"/>
            </td>
        </tr>
        <tr>
            <td class ="center" colspan="2">
                <button type="submit" name="submit">Авторизация</button>
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
