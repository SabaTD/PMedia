<?php
// no direct access   
defined('_JEXEC') or die('Access Denied!');

require_once(JPATH_SITE . DS . 'components' . DS . 'com_content' . DS . 'helpers' . DS . 'route.php');

class plgContentComments extends JPlugin {

    function plgContentComments(&$subject, $params) {
        parent::__construct($subject, $params);
        $this->loadLanguage();
    }

    function onAfterDisplayContent(&$row, &$params) {
        //TODO coments like script
        $document = JFactory::getDocument();

        $js_2 = " function votes( status ,  id )
        {

          var k = '" . JRoute::_('index.php?option=com_comments&task=votes') . "&rand=' + Math.random ( );
              
          $.ajax ( {
            type : 'POST' ,
            url : k ,
            data : { aid : id, status: status } ,
            dataType : 'json' ,
            success : function ( data )
            {
              if ( data.error != '' )
              {
                $ ( '.alertBox_' + id ).html ( data.error ) ;
                setTimeout(function () {
                    $ ( '.alertBox_' + id ).html ('') ;
                }, 3000);
                return false ;
              }

              if ( data.votes_up != '' )
              {
                $ ( '.Count_VoteUp_' + id ).html ( data.votes_up ) ;
              }
              
              if ( data.votes_down != '' )
              {
                $ ( '.Count_VoteDown_' + id ).html ( data.votes_down ) ;
              }
              
            }
          } ) ;
        }";
        
        $js_3 = "function c_check(){

                var author = document.getElementById('author').value;
                var comment = document.getElementById('comment').value;
                var parent_id = document.getElementById('parent_id').value;
                var level = document.getElementById('level').value;
                var return_url = document.getElementById('return').value;
                var article_id = document.getElementById('article_id').value;

                var k = '" . JRoute::_('index.php?option=com_comments&task=save23') . "&rand=' + Math.random ( );

                $.ajax ( {
                    type : 'POST' ,
                    url : k ,
                    data : { author : author , comment : comment , parent_id : parent_id, level : level, return_url : return_url, article_id : article_id } ,
                    dataType : 'json' ,
                    success : function ( data )
                    {
                        if ( data.status == 0 )
                        {
                          $ ( '.c_title' ).html ( 'sdsdsdsd' ) ;
                        }
                    }
                });

            }";
                

        $document->addScriptDeclaration($js_2);
        $document->addScriptDeclaration($js_3);
        
        //TODO++
        if (JRequest::getInt('print', 0)) {
            return false;
        }
        $plpParams = & JPluginHelper::getPlugin('content', 'comments');
        $pluginParams = new JParameter($plpParams->params);
        $exc_a = explode(',', $pluginParams->get('exc_a', ''));
        $exc_c = explode(',', $pluginParams->get('exc_c', ''));
        if (is_array($exc_a) and in_array($row->id, $exc_a)) {
            return false;
        }
        if (is_array($exc_c) and !in_array($row->catid, $exc_c)) {
            return false;
        }

