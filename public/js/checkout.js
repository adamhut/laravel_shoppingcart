Stripe.setPublishableKey(Laracasts.stripeKey);

//var form = document.querySelector('#checkout-form');
var $form = $('#checkout-form');
//console.log(form);

$form.submit(function(event){

	$('#charge-error').addClass('hidden');
	$form.find('button').prop('disabled',true);

	Stripe.card.createToken({
	  number: $('#card-number').val(),
	  cvc: $('#card-cvc').val(),
	  exp_month: $('#card-expiry-month').val(),
	  exp_year: $('#card-expiry-year').val(),
	  address_zip: $('#address_zip').val(),
	  name: $('#card-name').val(),
	}, stripeResponseHandler);
	return false;
});

function stripeResponseHandler(status, response) {

  // Grab the form:
  //var $form = $('#payment-form');

  if (response.error) { // Problem!

    // Show the errors on the form
    $('#charge-error').removeClass('hidden');
    $('#charge-error').text(response.error.message);
    $form.find('button').prop('disabled', false); // Re-enable submission

  } else { // Token was created!

    // Get the token ID:
    var token = response.id;

    // Insert the token into the form so it gets submitted to the server:
    $form.append($('<input type="hidden" name="stripeToken" />').val(token));

    // Submit the form:
    $form.get(0).submit();

  }
}
/*
form.addEventListener('submit', checkout);

function checkout()
{
	$('#charge-error').addClass('hidden');
	$	

	Stripe.card.createToken({
	  number: $('#card-number').val(),
	  cvc: $('#card-cvc').val(),
	  exp_month: $('#card-expiry-month').val(),
	  exp_year: $('#card-expiry-year').val(),
	  address_zip: $('#address_zip').val(),
	  name: $('#card-name').val(),
	}, stripeResponseHandler);
}


*/