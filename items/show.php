<?php echo head(array('title' => metadata('item', array('Dublin Core', 'Title')),'bodyclass' => 'item show')); ?>
<?php 
//$item = get_current_record('items');
$luceItem = get_db()->getTable('LuceItem')->findByItem($item);
if(!$luceItem) {
    $luceItem = new LuceItem();    
}
$luceItem->setRecord($item);
$luceItem->edanGet(metadata('item', array('Dublin Core', 'Identifier')));
$elTexts = $luceItem->edanToElementTexts();

if($luceItem->isOnDisplay()) {
    $luceItem->parseLuceCase();    
}
$luceItem->updateRecord();
$luceItem->save();
if(!metadata('item', 'has files')) {
    $luceItem->insertFiles();
}


?>

<h1><?php echo $luceItem->findDcElement('title'); ?></h1>
<?php $nickNames =  metadata($item, array('Item Type Metadata', 'Nickname'), array('all'=>true)); ?>
<p>Nicknames:  
<?php 
$count = count($nickNames);
foreach($nickNames as $i=>$nick) {
    echo $nick;
    if($i < $count -1) {
        echo ', ';
    }
}

?>
 <a title="Let people suggest nicknames" >Suggest another nickname</a>


</p>

<?php if($luceItem->isOnDisplay()): ?>
<p><?php //echo __("Come see %s at row", metadata('item', array('Dublin Core', 'Title'))); ?></p>
<?php else: ?>
<p><?php echo __("Sorry, %s is currently away", metadata('item', array('Dublin Core', 'Title')));?></p>
<?php endif; ?>


<!-- The following prints a list of all tags associated with the item -->
<?php if (metadata('item', 'has tags')): ?>
<div id="item-tags" class="element">
    <h3><?php echo __('Tags'); ?></h3>
    <div class="element-text"><?php echo tag_string('item'); ?></div>
</div>
<?php endif;?>


<!-- The following returns all of the files associated with an item. -->
<?php if (metadata('item', 'has files')): ?>
<div id="itemfiles" class="element">
    <?php if (get_theme_option('Item FileGallery') == 1): ?>
    <div class="element-text"><?php echo item_image_gallery(); ?></div>
    <?php else: ?>
    <div class="element-text"><?php echo files_for_item(); ?></div>
    <?php endif; ?>
</div>
<?php endif; ?>

<h4>More about this case</h4>
<div class='case-info'>
<?php $collection = get_collection_for_item(); ?>
<?php $themes = metadata($collection, array('Dublin Core', 'Subject'), array('all' => true)); ?>
<p>Themes:
<?php 
$count = count($themes);
foreach($themes as $i=>$theme) {
    echo $theme;
    if($i < $count -1) {
        echo ', ';
    }
}

?>

</p>

    <div class='random-case-items'>
    <p>Some more near <?php echo $luceItem->findDcElement('title'); ?></p>
    <?php 
        $caseItems = get_records('Item', array('collection_id' => $collection->id,  
                                     'sort_field' => 'random', 
                                     'hasImage' => true), 3);
        foreach($caseItems as $caseItem) {
            if($caseItem->id != $item->id) {
                echo '<p>' . metadata($caseItem, array('Dublin Core', 'Title')) . '</p>';
                echo files_for_item($caseItem->Files);
            }
        }
    ?>
    </div>
    
<div id="collection" class="element">
    <div class="element-text"><p>Everything in case <?php echo link_to_collection_for_item(); ?></p></div>
</div>    
</div>




<?php fire_plugin_hook('public_items_show', array('view' => $this, 'item' => $item)); ?>

<nav>
<ul class="item-pagination navigation">
    <li id="previous-item" class="previous"><?php echo link_to_previous_item_show(); ?></li>
    <li id="next-item" class="next"><?php echo link_to_next_item_show(); ?></li>
</ul>
</nav>

<?php echo foot(); ?>
