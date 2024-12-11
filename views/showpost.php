<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */
$isAdmin = $controller->isLoggedInUserAdmin();
$caption = $controller->getCaption();
$picture = $controller->getPicture();
$body = $controller->getBody();
$video = $controller->getVideoFrame();
$user_id = $controller->getUser()->getId();
$login = $controller->getUser()->getLogin();
$date = $controller->getDate();
$comments_data = $controller->getAllComments();
$isAuthorized = $controller->isAuthorized();
?>
<form action="" method="post" enctype="multipart/form-data" id="form">
    <p><input type="hidden" name="mode" value="deletecomments"/></p>
    <table class="postshow">
        <tr>
            <?php if ($isAdmin): ?> 
                <td colspan="3"><p class="type9"><?php echo $caption ?></p></td>
            <?php else: ?>
                <td colspan="2"><p class="type9"><?php echo $caption ?></p></td> 
            <?php endif; ?>
        </tr>

        <tr>
            <?php if ($isAdmin): ?> 
                <td class="center" colspan="3"><img class="opened" src="<?php echo $picture ?>" alt="<?php echo $caption ?>"/></td>
            <?php else: ?>
                <td class="center" colspan="2"><img class="opened" src="<?php echo $picture ?>" alt="<?php echo $caption ?>"/></td>
            <?php endif; ?>
        </tr>

        <tr>
            <?php if ($isAdmin): ?> 
                <td colspan="3"><?php echo $body ?></td>
            <?php else: ?>
                <td colspan="2"><?php echo $body ?></td> 
            <?php endif; ?>
        </tr>


        <tr>
            <?php if (!empty($video)): ?> 
                <?php if ($isAdmin): ?> 
                    <td class="center" colspan="3"><iframe width="560" height="315" src="//<?php echo $video ?>" frameborder="0" allowfullscreen></iframe></td>
                <?php else: ?>
                    <td class="center" colspan="2"><iframe width="560" height="315" src="//<?php echo $video ?>" frameborder="0" allowfullscreen></iframe></td>
                <?php endif; ?>
            <?php endif; ?>
        </tr>

        <tr>            
            <?php if ($isAdmin): ?> 
                <td class="post" colspan="3"><p class="type4"><a class="userlink" href="user?id=<?php echo $user_id ?>"><?php echo $login ?></a><?php echo " " . $date ?></p></td>
            <?php else: ?>
                <td class="post" colspan="2"><p class="type4"><a class="userlink" href="user?id=<?php echo $user_id ?>"><?php echo $login ?></a><?php echo " " . $date ?></p></td>
            <?php endif; ?>                
        </tr>



        <?php foreach ($comments_data as $model): ?>        
            <tr>
                <?php if ($isAdmin): ?> 
                    <td class="controls"><input type="checkbox" name="checkbox[]" value="<?php echo $model->getId(); ?>"></td>
                <?php endif; ?> 
                <td class="userinfo"><p class="type7"><a class="userlink" href="user?id=<?php echo $model->getUser()->getId(); ?>"><?php echo $model->getUser()->getLogin(); ?></a><?php echo " " . $model->getDate(); ?></p></td>
                <td class="comment"><p class="type6"><?php echo $model->getComment(); ?></p></td>
            </tr>
        <?php endforeach; ?>

        <?php if (!empty($message)): ?>
            <tr>
                <td  class="center" colspan="8">
                    <p class="type5">
                        <?php echo $message ?>
                    </p>
                </td>
            </tr>
        <?php endif; ?>

        <?php if ($isAdmin && !empty($comments_data)): ?> 
            <tr>
                <td colspan="3" class="center">
                    <button type = "submit" name="submit">Удалить</button>
                </td>
            </tr>
        <?php endif; ?> 

    </table>
</form>
<script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script><div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="small" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir" data-yashareTheme="counter"></div>
<?php if ($isAuthorized): ?> 
    <br/>
    <form action="" method="post" enctype="multipart/form-data">
        <p class="type0">
            <input type="hidden" name="mode" value="addcomment"/>
            <textarea name="comment" rows="5" cols="100"></textarea>
            <br/>
            <button type="submit" name="submit">Комментировать</button>
        </p>
    </form>
<?php endif; ?> 


