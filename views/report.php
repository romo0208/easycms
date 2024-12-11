<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

use models\UserModel;

$data = $controller->getAllUsers();
?>

<form action="" method="post" enctype="multipart/form-data">
    <table class="form">                                            
        <tr>
            <td colspan="8" class="center">
                <p class="type3">Текущие пользователи системы</p>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><p class="type4">user_id</p></td>
            <td><p class="type4">login</p></td>
            <td><p class="type4">email</p></td>
            <td><p class="type4">registration_date</p></td>
            <td><p class="type4">pending_id</p></td>
            <td><p class="type4">is_admin</p></td>
            <td><p class="type4">ip_address</p></td>            
        </tr>
        <?php foreach ($data as $model): ?>
            <tr>
                <td><input type="checkbox" name="checkbox[]" value="<?php echo $model->getId(); ?>"></td>
                <td><?php echo $model->getId(); ?></td>
                <td><a href="/user?id=<?php echo $model->getId(); ?>"><?php echo $model->getLogin(); ?></a></td>
                <td><?php echo $model->getEmail(); ?></td>
                <td><?php echo $model->getRegistrationDate(); ?></td>
                <td><?php echo $model->getPendingId(); ?></td>
                <td><?php echo $model->isAdmin(); ?></td>
                <td><?php echo $model->getIPAddress(); ?></td> 
            </tr>

        <?php endforeach; ?>
        <tr>
            <td colspan="8" class="center">
                <button type = "submit" name="submit">Удалить</button>
            </td>
        </tr>
        <?php if (!empty($message)): ?>
            <tr>
                <td  class="center" colspan="8">
                    <p class="type5">
                        <?php echo $message ?>
                    </p>
                </td>
            </tr>
        <?php endif; ?>

    </table>
</form>