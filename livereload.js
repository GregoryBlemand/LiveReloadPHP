function req(){
	var xhr = new XMLHttpRequest();
	var loc = document.location.pathname;
	var list = 'verif.php|' + '.' + loc.substring(loc.lastIndexOf('/'));
	xhr.open('GET', 'verif.php?watch=' + list);
	xhr.send(null);
		xhr.addEventListener('readystatechange', function() {
	    if (xhr.readyState === XMLHttpRequest.DONE) { 
    		if(xhr.responseText == 'true'){
    			document.location.reload(true); // commande pour reload la page
    		}
	    }
	});
	setTimeout(req,500);
}
		
setTimeout(req,500);