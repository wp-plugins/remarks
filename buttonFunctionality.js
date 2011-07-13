<script language="javascript"> 
<!--
var state = 'none';

function show(layer_ref, buttonRef) {

	if (document.getElementById &&!document.all) { 
		document.getElementById(layer_ref).style.visibility = "visible"; 
		document.getElementById(layer_ref).style.display = "block"; 
		if (buttonRef != ''){
		    document.getElementById(buttonRef).disabled=true;
		}
	}

} 

function hide(layer_ref, buttonRef) {

	if (document.getElementById &&!document.all) { 
		document.getElementById(layer_ref).style.visibility = "hidden"; 
		document.getElementById(layer_ref).style.display = "none"; 	
		document.getElementById(buttonRef).disabled=false;
		if (buttonRef != ''){
		    document.getElementById(buttonRef).disabled=false;
		}
		document.getElementById('all_button').disabled=false;
	} 

} 

function showAll(){
   	if (document.getElementById &&!document.all) { 
		show('post_div', ''); 
		show('category_div', ''); 
		show('author_div', '');
		
		//enable the other buttons and disable this one
		document.getElementById('post_button').disabled=false;
		document.getElementById('category_button').disabled=false;
		document.getElementById('author_button').disabled=false;
		document.getElementById('all_button').disabled=true;
	}  
}

//--> 
</script> 