<?php



function get_faq_loop(){
?>
 <div class="faq-blocks">

                        <?php

                        $taxonomy     = 'faq_category';
                        $orderby      = 'name';
                        $show_count   = 0;      // 1 for yes, 0 for no
                        $pad_counts   = 0;      // 1 for yes, 0 for no
                        $hierarchical = 1;      // 1 for yes, 0 for no
                        $title        = '';
                        $empty        = 0;
                        $args = array(
                            'taxonomy'     => $taxonomy,
                            'orderby'      => $orderby,
                            'show_count'   => $show_count,
                            'pad_counts'   => $pad_counts,
                            'hierarchical' => $hierarchical,
                            'title_li'     => $title,
                            'hide_empty'   => $empty
                        );
                        $all_categories = get_categories( $args );
                        ?>
                        <?php foreach($all_categories as $cat) :


                            if(!$cat->category_parent == 0) {

                                // if the parent isnt zero it must be a child.
                                // we dont do anything
                            } else {
                                // if the parent == 0 it must be a parent
                                // output the parent posts
                                faq_category_loop($cat, 'parent');
                            }


                        endforeach;
                        ?>


                </div>
<?php }


function faq_category_loop($cat){ ?>

    <div class="faq-block" id="<?= $cat->slug ?>">

        <div class="category-block">
            <h2><?php echo $cat->name ?></h2>
        </div>


        <?php

        $args = array(
            'post_type' => 'faq',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'posts_per_archive_page' => -1,
            'orderby' => 'menu_order',
            'order'     => 'ASC',
            'tax_query' => array(
                array (
                    'taxonomy' => 'faq_category',
                    'field' => 'slug',
                    'terms' => $cat->slug,
                    'include_children' => false
                )
            ),
        );



        $query = new WP_Query($args);

        ?>

        <div class="faq-items">
            <?php
            while ($query->have_posts()) : $query->the_post();
                ?>
                <div class="faq-item">
                    <button
                            class="toggle-button"
                            data-toggle="collapse"
                            data-target=".collapse.collapse-<?= get_the_ID() ?>"
                            data-text="Collapse"
                    >
                        <?php the_title() ?>
                    </button>

                    <div class="block collapse collapse-<?= get_the_ID() ?>">
                        <div class="block__content">
                            <?php the_content() ?>
                        </div>
                    </div>

                </div>
            <?php endwhile;
            ?>
        </div>
    </div>

    <?php
    wp_reset_postdata();

}
