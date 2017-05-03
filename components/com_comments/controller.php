<?php

/**
 * Comments Controller for Comments Component
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:components/
 * @license		GNU/GPL
 */
//
jimport( 'joomla.application.component.controller' );

class CommentsController extends JController
{

  /** @var String MultiController controll */
  var $_ctr;

  /**
   * constructor (registers additional tasks to methods)
   * 
   * @return void
   */
  function __construct( $config = array() )
  {
    $this->addModelPath( JPATH_COMPONENT_ADMINISTRATOR . DS . 'models' );
    parent::__construct( $config );

    $this->_ctr = JRequest::getCmd( 'c', 'comment' );
    $this->registerTask( 'apply', 'save' );
  }

  /**
   * Save Comment
   * 
   * @return void
   */
  
 function save()
  {
    // Check for request forgeries
    //JRequest::checkToken() or jexit( 'Invalid Token' );
    $session = & JFactory::getSession( 'com_comments' );
    $code = $session->get( 'com_comments.captcha' );
    $session->set( 'com_comments.captcha.time', 0 );
    $post = JRequest::get( 'post' );
    
    print_r($post);
    die;


    $model = $this->getModel( $this->_ctr );
    $target = base64_decode( $post['return'] );
    $target = str_replace( '&amp;', '&', $target );
    $user = &JFactory::getUser();

    $plpParams = & JPluginHelper::getPlugin( 'content', 'comments' );
    $pluginParams = new JParameter( $plpParams->params );
    $post['published'] = $pluginParams->get( 'moderate', 0 ) ? 0 : 1;

    if ( strpos( $target, '?' ) )
    {
      $add = '&add=1';
    }
    else
    {
      $add = '?add=1';
    }
    // get Request data 
    /* 		if(empty($user->gid) && $post['captcha'] != $code )
      {
      $msg = JText::_('Captcha Error');
      $type = 'error';

      $this->setRedirect(JRoute::_($target.$add), $msg, $type);
      return;
      }
     */  // Save Success or Error
    if ( $model->store( $post ) )
    {// success
      $msg = JText::_( 'Successfully saved changes' );
      $type = 'message';
      $this->setRedirect( JRoute::_( $target . $add ), $msg, $type );
    }
    else
    {// error			
      $msg = JText::_( $model->getError() );
      $type = 'error';
      $this->setRedirect( JRoute::_( $target . $add ), $msg, $type );
    }
    return false;
  }
  
  
  function save23()
  {
    // Check for request forgeries
    //JRequest::checkToken() or jexit( 'Invalid Token' );
    $session = & JFactory::getSession( 'com_comments' );
    $session->set( 'com_comments.captcha.time', 0 );
    $post = JRequest::get('post');
       
    $model = $this->getModel( $this->_ctr );

    $plpParams = & JPluginHelper::getPlugin( 'content', 'comments' );
    $pluginParams = new JParameter( $plpParams->params );
    $post['published'] = $pluginParams->get( 'moderate', 0 ) ? 0 : 1;


    
    // Save Success or Error
    
    if ( $model->store( $post ) ){
        $k = array( 'status' => '1' );
    }
    else{		
        $k = array( 'status' => '0' );
    }
    
    echo json_encode( $k );
    die;
  }
  
  
  

  function c()
  {
    require_once(JPATH_COMPONENT . DS . 'c' . DS . 'c.php');
    die;
  }

  //TODO

  public function votes()
  {
    $post = JRequest::get( 'post' );
    

    $answerId = $post['aid'];
    $status = $post['status'];
    
    $k = array();
    $model = $this->getModel( 'commentslike' );
    $err = '';
    //შევამოწმოთ უკვე აქვს თუ არა ხმა მიცემული ამ მომხმარებელს მოცემულ პასუხზე

    $hash = md5( $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] );

    $valid = $model->validation( $answerId, $hash );

    if ( $valid )
    {
        $err = JText::_( 'YOU HAVE ALREADY RATED COMMENT' );
    }
    else if($status == 'like')
    {
        $model->update_answer_vote( $answerId, $hash );
        $data = $model->get_vote( $answerId );
    }
    else if($status == 'dislike'){
        $model->update_answer_down_vote( $answerId, $hash );
        $data = $model->get_vote( $answerId );
    }
    else{
        $err = JText::_( 'NO VOTES ALLOWED' );
    }

