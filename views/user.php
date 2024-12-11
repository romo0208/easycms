<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$login = $controller->getLogin();
$registrationDate = $controller->getRegistrationDate();
$isAdmin = $controller->isLoggedInUserAdmin();
$isViewedUserAdmin = $controller->isAdmin();
$ipAddress = $controller->getIPAddress();
$email = $controller->getEmail();
$isViewPermitted = $isAdmin || strcmp($controller->getUserName(), $login) == 0;
?>
<form action="" id="form" method="post" enctype="multipart/form-data">
    <table class='form'>
        <tr>
            <td class = 'center' colspan = '2'><p class='type3'>Пользователь <?php echo $login ?></p></td>
        </tr>
        <tr>
            <td>
                Логин:
            </td>
            <td>
                <?php echo $login ?>
            </td>
        </tr>
        <tr>
            <td>
                Дата регистрации:
            </td>
            <td>
                <?php echo $registrationDate ?>
            </td>
        </tr>
        <?php if ($isViewPermitted): ?> 
            <tr>
                <td> E-mail:</td>
                <td><?php echo $email ?></td>
            </tr>
            <tr>
            <?php endif; ?> 
            <td>
                Группа:
            </td>
            <td>
                <?php if ($isAdmin): ?>
                    <select id="user_group" name="user_group">  
                        <?php if ($isViewedUserAdmin): ?>
                            <option value="1" selected="selected">Администраторы</option>
                            <option value="0">Пользователи</option>          
                        <?php else: ?>
                            <option value="1">Администраторы</option>
                            <option value="0" selected="selected">Пользователи</option>                  
                        <?php endif; ?> 
                    </select>
                <?php else: ?>
                    <select id="user_group" name="user_group" disabled>                    
                        <?php if ($isViewedUserAdmin): ?>
                            <option value="1" selected="selected">Администраторы</option>
                            <option value="0">Пользователи</option>          
                        <?php else: ?>
                            <option value="1">Администраторы</option>
                            <option value="0" selected="selected">Пользователи</option>                  
                        <?php endif; ?>                       
                    </select>
                <?php endif; ?>
            </td>
            <?php if ($isAdmin): ?>
            <tr>
                <td>IP Address:</td>
                <td><?php echo $ipAddress ?></td>
            </tr>
        <?php endif; ?>
        <?php if ($isViewPermitted): ?>
            <tr>
                <td>Новый пароль:</td>
                <td><input type="password" id="password2" name="password2"/></td>
            </tr>
            <tr>
                <td>Повторите пароль:</td>
                <td><input type="password" id="password3" name="password3"></td>
            </tr>
        <?php endif; ?> 
        <?php if ($isViewPermitted): ?>
            <tr class = "center">
                <td class = "center" colspan = "2">
                    <button type = "submit" name="submit">Применить</button>
                </td>
            </tr>
        <?php endif; ?>
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