/* http://webcodius.ru/recepty-dlya-sajta/stilizaciya-input-file-css-stilizaciya-polya-dlya-zagruzki-fajla.html */

function previewImage(number, file)
{
    try {
        if (file) {
    		var fileSize = 0; 					
				
            if (file.size > 1024 * 1024) {
                fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
            }else {
                fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
            }

            document.getElementById('file-name'+number).value = file.name;
            document.getElementById('file-size'+number).innerHTML = 'Размер: ' + fileSize;

            if (/\.(jpe?g|bmp|gif|png)$/i.test(file.name)) {		
                var reader = new FileReader();
                reader.onload = function(e) {
                        document.getElementById('imgP'+number).src=e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }
    }catch(e) {
        var file = document.getElementById('uploaded-file'+number).value;
        file = file.replace(/\\/g, "/").split('/').pop();
        document.getElementById('file-name'+number).innerHTML = 'Имя: ' + file;
    }
}

function addFileInput()
{
    if (fileindex > 9)
        return;
    var tpl = "<div class=\"file-upload\"><label><input id=\"uploaded-file"+fileindex+"\" type=\"file\" name=\"image"+fileindex+"\" onchange=\"previewImage("+fileindex+", this.files[0]);\" /><span>Выберите файл</span><br /></label></div><input name=\"file-name"+fileindex+"\" id=\"file-name"+fileindex+"\" class=\"divtablecell\" value=\"\" /><div class=\"divtablecell preview-img\"><img class=\"preview-img\" id=\"imgP"+fileindex+"\" src=\"\" /></div><div id=\"file-size"+fileindex+"\" class=\"divtablecell\">&nbsp;</div><div class=\"divtablecell\"><input type=\"button\" value=\"Удалить файл\" onclick=\"removeFileInput("+fileindex+")\" /></div><br />";
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