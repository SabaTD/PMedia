<?php // no direct access
defined('_JEXEC') or die('Restricted access');
$cparams =& JComponentHelper::getParams('com_media');
?>
<div class="module_block">
<?php if ($this->params->get('show_page_title', 1)) : ?>
    <div class="page_title<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
        <?php echo $this->escape($this->params->get('page_title')); ?>
    </div>
    <?php endif; ?>
    <div class="page_body<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
        <div class="contentdescription<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>" colspan="2">
        <?php if ($this->params->get('show_description_image') && $this->section->image) : ?>
            <img src="<?php echo $this->baseurl . '/' . $cparams->get('image_path') . '/'.  $this->section->image;?>" align="<?php echo $this->section->image_position;?>" hspace="6" alt="<?php echo $this->section->image;?>" />
        <?php endif; ?>
        <?php if ($this->params->get('show_description') && $this->section->description) : ?>
            <?php echo $this->section->description; ?>
        <?php endif; ?>
        </div>
        <div>
        <?php if ($this->params->get('show_categories', 1)) : ?>
        <?php foreach ($this->categories as $category) : ?>
            <?php if (!$this->params->get('show_empty_categories') && !$category->numitems) continue; ?>
            <div>
                <a href="<?php echo $category->link; ?>" class="category">
                    <?php echo $this->escape($category->title);?></a>
                <?php if ($this->params->get('show_cat_num_articles')) : ?>
                &nbsp;
                <span class="small">
                    ( <?php if ($category->numitems==1) {
                    echo $category->numitems ." ". JText::_( 'item' );}
                    else {
                    echo $category->numitems ." ". JText::_( 'items' );} ?> )
                </span>
                <?php endif; ?>
                <?php if ($this->params->def('show_category_description', 1) && $category->description) : ?>
                <br />
                <?php echo $category->description; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>
        </div>
    </div>
</div>