<?php
/*
Plugin Name: MQ Voting 
Version: 1.0
Description: Simple voting process
Author: Alex Petlenko
Site: http://massique.com
*/


class MQ_Voting
{
	function __construct($PARAMS = Array())
	{	
		$this->hooks();
		if(!is_admin())
		$this->enqueue_scripts();	
	}

	function enqueue_scripts()	
	{			
		wp_enqueue_style('mq-voting', plugin_dir_url( __FILE__ ) . '/assets/css/mq-voting.css' );
		wp_enqueue_script('mq-voting-scripts', plugin_dir_url( __FILE__ ) . '/assets/js/mq-voting.js' , array('jquery'), '', true);
	}	

	static function showVote($post_id)
	{
		if(!is_user_logged_in()) return false;

		$voted = get_user_meta( get_current_user_id(), "post_" . $post_id . "_voted", true );

		$rating = get_post_meta($post_id, 'mq_vote_rating', true);
		?>
		<div id="mq_voting">			
			<div class="like controls <?=($voted == 'like' ? 'clicked' : '')?> <?=($voted != '' ? 'voted' : '')?>" data-post-id=<?=$post_id?>></div>			
			<div class="counter"><?=(IntVal($rating) > 0 ? $rating : 0)?></div>			
			<div class="dislike controls <?=($voted == 'dislike' ? 'clicked' : '')?> <?=($voted != '' ? 'voted' : '')?>" data-post-id=<?=$post_id?>></div>			
		</div>
		<?
	}

	static function vote()
	{
		$voted = get_user_meta( get_current_user_id(), "post_" . $_REQUEST['post_id'] . "_voted", true );

		if($voted == 'like' || $voted == 'dislike' || IntVal($_REQUEST['post_id']) <= 0) 
		{
			$proceed = get_post_meta( $_REQUEST['post_id'], 'mq_vote_rating', true );
			echo json_encode(array('status' => 'failed', 'rating' => $proceed, 'message' => 'Пользователь уже оценил этот пост'));
			die();
		}

		$current_vote = get_post_meta($_REQUEST['post_id'], 'mq_vote_rating', true);

		if($_REQUEST['vote'] == 'like')
		{
			$proceed = $current_vote + 1;
			update_post_meta($_REQUEST['post_id'], 'mq_vote_rating', $proceed, $current_vote );
			update_user_meta( get_current_user_id(), "post_" . $_REQUEST['post_id'] . "_voted", "like" );
		}else{

			if($current_vote - 1 < 0)
			{
				$current_vote = 1;
			}

			$proceed = $current_vote - 1;

			update_post_meta($_REQUEST['post_id'], 'mq_vote_rating', $proceed, $current_vote );
			update_user_meta( get_current_user_id(), "post_" . $_REQUEST['post_id'] . "_voted", "dislike");
		}

		echo json_encode(array('status' => 'success', 'rating' => $proceed));
		die();
	}

	public function hooks()
	{
		add_action('wp_ajax_vote_mq_voting', 'MQ_Voting::vote');
		add_action('wp_ajax_nopriv_vote_mq_voting', 'MQ_Voting::vote');
	}
}

new MQ_Voting();
?>