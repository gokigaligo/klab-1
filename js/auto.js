
function auto_search() {
	xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET","auto.php?nm="+document.formsearch.topsearch.value,false);
	xmlhttp.send(null);
	document.getElementById('getdata').innerHTML=xmlhttp.responseText;
}