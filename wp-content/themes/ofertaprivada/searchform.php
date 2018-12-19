<form role="search" method="get" class="search-form pt-4 ml-2" action="<?php echo home_url( '/' ); ?>">       
	<div class="input-group" role="group">
    <label>
        <span class="screen-reader-text"><?php echo _x( 'Buscar:', 'label' ) ?></span>
        <input type="search" class="search-field form-control"
            placeholder="<?php echo esc_attr_x( 'Busar Productos', 'placeholder' ) ?>"
            value="<?php echo get_search_query() ?>" name="s"
            title="<?php echo esc_attr_x( 'Buscar:', 'label' ) ?>" />
    </label>
    <div class="input-group-btn">
    <button type="submit" class="search-submit btn btn-primary"><i class="fa fa-search"></i></button>
    </div>
    </div>
</form>