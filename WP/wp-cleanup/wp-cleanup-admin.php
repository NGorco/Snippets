<?php

################################################
# THIS IS THE PART WHERE WE CLEANUP EVERYTHING #
################################################

$cleanedup = '';
if(isset($_POST['cleanup-rev'])) {
	$cleanedup .= CleanUpPostRevisions();	
}
if(isset($_POST['cleanup-spam'])) {
	$cleanedup .= CleanUpSpamComments();
}
if(isset($_POST['cleanup-unapproved'])) {
	$cleanedup .= CleanUpUnapprovedComments();
}
if(isset($_POST['cleanup-tags'])) {
	$cleanedup .= CleanUpUnusedTags();
}
if(isset($_POST['cleanup-postmeta'])) {
	$cleanedup .= CleanUpUnusedPostMeta();
}
if(isset($_POST['cleanup-mysql'])) {
	$cleanedup .= CleanUpUnusedMySQL();
}

# Function for cleaning up the post revisions
# Function for cleaning up the post revisions
function CleanUpPostRevisions() {
	global $wpdb; 
	
	$query 	 	= 'DELETE FROM '. $wpdb->posts .' WHERE post_type=\'revision\'';
	$result		= mysql_query($query);
	
	return 'Post revisions cleaned up!<br />';
}

# Function for cleaning up the spam comments
function CleanUpSpamComments() {
	global $wpdb; 
	
	$query 	 	= 'DELETE FROM '. $wpdb->comments .' WHERE comment_approved=\'spam\'';
	$result		= mysql_query($query);
	
	return 'Spam comments cleaned up!<br />';
}

# Function for cleaning up the unapproved comments
function CleanUpUnapprovedComments() {
	global $wpdb; 
	
	$query 	 	= 'DELETE FROM '. $wpdb->comments .' WHERE comment_approved=\'0\'';
	$result		= mysql_query($query);
	
	return 'Unapproved comments cleaned up!<br />';
}

# Function for cleaning up the unused tags
function CleanUpUnusedTags() {
	global $wpdb;
	
	$query		= 'DELETE wt,wtt FROM '. $wpdb->terms .' wt INNER JOIN '. $wpdb->term_taxonomy .' wtt ON wt.term_id=wtt.term_id WHERE wtt.taxonomy=\'post_tag\' AND wtt.count=0';
	$result		= mysql_query($query);
	
	return 'Unused tags cleaned up!<br />';
}

# Function for cleaning up the unused postmeta
function CleanUpUnusedPostMeta() {
	global $wpdb;
	
	$query		= 'DELETE pm FROM '. $wpdb->postmeta .' pm LEFT JOIN '. $wpdb->posts .' wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL';
	$result		= mysql_query($query);
	
	return 'Unused post meta cleaned up!<br />';
}

# Function for cleaning up the unused postmeta
function CleanUpUnusedMySQL() {
	global $wpdb;
	
	$query		= 'SHOW TABLE STATUS FROM '. DB_NAME;
	$result		= mysql_query($query);
	
	while($row = mysql_fetch_assoc($result))
	{
		$optimize	= 'OPTIMIZE TABLE '. $row['Name'];
		$execute	= mysql_query($optimize);
	}
	
	return 'Unused MySQL data cleaned up!<br />';
}

##############################################
# THIS IS THE PART FOR CALCULATING THE STATS #
##############################################

# Function for getting the total size of the Wordpress database
function DatabaseSize() {
	global $wpdb;
	
	$sql			= 'SHOW TABLE STATUS FROM '. DB_NAME;
	$query			= mysql_query($sql);
	$totalusedspace = 0;
	
	while($row = mysql_fetch_assoc($query)) {
		$usedspace 		 = $row['Data_length'] + $row['Index_length'];
		$usedspace 		 = $usedspace / 1024;
		$usedspace 		 = round($usedspace,2);
		$totalusedspace += $usedspace;
	}
	
	return $totalusedspace;
}

# Function for getting the total size of post revisions of the Wordpress database
function PostRevisionSize() {
	global $wpdb;
	
	$query 			= 'SELECT COUNT(`id`) FROM '. $wpdb->posts .' WHERE `post_type` = \'revision\'';
	$postrevision 	= $wpdb->get_var($query);
	
	$sql 			= 'SHOW TABLE STATUS FROM '. DB_NAME .' WHERE Name = \''. $wpdb->posts .'\'';
	$query			= mysql_query($sql);
	$result			= mysql_fetch_assoc($query);
	$size			= ($result['Avg_row_length'] * $postrevision) / 1024;
	$size			= round($size,2);
	
	return $size;
}

# Function for getting the total amount of post revisions of the Wordpress database
function PostRevisionAmount() {
	global $wpdb;
	
	$query 			= 'SELECT COUNT(`id`) FROM '. $wpdb->posts . ' WHERE `post_type` = \'revision\'';
	$postrevision 	= $wpdb->get_var($query);
	
	return $postrevision;
}

