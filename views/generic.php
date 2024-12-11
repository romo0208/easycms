<?php
$domain = $controller->getDomain();
$metricid = $controller->getMetricID();
$mainlistdata = $controller->getMainListData();
$title = $controller->getTitle();
$keywords = $controller->getKeywords();
$message = $controller->getValidationMessage();
$isAuthorized = $controller->isAuthorized();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?php echo $title ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />     
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <meta name="keywords" content="<?php echo $keywords ?>"/>
        <link rel="stylesheet" type="text/css" href="/src/css.css"/>
        <link rel="shortcut icon" href="/src/favicon.ico"/>
        <script type="text/javascript" src="/src/menu.js"></script>
        <script type="text/javascript" src="/src/jquery.min.js"></script>
        <script type="text/javascript" src="/src/api.js"></script>        
    </head>
    <body>
        <!-- Table for menu -->                    
        <table class="sddm">
            <tr>
                <td class="sddm">
                    <ul id="sddm">
                        <li><a href="home">Домой</a></li>
                        <li><a href="#"
                               onmouseover="mopen('m1')"
                               onmouseout="mclosetime()">Главное</a>
                            <div id="m1"
                                 onmouseover="mcancelclosetime()"
                                 onmouseout="mclosetime()">
                                     <?php foreach ($mainlistdata as $row): ?>
                                    <a href="/showpost?id=<?php echo $row['post_id'] ?>"><?php echo $row['caption'] ?></a>
                                <?php endforeach; ?>
                            </div>
                        </li>
                        <li><a href="signin">Авторизация</a></li>
                        <li><a href="signup">Регистрация</a></li>
                        <li><a href="newpost">Новый пост</a></li>
                        <li><a href="user">Профиль</a></li>
                        <?php if ($isAuthorized): ?>                                                  
                            <li><a href="logout">Выход</a></li>
                        <?php endif; ?>
                    </ul>
                    <div style="clear:both"></div>
                </td>
            </tr>
        </table>

        <!-- End table for menu -->
        <div class="info">
            <p class="type1">
                <?php
                echo "Здравствуйте, " . $controller->getUserName();
                ?>
            </p>
        </div>

        <!-- Main block -->
        <div class="main">
            <?php include ($controller->getSubViewPage()) ?>            
        </div>
        <!-- End of Main block -->

        <p class="type2">При использовании материалов сайта, пожалуйста, оставляйте ссылку на источник.</p>
        <p class="type1"><a href="<?php echo $domain; ?>"><?php echo $domain; ?></a>, &copy; <?php echo $controller->getYear() ?></p>
        <?php
        if (!empty($metricid)) {
            include("metric.php");
        }
        ?>        
    </body>
</html>
