<?php
 /*
 Template Name: Proceedings Archive
 Template Post Type: proceeding
 */
// get posts
if (have_posts()) :
    while (have_posts()) :
        the_post();
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
            $authors = get_the_author_posts_link();
        }

        $tabs[$currentDay][$sessionTitle][] = [
          'title'     => get_the_title(),
          'link'      => get_permalink(),
          'session'   => $sessionTitle,
          'sessionID' => $session,
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
    wp_reset_postdata();
endif;

foreach ($tabs as $day => $session) {
    foreach ($session as $sess => $row) {
// Convert to time so they sort correctly
        $start[$sess]  = strtotime($session[$sess][0]['start']);
        $end[$sess]  = strtotime($session[$sess][0]['end']);
    }
// Sort session within day by start and then end times, ascending
    array_multisort($start, SORT_ASC, $end, SORT_ASC, $tabs[$day]);
    //echo '***************************************<br />';
    //echo var_dump($tabs[$day]);
// refresh the start and end time arrays in preparation for the next day of sessions
    unset($start);
    unset($end);
}

// Sort tabs by date.
ksort($tabs);
// Set up Day Tabs

        ?>
        <div class="tabs">
        <ul class="schedule">

        <?php
        foreach ($tabs as $day => $session) {
            $t = date_create_from_format("n-j-y", $day);
            echo '<li class="accent background">
              <a class="accent color" href="#' . date_format($t, "n-j-y") . '">' . date_format($t, "M j") . '</a>
            </li>';
        }
        ?>
        </ul>

        <?php
// Set up day blocks
        foreach ($tabs as $day => $session) {
// Sort Sessions by start time and then by end time.

            $t = date_create_from_format("n-j-y", $day);
            ?>
            <div id=
            <?php echo '"' . date_format($t, "n-j-y") . '" class="session">'; ?>
            <article>
            <?php
            foreach ($session as $sess => $num) {
// Set up session headers
                if (!empty($num)) {
                  $avail = '';
                  if ($num[0]['avail'] == 'Pre-Registration Required') {
                    $avail = '<div class="availability">'
                      . $num[0]['avail']
                    . '</div>';
                  }
                    //echo 'num' . var_dump($num);
                    echo '<div class="title brand background">
                      <h1 class="brand inverse">
                        <a style="font-weight: bold;" class="brand inverse" href="'.get_the_permalink($num[0]['sessionID']).'">' . $sess
                        . '</a></span><br />' . $num[0]['start'] . ' - ' . $num[0]['end'] . ' | Room ' . $num[0]['room']
                      . '</h1>'
                      . $avail
                    . '</div>';

// display post information
                    foreach ($num as $post) {
                        echo '<div class="presentation">
                          <h2>
                            <a class="accent color" href="'; echo $post['link'] . '">' . $post['title'] . '</a>
                          </h2>';
                          echo '<p class="authors">';
                        if ($post['speaker'] != '') {
                            echo '<span style="font-weight: bold;">Speaker: </span>' . $post['speaker'] . ' | ';
                        }
                            echo '<span style="font-weight: bold;">Authors: </span> ' . $post['author']
                          . '</p>
                        </div>';
                    }
                }
            }
            ?>
            </article>
            </div>
        <?php
        } ?>
        </div>