# Function for getting the total size of spam comments of the Wordpress database
function SpamCommentSize() {
	global $wpdb;
	
	$query 			= 'SELECT COUNT(`comment_id`) FROM '. $wpdb->comments .' WHERE `comment_approved` = \'spam\'';
	$spam			= $wpdb->get_var($query);
	
	$sql 			= 'SHOW TABLE STATUS FROM '. DB_NAME .' WHERE Name = \''. $wpdb->comments .'\'';
	$query			= mysql_query($sql);
	$result			= mysql_fetch_assoc($query);
	$size			= ($result['Avg_row_length'] * $spam) / 1024;
	$size			= round($size,2);
	
	return $size;
}

# Function for getting the total amount of spam comments of the Wordpress database
function SpamCommentAmount() {
	global $wpdb;
	
	$query 			= 'SELECT COUNT(`comment_id`) FROM '. $wpdb->comments .' WHERE `comment_approved` = \'spam\'';
	$spam			= $wpdb->get_var($query);
	
	return $spam;
}

# Function for getting the total size of unapproved comments of the Wordpress database
function UnapprovedCommentSize() {
	global $wpdb;
	
	$query 			= 'SELECT COUNT(`comment_id`) FROM '. $wpdb->comments .' WHERE `comment_approved` = \'0\'';
	$unapproved		= $wpdb->get_var($query);
	
	$sql 			= 'SHOW TABLE STATUS FROM '. DB_NAME .' WHERE Name = \''. $wpdb->comments .'\'';
	$query			= mysql_query($sql);
	$result			= mysql_fetch_assoc($query);
	$size			= ($result['Avg_row_length'] * $unapproved) / 1024;
	$size			= round($size,2);
	
	return $size;
}

# Function for getting the total amount of unapproved comments of the Wordpress database
function UnapprovedCommentAmount() {
	global $wpdb;
	
	$query 			= 'SELECT COUNT(`comment_id`) FROM '. $wpdb->comments .' WHERE `comment_approved` = \'0\'';
	$unapproved		= $wpdb->get_var($query);
	
	return $unapproved;
}

# Function for getting the total size of unused MySQL Data of the Wordpress database
function UnusedMySQLSize() {
	global $wpdb;
	
	$sql				= 'SHOW TABLE STATUS FROM '. DB_NAME;
	$query				= mysql_query($sql);
	$totalunusedspace 	= 0;
	
	while($row = mysql_fetch_assoc($query)) {
		$unusedspace 		 = $row['Data_free'] / 1024;
		$unusedspace 		 = round($unusedspace,2);
		$totalunusedspace   += $unusedspace;
	}
	
	return $totalunusedspace;
}

# Function for getting the amount of useful Wordpress data of the Wordpress database
function UsefulWordpressData() {
	$useful		= DatabaseSize() - UnusedMySQLSize() - PostRevisionSize() - UnapprovedCommentSize() - SpamCommentSize();
	
	return $useful;
}

# Function for getting the total size of unused post meta in the Wordpress database
function UnusedPostMetaSize() {
	global $wpdb;
	
	$query 		= 'SELECT COUNT(pm.meta_id) FROM '. $wpdb->postmeta .' pm LEFT JOIN '. $wpdb->posts .' wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL';
	$postmeta 	= $wpdb->get_var($query);

	$sql 			= 'SHOW TABLE STATUS FROM '. DB_NAME .' WHERE Name = \''. $wpdb->postmeta .'\'';
	$query			= mysql_query($sql);
	$result			= mysql_fetch_assoc($query);
	$size			= ($result['Avg_row_length'] * $postmeta) / 1024;
	$size			= round($size,2);
	
	return $size;
}

# Function for getting the total number of unused post meta in the Wordpress database
function UnusedPostMetaAmount() {
	global $wpdb;
	
	$query 		= 'SELECT COUNT(pm.meta_id) FROM '. $wpdb->postmeta .' pm LEFT JOIN '. $wpdb->posts .' wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL';
	$postmeta 	= $wpdb->get_var($query);

	$size			= round($postmeta,2);
	
	return $size;
}

# Function for getting the total size of unused tags in the Wordpress database
function UnusedTagsSize() {
	global $wpdb;
	
	$query 		= 'SELECT COUNT(wt.term_id) FROM '. $wpdb->terms .' wt INNER JOIN '. $wpdb->term_taxonomy .' wtt ON wt.term_id=wtt.term_id WHERE wtt.taxonomy=\'post_tag\' AND wtt.count=0';
	$tags 			= $wpdb->get_var($query);

	$sql 			= 'SHOW TABLE STATUS FROM '. DB_NAME .' WHERE Name = \''. $wpdb->terms .'\'';
	$query			= mysql_query($sql);
	$result			= mysql_fetch_assoc($query);
	$size			= ($result['Avg_row_length'] * $tags) / 1024;
	$size			= round($size,2);
	
	return $size;
}

