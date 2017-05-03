<?php
// no direct access
defined('_JEXEC') or die('Restricted access');



$itemid = JRequest::getVar('Itemid');
/* @var $menus JMenu */
$menus = $mainframe->getMenu();
$menu = $menus->getItem($itemid);


if (!is_object($menu)) {
    $menu = $menus->getDefault();
}
$like_module = $this->params->get('fb_like', 'none');
?>
<div id="article">
    <div class="block_header_m">
        <div class="block_title_m">
            <?php
            if ($this->params->get('link_category')) {
                ?>
                <?php if (is_object($menu)) : ?>
                    <?php if (!$this->print) : ?>
                        <a href="<?php echo $menu->link . '&amp;Itemid=' . $menu->id ?>">
                        <?php endif; ?>
                        <?php echo $menu->name ?>
                        <?php if (!$this->print) : ?>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
                <?php
                $app = $menu->name;
            }
            else {
                echo $menu->name;
                $app = $menu->name;
            }
            ?>
        </div>
        <div id="fontsize">
            <a id="large" href="javascript:void(0)">
                <img border="0" src="<?php echo JPHOTO_DOMAIN ?>templates/ambebi/images/font_up.png" alt="" />
            </a>
            <a id="small" href="javascript:void(0)">
                <img border="0" src="<?php echo JPHOTO_DOMAIN ?>templates/ambebi/images/font_down.png" alt="" />
            </a>
        </div>
    </div>
    
    <div id="article_block" class="article_block" >
        <?php if ($this->params->get('show_page_title', 1) && $this->params->get('page_title') != $this->article->title) : ?>
            <div class="componentheading<?php echo $this->params->get('pageclass_sfx') ?>"><?php echo $this->escape($this->params->get('page_title')); ?></div>
        <?php endif; ?>
        <span class="createdate">
            <?php echo JHTML::_('date', $this->article->publish_up, JText::_('DATE_FORMAT_LC5')) ?>
        </span>
        <?php if ($this->params->get('show_title', 1)) : ?>
            <div class="contentheading_article<?php echo $this->params->get('pageclass_sfx'); ?>">
                <?php if ($this->params->get('link_titles') && $this->article->readmore_link != '') : ?>
                    <a href="<?php echo $this->article->readmore_link; ?>" class="contentpagetitle<?php echo $this->params->get('pageclass_sfx'); ?>">
                        <?php echo $this->escape($this->article->title); ?>
                    </a>
                <?php else : ?>
                    <?php echo $this->article->title; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php
        // if (!$this->params->get('show_intro')) :
        //echo $this->article->event->afterDisplayTitle;
