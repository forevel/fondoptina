function setprogressbar(pbname, widthinpercents) {
    alert(pbname);
    alert(widthinpercents);
    var elem = document.getElementById(pbname);
    if (widthinpercents < 10)
    {
        elem.style.backgroundColor = "orangered";
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