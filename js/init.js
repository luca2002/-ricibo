(function($){
  $(function(){
    $('.button-collapse').sideNav();
    $('.datepicker').pickadate({
		  selectMonths: true,
		  selectYears: 200,
		  format: 'yyyy-mm-dd'
	   });
     $('select').material_select();

  }); // end of document ready
})(jQuery); // end of jQuery name space
