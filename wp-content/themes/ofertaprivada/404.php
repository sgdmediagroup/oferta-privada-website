<?php
get_header();
?>
<div class="cover-container d-flex h-100 p-3 mx-auto flex-column">
      <main role="main" class="inner cover cover-container-2 mt-auto">
        <h1 class="cover-heading"><strong>Error</strong> 404</h1>
        <p class="lead">La página que estás intentando ver no existe.</p>
      </main>
      <footer class="mastfoot mt-auto">
        <div class="inner">
          <p><?php the_field('copyright','options'); ?><span class="float-right"><?php the_field('development','options'); ?></span></p>
        </div>
      </footer>
    </div>
<?php get_footer(); ?> 