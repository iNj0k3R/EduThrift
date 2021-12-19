var form_ele = '.form';

// make eveything disabled
var disableFormEdit = function(selector){	
  $(selector).removeClass('form--enabled').addClass('form--disabled');
	$(selector + ' input, ' + selector + ' select, ' + selector + ' button').prop('disabled', true);
}


// make eveything enabled
var enableFormEdit = function(selector){	
	$(selector + ' input, ' + selector + ' select, ' + selector + ' button ').prop('disabled', false);
  $(selector).removeClass('form--disabled').addClass('form--enabled');
}


disableFormEdit(form_ele);


$('.js-toggleForm').click(function(){
   // get the status of form
  var form_status = $(form_ele).hasClass('form--disabled') ? 'disabled' : 'enabled';
  
  // check if disabled or enabled
  switch (form_status){
    case 'disabled':
      enableFormEdit(form_ele);
      $(this).text('Save')
      break;
    case 'enabled':
      disableFormEdit(form_ele);
      $(this).text('Edit')
      break;
  }
});

//Pop-up for profile upload
$('.profile-image').click(function(){
  $('.image-popup').addClass('open');
});

$('.pop-up .close').click(function(){
  $('.pop-up').removeClass('open');
});


//Pop-up for email 
$('.pop-input input').click(function(){
  $('.email-popup').addClass('open');
});

$('.pop-up .close').click(function(){
  $('.pop-up').removeClass('open');
});


//Pop-up for password verification
$('.pop-input1 input').click(function(){
  $('.pop-up1').addClass('open');
});

$('.pop-up1 .close').click(function(){
  $('.pop-up1').removeClass('open');
});



