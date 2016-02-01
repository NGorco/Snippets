<?php  /**
 * Contact Details &amp; Maps Widget
 *
 * This file is used to register and display the Layers - Portfolios widget.
 *
 * @package Layers
 * @since Layers 1.0.0
 */
if( !class_exists( 'Willad_Agency_Filter_Widget' ) ) {
    class Willad_Agency_Filter_Widget extends WP_Widget {

        /**
        *  Widget construction
        */
        public function __construct() 
        {
            parent::__construct("agency_filter_widget", "Фильтр агентств",
            array("description" => ""));
        }

        /**
        *  Widget front end display
        */
        function widget( $args, $instance ) { ?>
            
            <section class="section-full agencies-catalog">
                
                <header>
                    <h2>Каталог агентств</h2>
                    <form action="/agency-catalog" class="agencies-catalog-form">
                        <div class="form-group">
                            <label for="agency_name" class="sr-only">Название агентства</label>
                            <input type="text" name="agency_name" id="agency_name" class="form-control" placeholder="Название агентства">
                        </div>
                        <div class="form-group">
                            <label for="agency_client" class="sr-only">Клиент</label>
                            <input type="text" name="agency_client" id="agency_client" class="form-control" placeholder="Клиент">
                        </div>
                        <div class="form-actions">
                            <span class="icon"><span class="fa fa-search"></span></span>
                            <button type="submit" class="btn">Поиск</button>
                        </div>
                    </form>
                </header>
                <div class="block-body">
                    <ul class="catalog-categoryes-list">
                        <? 
                        $terms = get_terms('agency_type', Array('parent'=> 0));

                        $out_terms = Array();

                        foreach($terms as $term)
                        {
                            $out_terms[$term->term_id] = $term;
                        }

                        ?>
                            <li><a href="<?=get_term_link(22, 'agency_type')?>"><?=$out_terms[22]->name?></a></li>
                            <li><a href="<?=get_term_link(23, 'agency_type')?>"><?=$out_terms[23]->name?></a></li>
                            <li><a href="<?=get_term_link(21, 'agency_type')?>"><?=$out_terms[21]->name?></a></li>
                            <li><a href="<?=get_term_link(24, 'agency_type')?>"><?=$out_terms[24]->name?></a></li>
                    </ul>
                </div>
            </section>
            <?  
        }

        /**
        *  Widget update
        */
        public function update($newInstance, $oldInstance) {}

        /**
        *  Widget form
        *
        * We use regulage HTML here, it makes reading the widget much easier than if we used just php to echo all the HTML out.
        *
        */
        function form( $instance ){} // Form
    } // Class

    // Add our function to the widgets_init hook.
     register_widget("Willad_Agency_Filter_Widget");
}