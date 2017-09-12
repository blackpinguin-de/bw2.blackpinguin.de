function runde(x, n) {
  if (n < 1 || n > 14) return false;
  var e = Math.pow(10, n);
  var k = (Math.round(x * e) / e).toString();
  if (k.indexOf('.') == -1) k += '.';
  k += e.toString().substring(1);
  return k.substring(0, k.indexOf('.') + n+1);
}


function href(seite,name)
{
if(season=="")
	{
	document.write("<a href=\""+seite+"\">"+name+"</a>");
	}
else
	{
	if(go!="inhalt/logout.php")
		{
		document.write("<a href=\""+seite+"&amp;season="+season+"\">"+name+"</a>");
		}
	else
		{
		document.write("<a href=\""+seite+"\">"+name+"</a>");
		}
	}

}

function hreft(seite,title,name)
{
if(season=="")
	{
	document.write("<a href=\""+seite+"\" title=\""+title+"\">"+name+"</a>");
	}
else
	{
	if(go!="inhalt/logout.php")
		{
		document.write("<a href=\""+seite+"&amp;season="+season+"\" title=\""+title+"\">"+name+"</a>");
		}
	else
		{
		document.write("<a href=\""+seite+"\" title=\""+title+"\">"+name+"</a>");
		}
	}

}
