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