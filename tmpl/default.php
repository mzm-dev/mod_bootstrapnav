<?php
/**
 * @version     1.7
 * @package     mod_bootstrapnav
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @author      Brad Traversy <support@bootstrapjoomla.com> - http://www.bootstrapjoomla.com
 */
//No Direct Access
defined('_JEXEC') or die;
?>
<?php if ($use_css == 1) : ?>
    <link rel="stylesheet" href="<?php echo JURI::base(); ?>media/mod_bootstrapnav/css/bootstrap.css" type="text/css" />
<?php endif; ?>
<?php //print_r($list); ?>

<?php if ($nav_type == 'navbar') : ?>    
    <nav class="navbar <?php echo $fixed; ?>  <?php echo $class_sfx; ?>" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php if ($brand_type == 'text') : ?>
                    <a class="navbar-brand" href="index.php"><?php echo $brand_text; ?></a>
                <?php elseif ($brand_type == 'image') : ?>
                    <a class="navbar-brand" href="index.php"><img src="<?php echo $brand_image; ?>" /></a>
                <?php endif; ?>
            </div><!-- /.navbar-header -->
            <!--<div class="navbar-collapse collapse">-->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav <?php echo $float; ?>">
                    <?php foreach ($list as $i => &$item) : ?>
                        <?php
                        $class = $item->id;
                        if ($item->id == $active_id) {
                            //$class .= ' current';
                        }
                        if (in_array($item->id, $path)) {
                            $class .= ' active';
                        }
                        ?>
                        <?php if (!$item->parent) : ?>
                            <?php if ($item->level == 1) : ?>
                                <li class="<?php echo $class; ?>">
                                    <a href="<?php echo $item->flink; ?>"><?php echo $item->title; ?></a>
                                </li>
                            <?php endif; ?>
                        <?php elseif ($item->parent) : ?>
                            <li class="dropdown">                                
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $item->title; ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <?php foreach ($list as $i => &$subitem) : ?>                                   
                                        <?php if ($subitem->parent_id == $item->id) : ?>
                                            <li><a href="<?php echo $subitem->flink; ?>"><?php echo $subitem->title; ?></a></li>
                                        <?php endif; ?>       
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>                                                                                           
                </ul>
                <?php
                //Load Menu-Right Module
                $modules = JModuleHelper::getModules("menu-right");
                if ($modules) {
                    $document = JFactory::getDocument();
                    $renderer = $document->loadRenderer('module');
                    $attribs = array();
                    $attribs['style'] = 'none';
                    foreach ($modules as $mod) {
                        echo JModuleHelper::renderModule($mod, $attribs);
                    }
                }
                ?>
            </div><!--/.nav-collapse -->
        </div><!--Container-->
    </nav><!-- /.navbar -->
<?php else : ?>
    <div class="list-group">
        <?php foreach ($list as $i => &$item) : ?>
            <?php
            $class = $item->id;
            $class .= ' list-group-item';
            ?>
            <a href="<?php echo $item->flink; ?>" class="<?php echo $class; ?>"><?php echo $item->title; ?></a>                     
        <?php endforeach; ?>
    </div><!-- /.list-group-->
<?php endif; ?>
<?php if ($mouseover == TRUE) { ?>
    <script>
        $(document).ready(function () {
            $('.dropdown-toggle').mouseover(function () {
                $('.dropdown-menu').show();
            });

            $('.dropdown-toggle').mouseout(function () {
                t = setTimeout(function () {
                    $('.dropdown-menu').hide();
                }, 100);

                $('.dropdown-menu').on('mouseenter', function () {
                    $('.dropdown-menu').show();
                    clearTimeout(t);
                }).on('mouseleave', function () {
                    $('.dropdown-menu').hide();
                });
            });
        });
    </script>
<?php } ?>