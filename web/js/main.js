function navigate(page)
{
	document.location=page;
}

function getcontent(page,div)
{
	$.get(page, function(data) {
		$("#"+div).html(data);
	});
}

function autoupdate(page,div,delay)
{
	var auto_refresh = setInterval(function()
	{
		$("#"+div).load(page);
	}, delay * 1000);
}

function popup(url,name,width,height) 
{
	var params = 'width='+width+', height='+height;
	params += ', directories=no';
	params += ', location=no';
	params += ', menubar=no';
	params += ', resizable=no';
	params += ', scrollbars=no';
	params += ', status=no';
	params += ', toolbar=no';
	params += ', id=serverinfo';
	newwin=window.open(url,'fp_'+name, params);
	if (window.focus) {newwin.focus()}
}