# Function for getting the total number of unused tags in the Wordpress database
function UnusedTagsAmount() {
	global $wpdb;
	
	$query 		= 'SELECT COUNT(wt.term_id) FROM '. $wpdb->terms .' wt INNER JOIN '. $wpdb->term_taxonomy .' wtt ON wt.term_id=wtt.term_id WHERE wtt.taxonomy=\'post_tag\' AND wtt.count=0';
	$tags 			= $wpdb->get_var($query);

	$size			= round($tags,2);
	
	return $size;
}

# Function to divide
function Divide($total,$divide) {
	$divide = ($divide / $total) * 100;
	$divide = round($divide,2);
	
	return $divide;
}
?>

<div class="wrap">
<?php screen_icon(); ?>
<h2><?php _e('WP-Cleanup'); ?></h2>

<?php if($cleanedup <> '') { ?>
<div id="message" class="updated fade"><?php echo $cleanedup; ?>
</div>
<?php } ?>

<h3>At a glance</h3>
<div align="center"><img src="http://chart.apis.google.com/chart?cht=p&chs=850x300&chco=247AA2&chf=bg,s,F9F9F9&chl=Useful+Wordpress+Data|Post+revisions|Spam+comments|Unapproved+comments|Unused+MySQL+Data|Unused+tags|Unused+post+meta&chd=t:<?php echo Divide(DatabaseSize(),UsefulWordpressData()); ?>,<?php echo Divide(DatabaseSize(),PostRevisionSize()); ?>,<?php echo Divide(DatabaseSize(),SpamCommentSize()); ?>,<?php echo Divide(DatabaseSize(),UnapprovedCommentSize()); ?>,<?php echo Divide(DatabaseSize(),UnusedMySQLSize()); ?>,<?php echo Divide(DatabaseSize(),UnusedTagsSize()); ?>,<?php echo Divide(DatabaseSize(),UnusedPostMetaSize()); ?>"></div>
<h3>Total report</h3>
<form action="#" method="post" id="cleanup-form">
<table class="widefat">
	<thead>
		<th width="5%">Cleanup?</th>
		<th width="50%">Description</th>
		<th width="15%">Amount</th>
		<th width="15%">Size</th>
		<th width="15%">Percentage of total</th>
	</thead>
	<tr>
		<td></td>
		<td>Database size</td>
		<td></td>
		<td><?php echo DatabaseSize(); ?> kb</td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td>Useful Wordpress data</td>
		<td></td>
		<td><?php echo UsefulWordpressData(); ?> kb</td>
		<td><?php echo Divide(DatabaseSize(),UsefulWordpressData()); ?>%</td>
	</tr>
	<tr>
		<td align="center"><input type="checkbox" name="cleanup-rev" id="cleanup-rev"></td>
		<td>Post revisions</td>
		<td><?php echo PostRevisionAmount(); ?></td>
		<td><?php echo PostRevisionSize(); ?> kb</td>
		<td><?php echo Divide(DatabaseSize(),PostRevisionSize()); ?>%</td>
	</tr>
	<tr>
		<td align="center"><input type="checkbox" name="cleanup-spam" id="cleanup-spam"></td>
		<td>Spam comments</td>
		<td><?php echo SpamCommentAmount(); ?></td>
		<td><?php echo SpamCommentSize(); ?> kb</td>
		<td><?php echo Divide(DatabaseSize(),SpamCommentSize()); ?>%</td>
	</tr>
	<tr>
		<td align="center"><input type="checkbox" name="cleanup-unapproved" id="cleanup-unapproved"></td>
		<td>Unapproved comments</td>
		<td><?php echo UnapprovedCommentAmount(); ?></td>
		<td><?php echo UnapprovedCommentSize(); ?> kb</td>
		<td><?php echo Divide(DatabaseSize(),UnapprovedCommentSize()); ?>%</td>
	</tr>
	<tr>
		<td align="center"><input type="checkbox" name="cleanup-tags" id="cleanup-tags"></td>
		<td>Unused tags</td>
		<td><?php echo UnusedTagsAmount(); ?></td>
		<td><?php echo UnusedTagsSize(); ?> kb</td>
		<td><?php echo Divide(DatabaseSize(),UnusedTagsSize()); ?>%</td>
	</tr>
	<tr>
		<td align="center"><input type="checkbox" name="cleanup-postmeta" id="cleanup-postmeta" ></td>
		<td>Unused post meta</td>
		<td><?php echo UnusedPostMetaAmount(); ?></td>
		<td><?php echo UnusedPostMetaSize(); ?> kb</td>
		<td><?php echo Divide(DatabaseSize(),UnusedPostMetaSize()); ?>%</td>
	</tr>
	<tr>
		<td align="center"><input type="checkbox" name="cleanup-mysql" id="cleanup-mysql"></td>
		<td>Unused MySQL data</td>
		<td></td>
		<td><?php echo UnusedMySQLSize(); ?> kb</td>
		<td><?php echo Divide(DatabaseSize(),UnusedMySQLSize()); ?>%</td>
	</tr>
</table>
<p>
Make sure you have a backup of you Wordpress database before cleanup!<br />
<input type="submit" name="submit" value="Cleanup the selected items!" style="width: 300px;" class="button-primary"></p>
</form>
</div>