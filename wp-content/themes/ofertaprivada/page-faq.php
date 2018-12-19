<?php
get_header();
?>
<main role="main" class="inner cover cover-container-2 bg-light">
  <div class="inner container pb-5 pt-4">
  	<div class="heading pb-3 text-center">
        <h1><?php the_field('titulo'); ?></h1>
        <p class="lead"><?php the_field('subtitulo'); ?></p>
        <form class="filterform col-md-6 col-12 mx-auto"><input class="filterinput form-control" type="search" placeholder="Buscar" data-search></form>
    </div>
	<div class="row bg-white rounded-top pb-3">
        <div class="col-md-12 pt-4 pl-4">
		<?php if( have_rows('faqs') ): ?>
        <div class="container">
            <div class="" id="accordion">
                <?php while ( have_rows('faqs') ) : the_row(); ?>
                    <div class="faqHeader h3 text-center mb-3 d-block"><?php the_sub_field('nombre'); ?></div>
                    <?php if( have_rows('preguntas') ): while ( have_rows('preguntas') ) : the_row(); ?>
                    <div class="card mb-4" data-filter-item data-filter-name="<?php echo str_replace('-',' ',sanitize_title(get_sub_field('pregunta'))); ?>">
                        <div class="card-header p-0">
                            <h5 class="m-0 p-0">
                                <a class="accordion-toggle text-dark d-block p-3" data-toggle="collapse" data-parent="#accordion" href="#<?php echo sanitize_title(get_sub_field('pregunta')); ?>"><?php the_sub_field('pregunta'); ?></a>
                            </h5>
                        </div>
                        <div id="<?php echo sanitize_title(get_sub_field('pregunta')); ?>" class="panel-collapse collapse">
                            <div class="card-block p-3"><?php the_sub_field('respuesta'); ?></div>
                        </div>
                    </div>
                <?php endwhile; endif; ?>
                <?php endwhile; ?>
            </div>
        </div>
        <?php endif; ?>        
        </div>
  	</div>
  </div>
</main>
<?php get_footer('frontpage'); ?> 