//endif; 
        ?>
        <?php
        jimport('wslib.media.multipic');
        $multipic = new wsMultiPic();
        $multipic->setCacheDir('pictures');
        $image = $this->params->get('image');
        $facebook_image = $this->params->get('facebook_image');

        $image1 = !empty($facebook_image) ? $facebook_image : $image;
        if ($image) {


            $image = $multipic->getImage('image2', $image);
            $image1 = $multipic->getImage('image33', $image1);
        }



        if (!empty($image)) {



            $document = JFactory::getDocument();
            //$document->setHeadData( array( 'custom' => array( '<link rel="image_src" href="' .  'http:'.$image . '" />' ) ) );
        }
        ?>

        <div class="article-content cls">
            <?php if (isset($this->article->toc)) : ?>
                <?php echo $this->article->toc; ?>
            <?php endif; ?>
            <?php
            if ($image) {
                ?>
                <span class="article_image">
                    <img align="left" src="<?php echo $image ?>" alt="" title="Ambebi.Ge" />
                </span>
                <?php
            }
            echo $this->article->text;
            echo wsHelper::getModule('fb_like_' . $like_module);
            ?>
            <div class="cls"></div>
            <?php
            if ($this->params->get('ext_url', 0)) {
                ?>
                <div class="ext_url">
                    <a href="<?php echo $this->params->get('ext_url', ''); ?>" rel="nofollow" target="_blank">
                        <?php
                        echo JText::_('Source : ');
                        echo $this->params->get('ext_url', '');
                        ?>
                    </a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
////////////////////////////////////////////////////

    if (!empty($this->tags)) {
        ?>
        <div class="articl_tags_con">
            <div class="articl_titl"><?php echo JText::_('Tags'); ?></div>
            <div class="articl_tags">
                <?php
                $tItemid = wsHelper::getItemid('com_content', 'tags');


                foreach ($this->tags as $one) {

                    $link = JRoute::_('index.php?option=com_content&view=content&tags=' . $one->tag_id . '-' . $one->title . '&Itemid=' . $tItemid);
                    ?>
                    <a href="<?php echo $link; ?>"><?php echo $one->title; ?></a>,

                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }



/////////////////////////////////////////////////////
    ?>





    <div class="privacy_top">
        <span style="color: rgb(27, 87, 177);">
            <a target="_blank" href="/aboutus.html">
                მასალების გამოყენების პირობები
            </a>
        </span>
        <?php
        if (!empty($image)) {
            $document = & JFactory::getDocument();
            $document->addCustomTag('<link rel="image_src" href="' . JURI::root() . $image1 . '" />');
        }
        ?>
        <div class="cls"></div>
    </div>
    <div class="articlefootern">
        <div class="articlefootern_left">
            <?php echo wsHelper::getModule('r_newbaner'); ?>
        </div>
        <div class="articlefootern_right">
            <div class="privacyn">
                <?php echo wsHelper::getModule('soc_recom'); ?>
                <div class="cls"></div>
            </div>

            <?php if ($this->params->get('show_print_icon') || $this->params->get('show_email_icon')) : ?>
                <div class="buttonheadingn">
                    <?php
                    if (!$this->print) :
                        if ($this->article->readmore_link) {
                            $url = substr(JURI::root(), 0, -1) . $this->article->readmore_link;
                        } else {
                            $url = '';
                        }
                        if ($this->article->title) {
                            $title = htmlspecialchars($this->article->title, ENT_QUOTES);
                        } else {
                            $title = '';
                        }
                        ?>
                        <span>
                            <a  target="_blank" rel="nofollow" href="http://www.facebook.com/sharer.php?u=<?php echo $url; ?>&amp;title=<?php echo $title; ?>" title="FaceBook"  onclick="window.open(this.href, 'FaceBook', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=700,height=480,directories=no,location=no');
                                            return false;">
                                <img src="<?php echo JPHOTO_DOMAIN ?>images/social/facebook.png" alt="FaceBook" />
                            </a>
                        </span>
                        <span>
                            <a  target="_blank" rel="nofollow" href="http://twitter.com/home?status=<?php echo $url; ?>&amp;title=<?php echo $title; ?>" title="Twitter" onclick="window.open(this.href, 'Twitter', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=700,height=480,directories=no,location=no');
                                            return false;">
                                <img src="<?php echo JPHOTO_DOMAIN ?>images/social/twitter.png" alt="Twitter" />
                            </a>
                        </span>
                        <span>
                            <a  target="_blank" rel="nofollow" href="http://digg.com/submit?phase=2&amp;url=<?php echo $url; ?>&amp;title=<?php echo urlencode($title); ?>" title="Digg" onclick="window.open(this.href, 'Digg', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=850,height=480,directories=no,location=no');
                                            return false;">
                                <img src="<?php echo JPHOTO_DOMAIN ?>images/social/digg.png" alt="Digg" />
                            </a>
                        </span>
                        <span>
                            <a  target="_blank" rel="nofollow" href="http://www.myspace.com/Modules/PostTo/Pages/?l=3&amp;u=<?php echo $url; ?>&amp;title=<?php echo $title; ?>" title="MySpace" onclick="window.open(this.href, 'MySpace', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=700,height=480,directories=no,location=no');
                                            return false;">
                                <img src="<?php echo JPHOTO_DOMAIN ?>images/social/myspace.png" alt="MySpace" />
                            </a>
                        </span>
                        <span>
                            <a   target="_blank" rel="nofollow" href="http://del.icio.us/post?url=<?php echo $url; ?>&amp;title=<?php echo $title; ?>" title="Delicious" onclick="window.open(this.href, 'Delicious', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=700,height=480,directories=no,location=no');
                                            return false;">
                                <img src="<?php echo JPHOTO_DOMAIN ?>images/social/delicious.png" alt="Delicious" />
                            </a>
                        </span>
                        <span>
                            <a  target="_blank" rel="nofollow" href="http://www.google.com/bookmarks/mark?op=edit&amp;bkmk=<?php echo $url; ?>&amp;title=<?php echo $title; ?>" title="Google" onclick="window.open(this.href, 'Google', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=700,height=480,directories=no,location=no');
                                            return false;">
                                <img src="<?php echo JPHOTO_DOMAIN ?>images/social/google.png" alt="Google" />
                            </a>
                        </span>
						
<script>(function (d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id))
                                    return;
                                js = d.createElement(s);
                                js.id = id;
                                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8";
                                fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>



                        <span >
                                 <!--<div  class="fb-send" data-href="<?php // echo $url; ?>"></div>-->
                            </span>
						
                    <?php endif; ?>
                    <?php if (!$this->print) : ?>
                        <?php if ($this->params->get('show_email_icon')) : ?>
                            <div class="padtop" ><span>
                                    <?php echo JHTML::_('icon.email', $this->article, $this->params, $this->access); ?>
                                </span>
                            <?php endif; ?>

                            <?php if ($this->params->get('show_print_icon')) : ?>
                                <span>
                                    <?php echo JHTML::_('icon.print_popup', $this->article, $this->params, $this->access); ?>
                                </span>
                            <?php endif; ?>
                        <?php else : ?>
                            <span>
                                <?php echo JHTML::_('icon.print_screen', $this->article, $this->params, $this->access); ?>
                            </span><div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="cls"></div>
                </div>
                <div class="clr"></div>
            </div>
            <div class="cls"></div>
        </div></div>
    <?php
    echo $this->article->event->afterDisplayContent;

    $sk = rand(0, 1);
//if ($sk)
//{
////////////////////////////////////////////////////

    echo wsHelper::renderModule('tag_modul');

///////////////////////////////////////////
///}


