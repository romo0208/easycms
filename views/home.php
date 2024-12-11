<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$data = $controller->getAllPosts();
$isAdmin = $controller->isLoggedInUserAdmin();
$page = $controller->getPage();
$search = $controller->getSearch();
$minVal = $controller->getMinimumPaginatorValue();
$maxVal = $controller->getMaximumPaginatorValue();
$logo = $controller->getLogo();
?>

<form action="home" method="post" enctype="multipart/form-data">
    <p class="type1">      
        <input type="text" name="search" class="search" value="<?php echo($search) ?>"/>
        <button type="submit" name="submit">Поиск</button>
    </p>
</form>

<img src="<?php echo $logo ?>" alt="<?php echo $logo ?>"/>
<form action="home" method="post" enctype="multipart/form-data" id="form">
    <input name="post_id" id="post_id" type="hidden"/>
    <input name="page" id="page" type="hidden"/>
    <input name="actions" id="actions" type="hidden"/>
    <table class="post">
        <?php if (!empty($message)): ?>
            <tr>
                <td  class="center" colspan="3">
                    <p class="type5">
                        <?php echo $message ?>
                    </p>
                </td>
            </tr>
        <?php endif; ?>            
        <?php foreach ($data as $model): ?>
            <tr class="post">
                <td class="postcenter"><img class="thumbnail" src="<?php echo $model->getPicture() ?>" alt="<?php echo $model->getCaption() ?>"/></td>
                <td class="post"><a class="post" href="showpost?id=<?php echo $model->getId() ?>"><?php echo $model->getCaption() ?></a><p><?php echo $model->getBodyAnnouncement() ?></p></td>
                <td class="post2"><p class="type4"><?php echo ($model->getUser()->getLogin() . " " . $model->getDate()) ?> </p></td>
            </tr>
            <?php if ($isAdmin): ?>
                <tr class="post">
                    <td class="postcenter">
                        <select id="<?php echo $model->getActionListId(); ?>" name="<?php echo $model->getActionListId(); ?>">
                            <option value="none" selected="selected">Выберите действие...</option>
                            <option value="edit">Редактировать</option>
                            <option value="<?php echo $model->getMenuAction() ?>"><?php echo $model->getMenuOption() ?></option>
                            <option value="delete">Удалить</option>
                        </select>
                        <button type="submit" name="submit" onclick="document.getElementById('actions').value = document.getElementById('<?php echo $model->getActionListId(); ?>').value; document.getElementById('post_id').value='<?php echo $model->getId(); ?>'; document.getElementById('page').value='<?php echo $page ?>'; submit();">Применить</button>
                    </td>
                    <td class="post" colspan="2"></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        <tr><td colspan="3">
                <?php if (sizeof($data) > 0): ?>
                    <p class="type8">Страница:</p>
                    <div class="paginator">
                        <?php for ($i = $minVal; $i <= $maxVal; $i++): ?>
                            <?php if ($i == $page): ?>
                                <div><?php echo $i ?></div>
                            <?php else: ?>
                                <?php if (empty($search)): ?>
                                    <a href="home?page=<?php echo $i ?>"><?php echo $i ?></a>
                                <?php else: ?>
                                    <a href="home?page=<?php echo $i ?>&search=<?php echo $search ?>"><?php echo $i ?></a>  
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                <?php else: ?>
                    <p class="type5">Ничего не найдено</p>
                <?php endif; ?>
            </td></tr>

    </table>
</form>
