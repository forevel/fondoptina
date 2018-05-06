<?php 

function setprogressbar($pbname, $widthinpercents) {
    $thisdomdocument = new DOMDocument($this->domDocument);
    $thisdomdocument->validateOnParse = true;
    $elem = $thisdomdocument->getElementById(pbname);
    if ($widthinpercents < 10)
    {
        $elem.style.backgroundColor = "orangered";
    }
    else if (widthinpercents < 30)
    {
        elem.style.backgroundColor = "darkorange";
    }
    else if (widthinpercents < 50)
    {
        elem.style.backgroundColor = "gold";
    }
    else if (widthinpercents < 70)
    {
        elem.style.backgroundColor = "yellow";
    }
    else
    {
        elem.style.backgroundColor = "greenyellow";
    }
    elem.style.width = widthinpercents + '%'; 
}

<table class="worktable"><tr>
    <?php $count = 0; 
    foreach($result as $r)
    {
        $count++; ?>
        <!-- для каждого дела вставить картинку из .img, добавить надпись из .name -->
        <td><table><tr><a href="<?=$r['url'] ?>"><img class="preview-img" src="<?=$r['pic'] ?>"></a></tr>
        <tr><a class="workurl" href="<?=$r['url']?>"><?=$r['name']?></a></tr>
        <!-- и нарисовать два прогрессбара: один с деньгами с процентом из .moneygot/.moneyneed -->
        <?php $wpercent = $r['moneygot'] / $r['moneyneed'] * 100; ?>
        <tr><div class="workprogress"><div class="workbar" id="wb<?=$count?>"></div></div><?=$wpercent?></tr>
        <!-- и второй - с прогрессом дела из .workprogress -->
        <?php $wwpercent = $r['workprogress']; ?>
        <tr><div class="workprogress"><div class="workbar" id="wba<?=$count?>"></div></div><?=$wwpercent?></tr>
            <script type='text/javascript'>
                $(function (){
                    setprogressbar("wb<?=$count?>", <?=$wpercent?>);
                    setprogressbar("wba<?=$count?>", <?=$wwpercent?>);
                });
            </script>

        
        
        </table></td>
        <?php if ($count % 4) // дела - по четыре в ряд
        { ?>
            </tr><tr>
        <?php } 
    } ?>
</tr></table>

?>