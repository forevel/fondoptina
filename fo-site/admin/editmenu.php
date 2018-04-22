<?php
// https://learn.javascript.ru/task/sliding-tree
require_once(__DIR__ . "/../inc/config.php");
// считать права доступа к сайту через SESSION
if(isset($_SESSION["rights"]))
{
    $projects = getFullTable("menu");
}
else
{
    fo_error_msg("Не заданы права пользователя");
    fo_redirect(__DIR__ . "/../inc/login.php");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Редактирование меню</title>
    <meta charset="UTF-8">
    <style>
    .tree span:hover {
      font-weight: bold;
    }

    .tree span {
      cursor: pointer;
    }
    </style>
</head>

<body>
<!-- <div>
    <h1>Редактор меню</h1>
    <ul class="tree">
        <li>Животные
            <ul>
                <li>Млекопитающие
                    <ul>
                        <li>Коровы</li>
                        <li>Ослы</li>
                        <li>Собаки</li>
                        <li>Тигры</li>
                    </ul>
                </li>
                <li>Другие
          <ul>
            <li>Змеи</li>
            <li>Птицы</li>
            <li>Ящерицы</li>
          </ul>
        </li>
      </ul>
    </li>
    <li>Рыбы
      <ul>
        <li>Аквариумные
          <ul>
            <li>Гуппи</li>
            <li>Скалярии</li>
          </ul>

        </li>
        <li>Морские
          <ul>
            <li>Морская форель</li>
          </ul>
        </li>
      </ul>
    </li>
  </ul> -->
    <a href="index.php">Назад</a>

<!--  <script>
    var tree = document.getElementsByTagName('ul')[0];

    var treeLis = tree.getElementsByTagName('li');

    /* wrap all textNodes into spans */
    for (var i = 0; i < treeLis.length; i++) {
      var li = treeLis[i];

      var span = document.createElement('span');
      li.insertBefore(span, li.firstChild);
      span.appendChild(span.nextSibling);
    }

    /* catch clicks on whole tree */
    tree.onclick = function(event) {
      var target = event.target;

      if (target.tagName != 'SPAN') {
        return;
      }

      /* now we know the SPAN is clicked */
      var childrenContainer = target.parentNode.getElementsByTagName('ul')[0];
      if (!childrenContainer) return; // no children

      childrenContainer.hidden = !childrenContainer.hidden;
    }
  </script> 

    </div> -->
</body>
</html>