//html cards author: https://codepen.io/cssgirl/pen/NGKgrM




window.addEventListener('load', function(){
	
 $('.modal').modal({
      dismissible: true, // Modal can be dismissed by clicking outside of the modal
      opacity: .5, // Opacity of modal background
      inDuration: 300, // Transition in duration
      outDuration: 200, // Transition out duration
      startingTop: '4%', // Starting top style attribute
      endingTop: '10%', // Ending top style attribute
 /*      ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
        alert("Ready");
        console.log(modal, trigger);
      },
      complete: function() { alert('Closed'); } // Callback for Modal close */
    }
  );	


});

//categorie di voto
var voto = [0,0,0];
var categorieVotate=0;
var tags = [
'<div class="chip" id="chip-0">valore estetico ed artistico<i onclick="unvote(0)"class="close-custom material-icons">close</i></div>',
'<div class="chip" id="chip-1">efficacia comunicativa<i onclick="unvote(1)"class="close-custom material-icons">close</i></div>',
'<div class="chip" id="chip-2" >adattabilità e facilità di riproduzione<i onclick="unvote(2)" class="close-custom material-icons">close</i></div>'
]

var logoAperto;

function openDescr(id,descr){
	console.log("click");
	$('#inner-description').text(descr);
	$('#modal1').modal('open');
}
function openVote(i){
	logoAperto=i;
	$('#modal2').modal('open');
}
function vote(category){
	if(voto[category]!=logoAperto){
	    if(voto[category]==0){categorieVotate++;}
		else{$('#chip-'+category).remove();}
		voto[category] = logoAperto;
		//aggiunge il chip alla card selezionata
		$('#c-card-'+logoAperto).append(tags[category]);
	}else{
		//unvote(category)
	}
		console.log(voto,categorieVotate);	
}
function unvote(category){
	voto[category]=0;
	categorieVotate--;
	//rimuove il chip dalla card
	$('#chip-'+category).remove();
}

function sendForm(){
	var mail = $("#email").val();
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	re.test(mail);
	if(!mail){
		alert('inserisci una mail valida');
	}else if(categorieVotate!==3){
		alert('devi prima votare per tutte e tre le categorie');
	}else{
		 $('<form action="voto.php" method="post"><input name="data" type="hidden" value = "'+voto[0]+'-'+voto[1]+'-'+voto[2]+'"/><input name="mail" type="hidden" value = "'+mail+'"/></form>').appendTo('body').submit();

	}
}