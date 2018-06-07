/* http://webcodius.ru/recepty-dlya-sajta/stilizaciya-input-file-css-stilizaciya-polya-dlya-zagruzki-fajla.html */

function previewImage(inputname, file)
{
    if (file) {
        var fileSize = 0; 					

        if (file.size > 1024 * 1024) {
            fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
        }else {
            fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
        }

        document.getElementById(inputname+'_name').value = file.name;
        document.getElementById(inputname+'_size').innerHTML = 'Размер: ' + fileSize;

        if (/\.(jpe?g|bmp|gif|png)$/i.test(file.name)) {		
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(inputname+'_preview').src=e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
}

function addFileInput(maxfiles)
{
    if (fileindex >= maxfiles)
        return;
    var tpl = "<div class=\"file-upload\"><label><input id=\"workpic"+fileindex+"\" type=\"file\" name=\"workpic"+fileindex+"\" onchange=\"previewImage('workpic"+fileindex+"', this.files[0]);\" /><span>Выберите файл</span><br /></label></div><input name=\"workpic"+fileindex+"_name\" id=\"workpic"+fileindex+"_name\" class=\"divtablecell\" value=\"\" /><div class=\"divtablecell preview-img\"><img class=\"preview-img\" id=\"workpic"+fileindex+"_preview\" src=\"\" /></div><div id=\"workpic"+fileindex+"_size\" class=\"divtablecell\">&nbsp;</div><div class=\"divtablecell\"><input type=\"button\" value=\"Удалить файл\" onclick=\"removeFileInput("+fileindex+")\" /></div><br />";
    var fileinputdiv = document.getElementById('fileinputs');
    var content = document.createElement('div');
    content.setAttribute('id', 'fileinputdiv'+fileindex);
    content.setAttribute('class', 'file-form-wrap divtable');
    content.innerHTML = tpl;
    fileinputdiv.appendChild(content);
    fileindex++;
}

function removeFileInput(index)
{
    var fileinputdiv = document.getElementById('fileinputs');
    var content = document.getElementById('fileinputdiv'+index);
    fileinputdiv.removeChild(content);
}