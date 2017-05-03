<?PHP
/**
 * @version		$Id: default.php  2008-07-29
 * Teimuraz Kevlishvili
 */
// პირდაპირი წვდომის აკრძალვა
defined('_JEXEC') or die('Restricted access');
$row = $this->row;
$k = 1;
?>
<div>
    <div class="left_part">	
        <div class="left_part_in<?php echo $this->c; ?>">
            <div class="block_container">
                <div class="block_header">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <span class="block_title">
                                    <?
                                    if (isset($row['blocktitle']))
                                    {
                                        ?>
                                        <a href="<?php echo $row['titleurl']; ?>"><?php echo $row['blocktitle']; ?></a>
                                        <?
                                    }
                                    ?>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="block_container">
                    <?
                    $data = $row;
                    if (isset($data[0]))
                    {
                        $title = '';
                        if (!empty($data[0]->titleimg) && $data[0]->add)
                        {
                            $title .='<img alt="Image" title="' . $data[0]->title . '" src="' . $data[0]->titleimg . '" align="left" />';
                        }
                        $title .='<div class="main_title">
												<span class="article_time">
													' . $data[0]->Time . '
												</span>
													<a href="' . $data[0]->link . '">'
                                . $data[0]->title .
                                '</a>
											</div>';
                        ?>
                        <div class="main_article">
                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td valign="top">
                                        <?php echo $title . $data[0]->text; ?>			  	
                                        <div align="right">
                                            <span class="readmore_article">
                                                <a href="<?php echo $data[0]->link; ?>" class="readon">
                                                    <?php echo JText::_('Read more...'); ?>
                                                </a>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <?
                            if (!empty($row['main_advert']))
                            {
                                ?>
                                <div class="block_banner" align="center">
                                    <?php echo $row['main_advert']; ?>
                                </div>
                                <?
                            }
                            ?>	
                        </div>
                        <?
                    }
                    ?>
                    <div class="table_row">
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <?
                                if ($data['inneradvertpos'] == 1 or $data['inneradvertpos'] == 5)
                                {
                                    if ($data['inneradvertpos'] == 1)
                                    {
                                        ?>
                                        <td valign="top" width="50%">
                                            <?
                                            echo $data['inneradvert'];
                                            ?>
                                        </td>
                                        <?
                                    } else
                                    {
                                        ?>
                                        <td valign="top" width="50%" rowspan="3">
                                            <?
                                            echo $data['inneradvert'];
                                            ?>
                                        </td>
                                        <?
                                    }
                                    ?>
                                    <?
                                } else
                                {
                                    ?>
                                    <td valign="top" width="50%">
                                        <div class="inner_td_l">
                                            <?
                                            if (!empty($data[$k]->id))
                                            {
                                                ?>
                                                <div class="article_title">
                                                    <?
                                                    if (!empty($data[$k]->titleimg))
                                                    {
                                                        ?>
                                                        <img alt="Image" title="<?php echo $data[$k]->title; ?>" src="<?php echo $data[$k]->titleimg; ?>" align="left" />
                                                        <?
                                                    }
                                                    ?>
                                                    <span class="article_time">
                                                        <?php echo $data[$k]->Time; ?>
                                                    </span>
                                                    <a href="<?php echo $data[$k]->link; ?>">
                                                        <?php echo $data[$k]->title; ?>
                                                    </a>
                                                </div> 
                                                <?php ($data[$k]->id) ? print($data[$k]->text)  : print(''); ?>		
                                                <?
                                                $k++;
                                            }
                                            ?>
                                        </div>		
                                    </td>
                                    <?
                                }
                                ?>
                                <?
                                if ($data['inneradvertpos'] == 2 or $data['inneradvertpos'] == 6)
                                {
                                    if ($data['inneradvertpos'] == 2)
                                    {
                                        ?>
                                        <td valign="top" width="50%">
                                            <?
                                            echo $data['inneradvert'];
                                            ?>
                                        </td>
                                        <?
                                    } else
                                    {
                                        ?>
                                        <td valign="top" width="50%" rowspan="3">
                                            <?
                                            echo $data['inneradvert'];
                                            ?>
                                        </td>
                                        <?
                                    }
                                } else
                                {
                                    ?>
                                    <td valign="top" width="50%">
                                        <div class="inner_td_r">
                                            <?
                                            if (!empty($data[$k]->id))
                                            {
                                                ?>
                                                <div class="article_title">

                                                    <?
                                                    if (!empty($data[$k]->titleimg))
                                                    {
                                                        ?>
                                                        <img alt="Image" title="<?php echo $data[$k]->title; ?>" src="<?php echo $data[$k]->titleimg; ?>" align="left" />
                                                        <?
                                                    }
                                                    ?>
                                                    <span class="article_time">
                                                        <?php echo $data[$k]->Time; ?>
                                                    </span>
                                                    <a href="<?php echo $data[$k]->link; ?>">
                                                        <?php echo $data[$k]->title; ?>
                                                    </a>
                                                </div> 
                                                <?php ($data[$k]->id) ? print($data[$k]->text)  : print(''); ?>
                                                <?
                                                $k++;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <?
                                }
                                ?>
                            </tr>
                            <tr>
                                <?
                                if ($data['inneradvertpos'] != 5)
                                {
                                    ?>
                                    <td  width="50%"><div class="inner_td_line_l"><div class="inner_td_line_in"></div></div></td>
                                    <?
                                }
                                ?>
                                <?
                                if ($data['inneradvertpos'] != 6)
                                {
                                    ?>
                                    <td><div class="inner_td_line_r"><div class="inner_td_line_in"></div></div></td>
                                    <?
                                }
                                ?>
                            </tr>
                            <tr>
                                <?
                                if ($data['inneradvertpos'] != 5)
                                {
                                    if ($data['inneradvertpos'] == 3)
                                    {
                                        ?>
                                        <td valign="top" width="50%">
                                            <?
                                            echo $data['inneradvert'];
                                            ?>
                                        </td>
                                        <?
                                    } else
                                    {
                                        ?>
                                        <td valign="top" width="50%">
                                            <div class="inner_td_l">
                                                <?
                                                if (!empty($data[$k]->id))
                                                {
                                                    ?>
                                                    <div class="article_title">
                                                        <?
                                                        if (!empty($data[$k]->titleimg))
                                                        {
                                                            ?>
                                                            <img alt="Image" title="<?php echo $data[$k]->title; ?>" src="<?php echo $data[$k]->titleimg; ?>" align="left" />
                                                            <?
                                                        }
                                                        ?>
                                                        <span class="article_time">
                                                            <?php echo $data[$k]->Time; ?>
                                                        </span>
                                                        <a href="<?php echo $data[$k]->link; ?>">
                                                            <?php echo $data[$k]->title; ?>
                                                        </a>
                                                    </div> 
                                                    <?php ($data[$k]->id) ? print($data[$k]->text)  : print(''); ?>
                                                    <?
                                                    $k++;
                                                }
                                                ?>
                                            </div>
                                        </td>
                                        <?
                                    }
                                }
                                ?>
                                <?
                                if ($data['inneradvertpos'] != 6)
                                {
                                    if ($data['inneradvertpos'] == 4)
                                    {
                                        ?>
                                        <td valign="top" width="50%">
                                            <?
                                            echo $data['inneradvert'];
                                            ?>
                                        </td>
                                        <?
                                    } else
                                    {
                                        ?>
                                        <td valign="top" width="50%">
                                            <div class="inner_td_r">
                                                <?
                                                if (!empty($data[$k]->id))
                                                {
                                                    ?>
                                                    <div class="article_title">
                                                        <?
                                                        if (!empty($data[$k]->titleimg))
                                                        {
                                                            ?>
                                                            <img alt="Image" title="<?php echo $data[$k]->title; ?>" src="<?php echo $data[$k]->titleimg; ?>" align="left" />
                                                            <?
                                                        }
                                                        ?>
                                                        <span class="article_time">
                                                            <?php echo $data[$k]->Time; ?>
                                                        </span>
                                                        <a href="<?php echo $data[$k]->link; ?>">
                                                            <?php echo $data[$k]->title; ?>
                                                        </a>
                                                    </div> 
                                                    <?php ($data[$k]->id) ? print($data[$k]->text)  : print(''); ?>
                                                    <?
                                                }
                                                ?>
                                            </div>
                                        </td>
                                        <?
                                    }
                                }
                                ?>
                            </tr>
                        </table>
                    </div>
                    <div>
                    </div>
                </div>
            </div>
            <div class="under_frontcat">
                <a href="<?php echo $row['titleurl']; ?>">
                    <?php echo JText::_('Other News'); ?>
                </a>
            </div>
        </div>
        <?
        if (!empty($row['big_advert']))
        {
            ?>
            <div class="big_advert" align="center">
                <?php echo $row['big_advert']; ?>
            </div>	
            <?
        }
        ?>
        <?php
        echo wsHelper::getModule('fn_left_' . $row['fitem']->id);
        ?>
    </div>
    <?php /* ?>
    <div class="right_part">
        <?
        if (!empty($row['conference']) or !empty($row['comment']) or !empty($row['gallery']))
        {
            ?>
            <div class="right_part_in">
                <?
                if (!empty($row['comment']))
                {
                    ?> 
                    <div class="comments_block">
                        <div class="comments_f">
                            <div class="comment_title_a">
                                <span class="comment_title">
                                    <a href="<?php echo $row['comment'][0]->catlink; ?>">
                                        <?php echo $row['comment'][0]->exclusive_title; ?>
                                    </a>
                                </span>
                            </div>				
                            <?
                            foreach ($row['comment'] as $comment)
                            {
                                ?>
                                <div class="comment_block_row">
                                    <?
                                    if (!empty($comment->TImg))
                                    {
                                        ?>	
                                        <span class="comment_row_img" >
                                            <img src="<?php echo $comment->TImg; ?>" alt="" />
                                        </span>						
                                        <?
                                    }
                                    ?>	                        
                                    <span class="comment_row_title" >
                                        <a href="<?php echo $comment->link; ?>">
                                            <?php echo $comment->title; ?>
                                        </a>
                                    </span>
                                    <?php echo $comment->text; ?>
                                </div>
                                <?
                            }
                            ?>
                        </div>
                    </div>
                    <?
                }
                ?>
                <?
                if (!empty($row['conference']))
                {
                    ?>	
                    <div class="conference_block">
                        <div class="comment_title_a">
                            <span class="comment_title">
                                <a href="<?php echo $row['conference'][0]->catlink; ?>">
                                    <?php echo $row['conference'][0]->conference_title; ?>
                                </a>
                            </span>
                        </div>		
                        <?
                        foreach ($data['conference'] as $conference)
                        {
                            ?>  
                            <div class="comment_row">
                                <?
                                if (!empty($conference->TImg))
                                {
                                    ?>	
                                    <span class="comment_row_img" >
                                        <img src="<?php echo $conference->TImg; ?>" alt="" />
                                    </span>						
                                    <?
                                }
                                ?>	                        
                                <span class="comment_row_title" >
                                    <a href="<?php echo $conference->link; ?>">
                                        <?php echo $conference->title; ?>
                                    </a>
                                </span>
                                <?php echo $conference->text; ?>
                            </div>
                            <?
                        }
                        ?>
                    </div>
                    <?
                }

                if (!empty($row['gallery']))
                {
                    $gallery = $row['gallery'];
                    $gallery->name = htmlspecialchars($gallery->name, ENT_QUOTES);
                    ?>	
                    <div class="gallery_block">
                        <div class="gallery_title_a">
                            <span class="gallery_title_r">
                                <a href="<?php (!empty($gallery->parent)) ? print($gallery->parent)  : ''; ?>">
                                    <?php (!empty($gallery->galleryname)) ? print($gallery->galleryname)  : ''; ?>
                                </a>
                            </span>
                        </div>		
                        <div class="gallery_block_row">
                            <a href="<?php (!empty($gallery->link)) ? print($gallery->link)  : ''; ?>">
                                <img src="<?php (!empty($gallery->thrumb)) ? print($gallery->thrumb)  : ''; ?>"  alt="Image" title="<?php (!empty($gallery->name)) ? print($gallery->name)  : ''; ?>"/>
                            </a>
                            <div class="gallery_title_a">
                                <a href="<?php (!empty($gallery->link)) ? print($gallery->link)  : ''; ?>">
                                    <?php (!empty($gallery->name)) ? print($gallery->name)  : ''; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?
                }
                ?>
            </div>
            <?
        }
        if (!empty($row['right_advert']))
        {
            ?>
            <div class="right_banners">
                <?
                if (isset($row['right_advert']))
                {
                    echo $row['right_advert'];
                }
                ?>
            </div>
            <?
        }
        echo wsHelper::getModule('fn_right_' . $row['fitem']->id);
        ?>
    </div>
    <?php */ ?>
    <div class="cls"></div>
</div>