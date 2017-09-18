<?php
 /*
 Template Name: Proceedings Archive
 Template Post Type: proceeding
 */
// get posts
$the_query = new WP_Query(array(
	'post_type'			=> 'proceedings',
	'posts_per_page'	=> -1,
));

if ($the_query->have_posts()) :
    while ($the_query->have_posts()) :
        $the_query->the_post();
        $session = get_field('session');
        $sessionTitle = get_the_title($session);
        $date = get_field('date', $session);
        $eventdate = date("n-j-y", strtotime($date));

        //echo (substr(get_the_title(), 0, 15).' | '.$eventdate.'<br />');
        // If the date is not in the tabs array, add it
        if (!isset($currentDay) || $currentDay != $eventdate) {
            $currentDay = $eventdate;
        }

        if (get_field('availability', $session) == 'Poster' && substr($currentDay, -7) != 'Posters') {
          $currentDay = $eventdate.' - Posters';
        }

        // If the date is not in the tabs array, add it
        if (!isset($currentSession) || $currentSession != $sessionTitle) {
            $currentSession = $sessionTitle;
        }

        if (function_exists( 'ICO\Bylines\get_the_bylines_posts_link' )) {
            $authors = ICO\Bylines\get_the_bylines_posts_link();
        } else {
            $authors = '';
        }

        $tabs[$currentDay][$sessionTitle][] = [
          'title'     => get_the_title(),
          'link'      => get_permalink(),
          'session'   => $sessionTitle,
          'sessionID' => $session,
          'speaker'   => get_field('speaker'),
          'date'      => $date,
          'start'     => date("g:i A", strtotime(get_field('start_time', $session))),
          'end'       => date("g:i A", strtotime(get_field('end_time', $session))),
          'room'      => get_field('room', $session),
          'avail'     => get_field('availability', $session),
          'file'      => get_field('proceeding_file'),
          'author'    => $authors,
          'abstract'  => get_the_content()
        ];
    endwhile;
    wp_reset_query();
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
          if (substr($day, -7) == 'Posters') {
          //  $key = key($session);
          //  $t = date_create_from_format("n-j-y", $session[$key][0]['date']);
            echo '<li class="accent background">
              <a class="accent color" href="#poster">Posters</a>
            </li>';
          } else {
            $t = date_create_from_format("n-j-y", $day);
            echo '<li class="accent background">
              <a class="accent color" href="#' . date_format($t, "n-j-y") . '">' . date_format($t, "M j") . '</a>
            </li>';
          }

        }
        ?>
        </ul>

        <?php
// Set up day blocks
        foreach ($tabs as $day => $session) {
// Sort Sessions by start time and then by end time.
            if (substr($day, -7) == 'Posters') {
              echo '<div id="poster" class="session">';
            } else {
              $t = date_create_from_format("n-j-y", $day);
              echo '<div id="'.date_format($t, "n-j-y").'" class="session">';
            } ?>
            <article>
            <?php
            foreach ($session as $sess => $num) {
// Set up session headers
                if (!empty($num)) {
                  $avail = '';
                  if ($num[0]['avail'] == 'Pre-Registration Required' && !get_field('post_conference', 'option')) {
                    $avail = '<div class="availability">'
                      . $num[0]['avail']
                    . '</div>';
                  }
                  if (!empty($num)) {
                    $poster_date = '';
                    if ($num[0]['avail'] == 'Poster') {
                      $t = date_create_from_format("m/d/Y", $num[0]['date']);
                      $poster_date = date_format($t, "M j").' | ';
                    }
                  }
                    //echo 'num' . var_dump($num);
                    echo '<div class="title brand background">
                      <h1 class="brand inverse">
                        <span style="font-weight: bold;" class="brand inverse">' . $sess
                        . '</span><br />' . $poster_date . $num[0]['start'] . ' - ' . $num[0]['end'] . ' | Room ' . $num[0]['room']
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
                        if ($post['author'] != '') {
		                      echo $post['author'];
                        }
                        if ($post['author'] != '' && $post['speaker'] != '') {
													echo '<br />';
												}
                        if ($post['speaker'] != '') {
                          echo '<span style="font-weight: bold;">Speakers: </span>' . $post['speaker'] . '   ';
                        }
                        echo '</p></div>';
                    }
                }
            }
            ?>
            </article>
            </div>
        <?php
        } ?>
        </div>
