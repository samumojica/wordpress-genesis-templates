<?php
/**
 * Template Name: Authors page
 *
 * This is the template for the authors.
 *
 * @package Genesis Sample
 * @author  Samuel Mojica
 */




/* Remove Entry Header */
add_action( 'genesis_before', 'prefix_remove_entry_header' );

function prefix_remove_entry_header() {

	if ( !is_front_page() ) {
		return;
	}

	//* Remove the entry header markup (requires HTML5 theme support)
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

	//* Remove the entry title (requires HTML5 theme support)
	remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

	//* Remove the entry meta in the entry header (requires HTML5 theme support)
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

	//* Remove the post format image (requires HTML5 theme support)
	remove_action( 'genesis_entry_header', 'genesis_do_post_format_image', 4 );


}

// Add landing page body class to the head.
add_filter( 'body_class', 'genesis_sample_add_body_class' );

function genesis_sample_add_body_class( $classes ) {

	$classes[] = 'contributors';

	return $classes;

}

// Add landing page body class to the head.
add_filter( 'body_class', 'genesis_sample_add_body_class2' );

function genesis_sample_add_body_class2( $classes ) {

	$classes[] = 'authors-page';

	return $classes;

}


remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
remove_action( 'genesis_loop', 'genesis_do_loop' );




// add_filter( 'genesis_entry_header', 'banner_start', 1 );
remove_action( 'genesis_entry_content', 'genesis_post_content' );

$author_id = get_the_author_meta( 'id' );

// var_dump(post_type_archive_title());

remove_action( 'genesis_entry_header', 'genesis_do_post_title' );


// Force full width page layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );





//Move breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

add_action( 'genesis_before_content', 'custom_breadcrumbs', 12 );

function custom_breadcrumbs() {
	$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
	$author_name_potrito = get_the_author_meta( 'display_name', $author->ID );
	echo '<div class="author-bread">';
	echo '<a href="/" rel="v:url" property="v:title">';
	echo 'Home ';
	echo '</a>';
	echo ' >  ';
	echo '<a href="/authors" rel="v:url" property="v:title">';
	echo ' Authors';
	echo '</a>';
	echo ' >  ';
	echo '<strong class="breadcrumb_last">';
	echo $author_name_potrito;
	echo '</strong>';
	echo '</div>';
}



add_action( 'genesis_after_header', 'banner_start', 11 );

function banner_start() {
	?>

	<section class="authorheader">
		<div class="site-inner">
			<div class="row">

				<section class="col-xs-12 col-sm-12 col-md-2 author author-two authore-img">
					<p align="center">
						<?php 
				$authorID = get_current_user_id();
				$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
				// var_dump(get_userdata( $author->ID ));
				// $author_description = the_author_meta( 'description', $author->ID );
				// var_dump(get_the_author_meta($user_ID = $author->ID));
				echo get_avatar( $author->ID, 512 ); 
				// echo get_avatar( $authorID , 512 ); 
		 ?>
					</p>
				</section>

				<div class="col-sm-12 col-md-10 author">

					<section class="authors-custom-title">
						<h2>
							<?php 
				$_user_name = get_the_author(); 
				if(!empty($_user_name)) {
					echo $_user_name;
				} else {
					the_author_meta( 'display_name', $author->ID ); 
					//echo 'Authorzz';
				} 
			?>
						</h2>
					</section>

					<!-- <h2>Title, Company Name</h2> -->
					<p>
						<?php 
				$_user_description = get_the_author_meta('user_description'); 
				if(!empty($_user_description)) {
					echo $_user_description;
				} else {
					the_author_meta( 'description', $author->ID );
				}
			?>
					</p>



					<div class="social-links-wrapper author-links">
						<strong>Follow me:</strong>
						<ul class="social-links">
							<?php if(!empty(get_the_author_meta('facebook', $author->ID))) { ?>
							<li class="social-facebook">
								<a class="fb" href="<?php the_author_meta('facebook', $author->ID); ?>"><span class="fa fa-facebook"></span></a>

							</li>
							<?php } ?>
							<?php if(!empty(get_the_author_meta('linkedin', $author->ID ))) { ?>
							<li class="social-linkedin">
								<a class="linkedin" href="<?php the_author_meta('linkedin', $author->ID ); ?>"><span class="fa fa-linkedin"></span></a>
							</li>
							<?php } ?>
							<?php if(!empty(get_the_author_meta('twitter', $author->ID))) { ?>
							<li class="social-twitter">
								<a class="twitter" href="https://twitter.com/<?php the_author_meta('twitter', $author->ID);?>"><span class="fa fa-twitter"></span></a>
							</li>
							<?php } ?>


						</ul>
					</div>



			</div>

		</div>
		</div>
	</section>


	<?php
}

add_action( 'genesis_loop', 'my_custom_loop' );

function my_custom_loop() {


	echo '<div class="entry-content">';
	$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
	$args = array(
		'post_type' => 'page',
		'orderby' => 'ID',
		'order' => 'DESC',
		'author' => $author->ID,
		'post_status' => 'publish',
		'posts_per_page' => 8
	);
	$loop = new WP_Query( $args );

	$authorid = $author->ID;

	$author_name_potrito = get_the_author_meta( 'display_name', $author->ID );

	if ( $loop->have_posts() ):

		echo '<div class="related-article-cntr mt20 mb40 hernan-space">
		<div class="row">';
	while ( $loop->have_posts() ): $loop->the_post();
	global $post;
	?>
	<div class="col-xs-12 col-sm-6 col-md-3 text-xs-center">
		<div class="related-article-col">
			<span></span>
			<a class="thumbnail-cntr" href="<?php the_permalink(); ?>" target="_blank">
				<?php the_post_thumbnail(); ?>

			</a>
			<p><br>
				<span class="title-poser-author">
					<?php the_title(); ?>
					</strong>
			</p>
			<p class="diana_p">
				<?php echo  wp_trim_words(get_the_content(), 20, '...'); ?>
			</p>

			<a href="<?php the_permalink(); ?>" target="_blank">

				
					      <span class="btn-readmore-author">Read more</span>

				</a>
		
		</div>
	</div>
	<?php
	endwhile;
	echo do_shortcode( '[ajax_load_more post_type="page" pause="true" scroll="false" progress_bar="true" progress_bar_color="ed7070"  post__in="' . $pages__in . '" posts_per_page="18" button_label="Load More " repeater="template_2" author="' . $authorid . '" offset="8" orderby="ID" container_type="div"]' );
	echo '</div>
		</div>';
	wp_reset_postdata();
	else :
		echo "<p class='staytuned-p'>Stay tuned for posts from " . $author->display_name . "...</p>";
	endif;

	echo '</div><!-- end .entry-content -->';
	}


	genesis();
