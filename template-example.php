<?php
/**
 * Template Name: Example Page Template
 * Description: A page template for showing off parts of Wonderpress.
 *
 * @package Wonderpress Theme
 */

use Wonderpress\Partials\Image as Image;

// Set the <body> id
wonder_body_id( 'example' );

get_header();
?>

<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
<main role="main">

	<section>

		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<?php
					wonder_image(
						array(
							'alt' => 'This is an example image',
							'src' => 'https://via.placeholder.com/150',
						),
						true
					);
					?>
				</div>
				<div class="col-md-6">
					<?php
					Wonderpress\Partials\Image::example();
					Wonderpress\Partials\Image::explain();
					?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<?php
						wonder_link(
							array(
								'content' => 'This is the link content',
								'open_in_new_tab' => false,
								'title' => 'This is the title of the link',
								'url' => 'https://wonderful.io/',
							),
							true
						);
					?>
				</div>
				<div class="col-md-6">
					<?php
					Wonderpress\Partials\Link::example();
					Wonderpress\Partials\Link::explain();
					?>
				</div>
			</div>
		</div>

	</section>

</main>

		<?php
	endwhile;
endif;
?>

<?php get_footer(); ?>
