<?php
print '<nav class="menu-primary">' . PHP_EOL;
$menu = getMenuitemByIdalias('0');
if ($menu != RESULT_EMPTY)
{
    print '<ul class="menu-items sf-menu">' . PHP_EOL;
    foreach($menu as $menuitem){
    //    var_dump($menuitem['name']);
        print '<li><a href="' . 
            $menuitem['url'] . '">' . $menuitem['name'] . '</a>';
        $menu2 = getMenuitemByIdalias($menuitem['id']);
        if ($menu2 != RESULT_EMPTY)
        {
            print '<ul class="menu-items">' . PHP_EOL;
            foreach($menu2 as $menuitem2){
                print '<li><a href="' . 
                    $menuitem2['url'] . '">' . $menuitem2['name'] . '</a></li>';
            }
            print '</ul>'; 
        }
        print '</li>';
    }
}
print '</ul></menu></header>';
?>