    if ( $err )
    {
        $k = array( 'error' => $err );
    }
    else
    {   
        if($status == 'like'){
            $k = array( 'votes_up' => $data->votes_up, 'error' => $err );
        }
        else{
            $k = array( 'votes_down' => $data->votes_down, 'error' => $err );
        }
    }
    echo json_encode( $k );
    die;
  }

  
   public function getcomlist() {
        $db = JFactory::getDBO();
        $artid = 50000000 + JRequest::getVar('template',0);
        $query = "SELECT * FROM `#__comments` WHERE `published` = 1 AND `article_id` = " . $artid . " ORDER BY `id` DESC";
        $db->setQuery($query);
        $com = $db->LoadObjectList();
        ob_start();
        ?>
        <div class="comments-ajaxmodule">
            <?php

            foreach ($com as $row) {
                ?>

                <div class="row-ajaxmodule">
                    <div class="name-ajaxmodule-author">
                        <?php echo $row->author; ?>
                    </div>
                    <div class="comment-ajaxmodule-comm">
                        <?php echo $row->comment; ?>
                    </div>
                    <div class="vote-ajaxmodule-votedate">
                        <div class="vote-ajaxmodule-vote" id="vote-ajaxmodule-vote_<?php echo $row->id; ?>" onclick="votes(<?php echo $row->id; ?>)">
                            <?php echo $row->votes_up; ?>
                        </div>
                        <div class="date-ajaxmodule-date">
                            <?php echo $row->added; ?>
                        </div>
                        <div class="cls"></div>
                    </div>
                </div>

                <?php
            }
            ?>
        </div>
        <?php
        $html = ob_get_contents();
        die;
    }

    public function setcom() {
        $db = JFactory::getDBO();
        $artid = 50000000 + JRequest::getVar('template',0);
        $name = JRequest::getVar('name', '');
        $text = JRequest::getVar('text', '');
        $model = $this->getModel($this->_ctr);
        $k = array();
        $query = "SELECT * FROM `#__comments` WHERE `published` = 0 ORDER BY `id` DESC";
        $db->setQuery($query);
        $com = $db->LoadObject();

        $post = array();
        $post['comment'] = $text;
        $post['author'] = $name;
        $post['article_id'] = $artid;


        $hrml = '';
        if ($com->comment == $text && (time() - strtotime($com->added)) < 30) {
            $hrml .= '<div class="error-message">' . JText::_("Try Again") . '</div>';
        }
        if (empty($name)) {
            $hrml .= '<div class="error-message">' . JText::_("Your name is empty") . '</div>';
        }

        if (empty($text)) {

            $hrml .= '<div class="error-message">' . JText::_("Your comment is empty") . '</div>';
        } else {
            if (strlen($text) > 300000) {
                $hrml .= '<div class="error-message">' . JText::_("Your comment is so big") . '</div>';
            }
        }
        if (empty($hrml)) {
            error_reporting(1);
            $ip = $_SERVER['REMOTE_ADDR'];
            $date = date("y-m-d H:i:s", time());
            $ins = "INSERT INTO `#__comments` (`ip`,`article_id`,`votes_up`,`userid`,`author`,`mail`,`comment`,`added`,`published`)VALUES('" . $ip . "'," . $artid . ",0,0,'" . $name . "','','" . $text . "','" . $date . "',0)";
            $db->setQuery($ins);
            $res = $db->query();
            if ($res) {// success
                $msg = JText::_('Successfully saved changes');
                $hrml .= '<div class="success-message" id="sc">' . $msg . '</div>';
                $k = array('chtml' => $hrml, 'suc' => 'success', 'html' => '', 'type' => '1');
            } else {// error			
                $msg = JText::_($model->getError());

                $hrml .= '<div class="error-message">' . $msg . '</div>';
                $k = array('html' => $hrml, 'type' => 'error');
            }
        } else {
            $k = array('html' => $hrml, 'type' => 'error');
        }

        echo json_encode($k);
        die;
    }
  //TODO++
}
