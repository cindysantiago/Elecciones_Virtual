

var Fwin = null;
var w = 720;
var h = 400;
var l = 260;
var t = 260;

function ventana(url)
{
	Fwin = open(url,'Fwin','width='+w+',height='+h+',left='+l+',top='+t+',status=0');
	if (Fwin && !Fwin.closed)
		Fwin.focus();
	return false;
}
function ventana2(url,w,h)
{
        Fwin = open(url,'Fwin','width='+w+',height='+h+',left='+l+',top='+t+',status=0');
        if (Fwin && !Fwin.closed)
                Fwin.focus();
        return false;
}

