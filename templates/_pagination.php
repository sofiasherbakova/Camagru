<?php
    $pageName = 'http://' .  $_SERVER['HTTP_HOST'] . '/gallery_page';
    echo '<div class="pagination">';
    if ($pages > 1 && isset($_GET['page']))
    {
        if (!is_numeric($_GET['page']))
            $_GET['page'] = 1;
        if ($_GET['page'] == 1) {
            $count = $_GET['page'] + 2;
            $i = $_GET['page'];
        } 
        else {
            $count = $_GET['page'] + 1;
            $i = $_GET['page'] - 1;
        }
        if ($_GET['page'] == $pages)
            $i = $_GET['page'] - 2;
        if ($_GET['page'] > 1) {
            echo '<a href="' . $pageName . '.php?' . '&page=1' . '">&#171;</a>';
            echo '<a href="' . $pageName . '.php?' . '&page=' . ($_GET['page'] - 1) . '">&#8249;</a>';
        }
        else {
            echo '<p>&#171;</p>';
            echo '<p>&#8249;</p>';
        }
        for ($i; $i <= $count; $i++) 
        {
            if ($i < 1)
                continue;
            if ($i <= $pages) 
            {
                if ($i == $_GET['page'])
                    echo '<a href="' . $pageName . '.php?' . '&page=' . $i . '" class="active">' . $i . '</a>';
                else
                    echo '<a href="' . $pageName . '.php?' . '&page=' . $i . '">' . $i . '</a>';
            }
        }
        if ($_GET['page'] + 1 <= $pages) {
            echo '<a href="' . $pageName . '.php?' . '&page=' . ($_GET['page'] + 1) . '">&#8250;</a>';
            echo '<a href="' . $pageName . '.php?' . '&page=' . $pages . '">&#187;</a>';
        } else {
            echo '<p>&#8250;</p>';
            echo '<p>&#187;</p>';
        }
    }
    echo '</div>';