        $params->set('link', JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid)));
        // Switch view
        switch (JRequest::getCmd('view')) {
            case 'article':
                $add = JRequest::getBool('add');
                $reply = JRequest::getBool('reply');
                if ($add) {
                    $html = $this->onComments($row, $params, $pluginParams) . $this->onForm($row, $params, $pluginParams);
                }
                else if($reply){
                    $html = $this->onComments($row, $params, $pluginParams) . $this->onReply($row, $params, $pluginParams);
                }
                else {
                    $html = $this->onBlock($row, $params, $pluginParams);
                }
                break;
            default:
                $html = $this->onLink($row, $params, $pluginParams);
                break;
        }
        return $html;
    }

    function onLink($row, &$params, $pluginParams) {
        $query = 'SELECT COUNT(id) 
			FROM #__comments 
			WHERE published=1 AND article_id=' . $row->id;
        $db = & JFactory::getDBO();
        $db->setQuery($query);
        $num = $db->loadResult();
        $html = '<div class="comment_link"><a href="' . $params->get('link') . '#comments">' . JText::_('Comments') . ' (' . $num . ')</a></div>';
        return $html;
    }

    function onBlock($row, &$params, $pluginParams) {
        echo 'onBlock';
        $db = & JFactory::getDBO();
        $doc 		=& JFactory::getDocument();
        $limit = $pluginParams->get('limit', 10);
        $show_title = $pluginParams->get('show_title');
        $title = $pluginParams->get('title');
        $link_title = $pluginParams->get('link_title');
        $allcomments = $pluginParams->get('allcomments');
        $link = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid) . '&add=1#add');
        $link2 = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid) . '&add=1#comments');

        $query = 'SELECT COUNT(id) 
			FROM #__comments 
			WHERE published=1 AND article_id=' . $row->id;
        $db->setQuery($query);
        $total = $db->loadResult();


        
        $query = ' SELECT a.id AS id, a.parent_id , a.votes_up , a.votes_down , a.userid AS userid, a.article_id AS article_id, '
                . ' a.ip AS ip, '
                . ' a.mail AS mail, a.comment AS comment, '
                . ' a.added AS added, '
                . ' a.published AS published, '
                . ' IFNULL(u.name, a.author) AS author'
                . ' FROM #__comments AS a '
                . ' LEFT JOIN #__users AS u ON u.id = a.userid '
                . ' LEFT JOIN #__content AS cc ON cc.id = a.article_id '
                . ' WHERE a.published=1 and  a.article_id=' . $row->id . ' Order by votes_up desc';
        $db->setQuery($query);
        $data = $db->loadObjectList();

        
        $array = json_decode(json_encode($data), true);
        
        function buildTreeLimit(array $elements, $parentId = 0) {
            $branch = array();

            foreach ($elements as $element) {
                if ($element['parent_id'] == $parentId) {
                    $children = buildTreeLimit($elements, $element['id']);
                    if ($children) {
                        $element['children'] = $children;
                    }
                    $branch[] = $element;
                }
            }

            return $branch;
        }

        $tree = buildTreeLimit($array);

        $stdClass = json_decode(json_encode($tree));


        
       
        ob_start();
        ?>
        <?php
        if ($show_title && !empty($title)) {
            ?>
            <div class="c_title">
                <?php
                if ($total) {
                    ?>
                    <a href="<?php echo $link2; ?>">
                    <?php } ?>
                    <?php echo $title . ' (' . $total . ')'; ?>
                    <?php
                    if ($total) {
                        ?>
                    </a>
                <?php } ?>
            </div>	
        <?php }
        ?>
        <div class="c_block">
            <?php
                   
            if (!empty($stdClass)) {
                
                ?>
                <div class="c_msg">
                    <?php
                    
                    //foreach ($stdClass as $d) {
                    for($i=0; $i<$limit; $i++){

                        $link3 = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid) . '&reply=1&commentid=' . $stdClass[$i]->id . '#add');
                        ?>
                        <div id="comment<?php echo $stdClass[$i]->id; ?>">
                            <div class="c_item">
                                <div class="c_date">
                                    <?php echo JHTML::_('date', $stdClass[$i]->added, JText::_('DATE_FORMAT_LC5')); ?> 
                                </div>			
                                <div class="c_comment">
                                    <?php echo $stdClass[$i]->comment; ?>
                                </div>

                                <div class="c_author">
                                    <?php echo $stdClass[$i]->author; ?>
                                    <!--TODO -->
                                    <div class="like_commnet">
                                        <div class="votearch" onclick="votes('like' , <?php echo $stdClass[$i]->id; ?>);">
                                            <img src="<?php echo JPHOTO_DOMAIN; ?>images/stories/com_like/comlike.png" alt="" >
                                        </div>
                                        <div class="cVoteUp">
                                            <div class="clVoteNumber Count_VoteUp_<?php echo $stdClass[$i]->id ?>">
                                                <?php echo $stdClass[$i]->votes_up; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="dislike_commnet">
                                        <div class="votearch" onclick="votes('dislike' , <?php echo $stdClass[$i]->id; ?>);">
                                            <img src="<?php echo JPHOTO_DOMAIN; ?>images/stories/com_like/comlike.png" alt="" >
                                        </div>
                                        <div class="cVoteDown">
                                            <div class="clVoteNumber Count_VoteDown_<?php echo $stdClass[$i]->id ?>">
                                                <?php echo $stdClass[$i]->votes_down; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <!--TODO++ -->
                                    <div id="reply">
                                        <div class="comment_reply">
                                            <a href="<?php echo $link3; ?>"><?php echo 'Reply'  ?></a>
                                        </div>
                                    </div>
                                    <div class="alertBox_<?php echo $stdClass[$i]->id ?>"> </div>
                                </div>
                            </div>
                        </div>
                    
                        
                        <?php
                        $j = 0;
                        if(!empty($stdClass[$i]->children)){
                            foreach($stdClass[$i]->children as $child){
                                if($j < 2){

                                    ?>
                                    <div class="c_child" id="test" style="margin-left : 37px;">
                                        <div class="c_date">
                                            <?php echo JHTML::_('date', $child->added, JText::_('%d %B %Y %H:%M')) ?> 
                                        </div>		

                                        <div class="c_comment">
                                            <?php echo $child->comment; ?> 
                                        </div> 
                                        <div class="c_author">
                                            <?php echo $child->author; ?>
                                            <!--TODO -->
                                            <div class="like_commnet">
                                                <div class="votearch" onclick="votes('like' , <?php echo $child->id; ?>);">
                                                    <img src="<?php echo JPHOTO_DOMAIN; ?>images/stories/com_like/comlike.png" alt="" >
                                                </div>
                                                <div class="cVoteUp">
                                                    <div class="clVoteNumber Count_VoteUp_<?php echo $child->id ?>">
                                                        <?php echo $child->votes_up; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="dislike_commnet">
                                                <div class="votearch" onclick="votes('dislike' , <?php echo $child->id; ?>);">
                                                    <img src="<?php echo JPHOTO_DOMAIN; ?>images/stories/com_like/comlike.png" alt="" >
                                                </div>
                                                <div class="cVoteDown">
                                                    <div class="clVoteNumber Count_VoteDown_<?php echo $child->id ?>">
                                                        <?php echo $child->votes_down; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="alertBox_<?php echo $child->id ?>"> </div>
                                            <!--TODO++ -->
                                        </div>
                                    </div>
                                    <?php
                                }
                                $j++;
                            }
                        }
                        ?>
                        
                        <?php 
                            if(!empty($stdClass[$i]->children)){
                                $moreReplys = array_slice($stdClass[$i]->children, 2); 
                            }
                        ?>
  
                        <div class='replyedComments' id="replyedComments_<?php echo $stdClass[$i]->id; ?>" style="display:none" onclick="Toggle(this.id)" >
                            <?php
                            if(!empty($moreReplys)){
                                foreach($moreReplys as $child){
                                    ?>
                                    <div class="c_child" id="test" style="margin-left : 37px;">
                                        <div class="c_date">
                                            <?php echo JHTML::_('date', $child->added, JText::_('%d %B %Y %H:%M')) ?> 
                                        </div>		

                                        <div class="c_comment">
                                            <?php echo $child->comment; ?> 
                                        </div> 
                                        <div class="c_author">
                                            <?php echo $child->author; ?>
                                            <!--TODO -->
                                            <div class="like_commnet">
                                                <div class="votearch" onclick="votes('like' ,  <?php echo $child->id; ?>);">
                                                    <img src="<?php echo JPHOTO_DOMAIN; ?>images/stories/com_like/comlike.png" alt="" >
                                                </div>
                                                <div class="cVoteUp">
                                                    <div class="clVoteNumber Count_VoteUp_<?php echo $child->id ?>">
                                                        <?php echo $child->votes_up; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="dislike_commnet">
                                                <div class="votearch" onclick="votes('dislike' , <?php echo $child->id; ?>);">
                                                    <img src="<?php echo JPHOTO_DOMAIN; ?>images/stories/com_like/comlike.png" alt="" >
                                                </div>
                                                <div class="cVoteDown">
                                                    <div class="clVoteNumber Count_VoteDown_<?php echo $child->id ?>">
                                                        <?php echo $child->votes_down; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="alertBox_<?php echo $child->id ?>"> </div>
                                            <!--TODO++ -->
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                            
                        <?php
                        if(!empty($moreReplys)){
                        ?>
                            <div id="allComments_<?php echo $stdClass[$i]->id; ?>" style="cursor:pointer" onclick="Toggle(this.id)">ყველა გამოხმაურება</div>
                        <?php 
                        }
                    }                    
                    ?>
                </div>
            
                <script>
                    function Toggle(id) {
                        Id = id.split("_");
                        WantedId = Id[1];
                        $("#replyedComments_" + WantedId).toggle();
                    }
                </script>
                
                <?php
            } else {
            ?>
                <div class="c_empty">
                    <?php echo JText::_(nl2br($pluginParams->get('nocomment'))); ?>
                </div>		
                <?php
            }
            if (!empty($link_title)) {
                ?>			
                <div class="comment_link">
                    <?php
                    if ($total) {
                        ?>
                        <div class="comment_linkl">
                            <a href="<?php echo $link2; ?>"><?php echo JText::_($allcomments); ?></a>
                        </div>
                    <?php } ?>
                    <div class="comment_linkr">
                        <a href="<?php echo $link; ?>"><?php echo JText::_($link_title); ?></a>
                    </div>
                    <div class="cls"></div>
                </div>
                <?php
            }
            ?>
        </div>

        <?php
        $html = ob_get_clean();
        return $html;
        
    }

    function onComments($row, &$params, $pluginParams) {

        $db = & JFactory::getDBO();
        $count = $pluginParams->get('count', 10);
        $limitstart = JRequest::getInt('limitstart', 'limitstart', 0);
        $show_pagination = $pluginParams->get('show_pagination');
        $show_title = $pluginParams->get('show_title');
        $title = $pluginParams->get('title');


        $query = ' SELECT COUNT(a.id) '
                . ' FROM #__comments AS a '
                . ' LEFT JOIN #__users AS u ON u.id = a.userid '
                . ' LEFT JOIN #__content AS cc ON cc.id = a.article_id '
                . ' WHERE a.published=1 and  a.article_id=' . $row->id . '';
        $db = & JFactory::getDBO();
        $db->setQuery($query);
        $total = $db->loadResult();
        jimport('joomla.html.pagination');
        $pagination = new JPagination($total, $limitstart, $count);
        $query = ' SELECT a.id AS id, a.parent_id , a.votes_up , a.votes_down,  a.userid AS userid, a.article_id AS article_id, '
                . ' a.ip AS ip, '
                . ' a.mail AS mail, a.comment AS comment, '
                . ' a.added AS added, '
                . ' a.published AS published, '
                . ' IFNULL(u.name, a.author) AS author'
                . ' FROM #__comments AS a '
                . ' LEFT JOIN #__users AS u ON u.id = a.userid '
                . ' LEFT JOIN #__content AS cc ON cc.id = a.article_id '
                . ' WHERE a.published=1 and  a.article_id=' . $row->id . ' Order by votes_up desc';
        $db->setQuery($query, $pagination->limitstart, $pagination->limit);
        $data = $db->loadObjectList();
        
        
        //print_r($data);
//        foreach($data as $comment){
//            echo 'parent ' .$comment->id;
//            foreach($data as $comment2){
//                if($comment->id == $comment2->parent_id) {
//                    echo 'child ' . $comment2->id;
//                }
//                echo '<br/>';
//            }
//        }
        
        $array = json_decode(json_encode($data), true);
        
        function buildTree(array $elements, $parentId = 0) {
            $branch = array();

            foreach ($elements as $element) {
                if ($element['parent_id'] == $parentId) {
                    $children = buildTree($elements, $element['id']);
                    if ($children) {
                        $element['children'] = $children;
                    }
                    $branch[] = $element;
                }
            }

            return $branch;
        }

        $tree = buildTree($array);
        $stdClass = json_decode(json_encode($tree));
        
        //print_r($stdClass);

        ob_start();
        ?>
        <a name="comments"></a>
        <?php
        if ($show_title && !empty($title)) {
            ?>
            <div class="c_title">
                <?php echo $title . ' (' . $total . ')'; ?>
            </div>	
            <?php
        }
        ?>
        <div class="c_block">
            <?php
            if (!empty($stdClass)) {
                foreach ($stdClass as $d) {
                    
                    $link3 = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid) . '&reply=1&commentid=' . $d->id . '#add');
                    ?>
                    <div class="c_item">
                        <div class="c_date">
                            <?php echo JHTML::_('date', $d->added, JText::_('%d %B %Y %H:%M')) ?> 
                        </div>		

                        <div class="c_comment">
                            <?php echo $d->comment; ?> 
                        </div> 
                        <div class="c_author">
                            <?php echo $d->author; ?>
                            <!--TODO -->
                            <div class="like_commnet">
                                <div class="votearch" onclick="votes('like' , <?php echo $d->id; ?>);">
                                    <img src="<?php echo JPHOTO_DOMAIN; ?>images/stories/com_like/comlike.png" alt="" >
                                </div>
                                <div class="cVoteUp">
                                    <div class="clVoteNumber Count_VoteUp_<?php echo $d->id ?>">
                                        <?php echo $d->votes_up; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="dislike_commnet">
                                <div class="votearch" onclick="votes('dislike' , <?php echo $d->id; ?>);">
                                    <img src="<?php echo JPHOTO_DOMAIN; ?>images/stories/com_like/comlike.png" alt="" >
                                </div>
                                <div class="cVoteDown">
                                    <div class="clVoteNumber Count_VoteDown_<?php echo $d->id ?>">
                                        <?php echo $d->votes_down; ?>
                                    </div>
                                </div>
                            </div>

                            <div id="reply">
                                <div class="comment_reply">
                                    <a href="<?php echo $link3; ?>"><?php echo 'Reply'  ?></a>
                                </div>
                            </div>
                            
                            <div class="alertBox_<?php echo $d->id ?>"> </div>
                            <!--TODO++ -->
                        </div>
                    </div>
                    <?php
                    //print_r($d);
                    $j = 0;
                    if(!empty($d->children)){
                        foreach($d->children as $child){
                            if($j < 2){
                                ?>
                                <div class="c_child" style="margin-left : 37px;">
                                    <div class="c_date">
                                        <?php echo JHTML::_('date', $child->added, JText::_('%d %B %Y %H:%M')) ?> 
                                    </div>		

                                    <div class="c_comment">
                                        <?php echo $child->comment; ?> 
                                    </div> 
                                    <div class="c_author">
                                        <?php echo $child->author; ?>
                                        <!--TODO -->
                                        <div class="like_commnet">
                                            <div class="votearch" onclick="votes('like' , <?php echo $child->id; ?>);">
                                                <img src="<?php echo JPHOTO_DOMAIN; ?>images/stories/com_like/comlike.png" alt="" >
                                            </div>
                                            <div class="cVoteUp">
                                                <div class="clVoteNumber Count_VoteUp_<?php echo $child->id ?>">
                                                    <?php echo $child->votes_up; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="dislike_commnet">
                                            <div class="votearch" onclick="votes('dislike' , <?php echo $child->id; ?>);">
                                                <img src="<?php echo JPHOTO_DOMAIN; ?>images/stories/com_like/comlike.png" alt="" >
                                            </div>
                                            <div class="cVoteDown">
                                                <div class="clVoteNumber Count_VoteDown_<?php echo $child->id ?>">
                                                    <?php echo $child->votes_down; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="alertBox_<?php echo $child->id ?>"> </div>
                                        <!--TODO++ -->
                                    </div>
                                </div>
                                <?php
                            }
                            $j++;
                        }  
                    }
                    ?>
            
                    <?php 
                        if(!empty($d->children)){
                            $moreReplys = array_slice($d->children, 2); 
                        }
                    ?>
  
                    <div class='replyedComments' id="replyedComments_<?php echo $d->id; ?>" style="display:none" onclick="Toggle(this.id)" >
                        <?php
                        if(!empty($moreReplys)){
                            foreach($moreReplys as $child){
                                ?>
                                <div class="c_child" id="test" style="margin-left : 37px;">
                                    <div class="c_date">
                                        <?php echo JHTML::_('date', $child->added, JText::_('%d %B %Y %H:%M')) ?> 
                                    </div>		

                                    <div class="c_comment">
                                        <?php echo $child->comment; ?> 
                                    </div> 
                                    <div class="c_author">
                                        <?php echo $child->author; ?>
                                        <!--TODO -->
                                        <div class="like_commnet">
                                            <div class="votearch" onclick="votes('like' ,  <?php echo $child->id; ?>);">
                                                <img src="<?php echo JPHOTO_DOMAIN; ?>images/stories/com_like/comlike.png" alt="" >
                                            </div>
                                            <div class="cVoteUp">
                                                <div class="clVoteNumber Count_VoteUp_<?php echo $child->id ?>">
                                                    <?php echo $child->votes_up; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="dislike_commnet">
                                            <div class="votearch" onclick="votes('dislike' , <?php echo $child->id; ?>);">
                                                <img src="<?php echo JPHOTO_DOMAIN; ?>images/stories/com_like/comlike.png" alt="" >
                                            </div>
                                            <div class="cVoteDown">
                                                <div class="clVoteNumber Count_VoteDown_<?php echo $child->id ?>">
                                                    <?php echo $child->votes_down; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="alertBox_<?php echo $child->id ?>"> </div>
                                        <!--TODO++ -->
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                            
                    <?php
                    if(!empty($moreReplys)){
                    ?>
                        <div id="allComments_<?php echo $d->id; ?>" style="cursor:pointer" onclick="Toggle(this.id)">ყველა გამოხმაურება</div>
                        <script>
                            function Toggle(id) {
                                Id = id.split("_");
                                WantedId = Id[1];
                                $("#replyedComments_" + WantedId).toggle();
                            }
                        </script>
                    <?php 
                    }
                }
            } 
            else {
                ?>
                <div class="c_empty">
                    <?php echo JText::_(nl2br($pluginParams->get('nocomment'))); ?>
                </div>		
                <?php
            }
            if ($show_pagination) {
                ?>
                <div class="c_pagination">
                    <?php
                    $pg = $pagination->getPagesLinks();
                    preg_match_all('#(?:<a )href="([^>]*?)"([^>]*?)(?:/?>)#is', $pg, $matches);
                    $pga = array_unique($matches[1]);

                    foreach ($pga as $h) {
                        $pg = str_replace('"' . $h . '"', '"' . $h . '#comments"', $pg);
                    }
                    echo $pg;
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
        $html = ob_get_clean();
        return $html;
    }

    function onForm($row, &$params, $pluginParams) {
        $user = &JFactory::getUser();
        if ($pluginParams->get('usertype') || $user->gid) {
            $username = '';
            $user = &JFactory::getUser();
            if ($user->gid) {
                $username = $user->name;
                $mail = $user->email;
                $c = '';
            } else {
                $c = ''; //'"capt",';
            }
            if ($pluginParams->get('req_name') && empty($username)) {
                $a = '<span class="c_must_have">*</span>';
                $n = '"author",';
            } else {
                $n = '';
                $a = '';
            }
            if ($pluginParams->get('req_mail')) {
                $r = '<span class="c_must_have">*</span>';
                $m = '"mail",';
            } else {
                $r = '';
                $m = '';
            }

            ob_start();
            ?>		
            <a name="add"></a>
            <div class="c_title">
                <?php echo JText::_($pluginParams->get('link_title')); ?>
            </div>
            <div class="c_block">
                <?php
                $js = 'function c_check(){var fields = Array(' . $n . $m . $c . '"comment");for(var i = 0; i < fields.length; i++){if (document.getElementById(fields[i]) == undefined){continue;}if (document.getElementById(fields[i]).value === ""){alert("' . JText::_("Fill all Marked Fields!!!", true) . '");return false;}}document.getElementById("c_form").submit();}';
                $document = & JFactory::getDocument();
                $document->addScriptDeclaration($js);
                ?>
                <div class="c_formarea">
                    <form id="c_form" name="c_form" method="post" action="/index.php">
                        <div class="c_field">
                            <label for="author">
                                <?php echo JText::_('Name'); ?><?php echo $a; ?>
                            </label>
                            <?php
                            if (empty($username)) {
                                ?>
                                <input type="text" name="author" id="author" class="c_inputbox" />
                                <?php
                            } else {
                                ?>
                                <input type="hidden" name="author" value="<?php echo $username; ?>" />
                                <input type="text" name="hidauthor" id="author" value="<?php echo $username; ?>" disabled="disabled"  class="c_inputbox" />
                                <?php
                            }
                            ?>
                            <div class="cls"></div>
                        </div>
                        <?php /* ?>						<?php
                          if ($pluginParams->get('mail'))
                          {
                          ?>
                          <div class="c_field">
                          <label for="mail"><?php echo JText::_('E-Mail'); ?><?php echo $r; ?></label>
                          <?php
                          if (empty($mail))
                          {
                          ?>
                          <input type="text" name="mail" id="mail" class="c_inputbox"  />
                          <?php
                          }
                          else
                          {
                          ?>
                          <input type="text" name="hidmail" id="mail" value="<?php echo $mail; ?>" disabled="disabled" class="c_inputbox" />
                          <input type="hidden" name="mail" value="<?php echo $mail; ?>" />
                          <?php
                          }
                          ?>
                          <div class="cls"></div>
                          </div>
                          <?php
                          }
                          ?>
                          <?php */ ?>						<div class="c_fieldr">
                            <label for="geo2">
                                <?php echo JText::_('Georgian'); ?>
                            </label>
                            <input type="checkbox" id="geo2" checked="checked" name="geo"/>
                            <div class="cls"></div>
                        </div>
                        <div class="c_field">
                            <label for="comment">
                                <?php echo JText::_('Comment'); ?><span class="c_must_have">*</span>
                            </label>
                            <textarea name="comment" id="comment" rows="7" cols="35" class="c_textarea"></textarea>
                            <div class="cls"></div>
                        </div>
                        <?php /* ?>						<?php
                          if(!$user->gid)
                          {
                          ?>
                          <div class="c_fieldr">
                          <img src="index.php?option=com_comments&amp;task=c&amp;t=<?php echo time(); ?>" alt="" />
                          <div class="cls"></div>
                          </div>
                          <div class="c_field">
                          <label for="capt">
                          <?php echo JText::_('Security Code'); ?><span class="c_must_have">*</span>
                          </label>
                          <input type="text" name="captcha" class="c_inputbox" id="capt"/>
                          <div class="cls"></div>
                          <?php
                          $nonauth = $pluginParams->get('nonauth');
                          if(!empty($nonauth))
                          {
                          ?>
                          <div class="nonauth">
                          <?php
                          echo JText::_(nl2br($nonauth));
                          ?>
                          </div>
                          <?php
                          }
                          ?>
                          </div>
                          <?php
                          }
                          ?>
                          <?php */ ?>						
                        <div class="c_fieldr">
                            <input type="button" class="c_button" name="Submit" value="<?php //echo JText::_('Submit');  ?>"  onclick="return c_check();"/>
                        </div>
                        <input type="hidden" name="option" value="com_comments" />
                        <input type="hidden" name="task" value="save" />
                        <input type="hidden" name="return" value="<?php echo base64_encode($row->readmore_link); ?>" />
                        <input type="hidden" name="article_id" value="<?php echo $row->id; ?>" />
                        <?php echo JHTML::_('form.token'); ?>
                    </form>
                </div>
                <div class="c_notice">
                    <?php echo JText::_(nl2br($pluginParams->get('note'))); ?>
                </div>
            </div>
            <?php
            $html = ob_get_clean();
        } else {
            ob_start();
            ?>		
            <a name="add"></a>
            <div class="c_title">
                <?php echo JText::_($pluginParams->get('link_title')); ?>
            </div>
            <div class="c_block">
                <div class="c_notice">
                    <?php echo JText::_(nl2br($pluginParams->get('reqauth'))); ?>
                </div>
            </div>
            <?php
            $html = ob_get_clean();
        }
        return $html;
    }
    
    
    function onReply($row, &$params, $pluginParams) {
        $user = &JFactory::getUser();
        $parent_id = JRequest::getInt('commentid');
        
        $comment['parent_id'] = $parent_id;
        $comment['level'] = 1;
        $comment['article_id'] = $row->id;
        $comment['return'] = base64_encode($row->readmore_link);
                                                  
                      
        if ($pluginParams->get('usertype') || $user->gid) {
            $username = '';
            $user = &JFactory::getUser();
            if ($user->gid) {
                $username = $user->name;
                $mail = $user->email;
                $c = '';
            } else {
                $c = ''; //'"capt",';
            }
            if ($pluginParams->get('req_name') && empty($username)) {
                $a = '<span class="c_must_have">*</span>';
                $n = '"author",';
            } else {
                $n = '';
                $a = '';
            }
            if ($pluginParams->get('req_mail')) {
                $r = '<span class="c_must_have">*</span>';
                $m = '"mail",';
            } else {
                $r = '';
                $m = '';
            }

            ob_start();
            ?>		
            <a name="add"></a>
            <div class="c_title">
                <?php echo JText::_($pluginParams->get('link_title')); ?>
            </div>
            <div class="c_block">
                <?php
                // ინფუთების ვალიდაცია დასაწერია . 
                //
                ///
                //
                //
                //
                ?>
                <div class="c_formarea">
                    <form id="c_form" name="c_form" method="post" action="/index.php">
                        <div class="c_field">
                            <label for="author">
                                <?php echo JText::_('Name'); ?><?php echo $a; ?>
                            </label>
                            <?php
                            if (empty($username)) {
                                ?>
                                <input type="text" name="author" id="author" class="c_inputbox" />
                                <?php
                            } else {
                                ?>
                                <input type="hidden" name="author" value="<?php echo $username; ?>" />
                                <input type="text" name="hidauthor" id="author" value="<?php echo $username; ?>" disabled="disabled"  class="c_inputbox" />
                                <?php
                            }
                            ?>
                            <div class="cls"></div>
                        </div>

                        <div class="c_fieldr">
                            <label for="geo2">
                                <?php echo JText::_('Georgian'); ?>
                            </label>
                            <input type="checkbox" id="geo2" checked="checked" name="geo"/>
                            <div class="cls"></div>
                        </div>
                        
                        <div class="c_field">
                            <label for="comment">
                                <?php echo JText::_('Comment'); ?><span class="c_must_have">*</span>
                            </label>
                            <textarea name="comment" id="comment" rows="7" cols="35" class="c_textarea"></textarea>
                            <div class="cls"></div>
                        </div>
 

                        <div class="c_fieldr">
                            <input type="button" class="c_button" name="Submit" value="<?php //echo JText::_('Submit');  ?>"  onclick="return c_check();"/>
                        </div>
                        
                        <input type="hidden" id="parent_id" name="parent_id" value="<?php echo $parent_id; ?>" />
                        <input type="hidden" id="level" name="level" value="1" />
                        <input type="hidden" id="return" name="return" value="<?php echo base64_encode($row->readmore_link); ?>" />
                        <input type="hidden" id="article_id" name="article_id" value="<?php echo $row->id; ?>" />
                        <?php echo JHTML::_('form.token'); ?>
                    </form>
                </div>
                <div class="c_notice">
                    <?php echo JText::_(nl2br($pluginParams->get('note'))); ?>
                </div>
            </div>
            <?php
            $html = ob_get_clean();
        } else {
            ob_start();
            ?>		
            <a name="add"></a>
            <div class="c_title">
                <?php echo JText::_($pluginParams->get('link_title')); ?>
            </div>
            <div class="c_block">
                <div class="c_notice">
                    <?php echo JText::_(nl2br($pluginParams->get('reqauth'))); ?>
                </div>
            </div>
            <?php
            $html = ob_get_clean();
        }
        return $html;
    }

}
?>

