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

function openDescr(id,descr){
	console.log("click");
	$('#inner-description').text(descr);
	$('#modal1').modal('open');
}
function vote(i){
	$('#modal2').modal('open');
}