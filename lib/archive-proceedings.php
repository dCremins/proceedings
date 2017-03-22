<?php
 /*
 Template Name: Proceedings Archive
 Template Post Type: proceeding
 */
        // get posts
        $tabs = [];
        $the_query = new WP_Query(array(
        'post_type'         => 'proceedings',
        'posts_per_page'    => -1
        ));
?>

        <?php

        if ($the_query->have_posts()) :
            while ($the_query->have_posts()) :
                $the_query->the_post();
                $session = get_field('session');
                $sessionTitle = get_the_title($session);
                $date = get_field('date', $session);
                $eventdate = date("n-j-y", strtotime($date));

                // If the date is not in the tabs array, add it
                if (!isset($currentDay) || $currentDay != $eventdate) {
                    $currentDay = $eventdate;
                }

                // If the date is not in the tabs array, add it
                if (!isset($currentSession) || $currentSession != $sessionTitle) {
                    $currentSession = $sessionTitle;
                }

                if (function_exists('coauthors_posts_links')) {
                    //coauthors_posts_links();
                    $authors = Proceedings\Filters\proceedings_author_shortcode();
                } else {
                    $authors = the_author_posts_link();
                }

                $tabs[$currentDay][$sessionTitle][] = [
                  'title'     => get_the_title(),
                  'link'      => get_permalink(),
                  'session'   => $sessionTitle,
                  'speaker'   => get_field('speaker'),
                  'date'      => $date,
                  'start'     => get_field('start_time', $session),
                  'end'       => get_field('end_time', $session),
                  'room'      => get_field('room', $session),
                  'avail'     => get_field('availability', $session),
                  'file'      => get_field('proceeding_file'),
                  'author'    => $authors,
                  'abstract'  => get_the_content()
                ];
            endwhile;
        endif;


        // Sort tabs by date.
        ksort($tabs);

        // Set up Day Tabs
        echo '<div class="tabs"><ul class="schedule">';
        foreach ($tabs as $day => $session) {
            $t = date_create_from_format("n-j-y", $day);
            echo '<li class="accent background"><a class="accent color" href="#' . date_format($t, "n-j-y") . '">' . date_format($t, "M jS") . '</a></li>';
        }
        echo '</ul>';

        // Set up day blocks
        foreach ($tabs as $day => $session) {
            $t = date_create_from_format("n-j-y", $day);
            echo '<div id="' . date_format($t, "n-j-y") . '" class="session">';

            // Sort Sessions by start time and then by end time.

            foreach ($session as $key => $row) {
                $startList[$key] = $row[0]['start'];
                $endList[$key] = $row[0]['end'];
            }
            array_multisort($startList, SORT_ASC, $endList, SORT_ASC, $session);
            unset($startList);
            unset($endList);

            // Set up session headers
            foreach ($session as $sess => $num) {
                echo '<div class="title brand background"><h1 class="brand inverse"><span style="font-weight: bold;">' . $sess
                . '</span> | ' . $num[0]['start'] . ' - ' . $num[0]['end'] . ' | Room ' . $num[0]['room']
                . '</h1><div class="availability">' . $num[0]['avail'] . '</div></div>';

                // display post information
                foreach ($num as $post) {
                    echo '<div class="presentation"><h2><a class="accent color" href="' . $post['link'] . '">' . $post['title'] . '</a></h2>';
                    echo '<p class="authors">';
                    if ($post['speaker'] != '') {
                        echo '<span style="font-weight: bold;">Speaker: </span>' . $post['speaker'] . ' | ';
                    }
                    echo '<span style="font-weight: bold;">Authors: </span> ' . $post['author'] . '</p></div>';
                }
            }
            echo '</div>';
        }

        echo '</div>';?>
        </div>
