<?php get_header(); ?>
<main role="main" class="inner cover cover-container-2 bg-light">
  <div class="inner container pb-5 pt-4">
  	<div class="heading pb-3 text-center">
        <h3><?php the_title(); ?></h3>
    </div>
	<div class="row bg-white rounded-top pb-3">
        <div class="col-md-12 pt-4 pl-4">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				the_content();
			endwhile;
		endif;
		?>
        </div>
  	</div>
  </div>
</main>
<?php get_footer(); ?> 