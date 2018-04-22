 function previewImage(imgID, file)
{
	if (file)
	{
		var img = document.getElementById(imgID);
		var reader = new FileReader();
		reader.onload = (function(eImg)
		{
			return function(e)
			{
				eImg.src = e.target.result;
			}
		})(img);
		reader.readAsDataURL(file);
	}
}

/*$('.imgInp').change(function() {
  var input = $(this)[0];
  if ( input.files && input.files[0] ) {
    if ( input.files[0].type.match('image.*') ) {
      var reader = new FileReader();
      reader.onload = function(e) { $('#image_preview').attr('src', e.target.result); }
      reader.readAsDataURL(input.files[0]);
    } else console.log('is not image mime type');
  } else console.log('not isset files data or files API not supordet');
});*/