function validateForm()
{
	$('.validate-error').remove();
	$('#nova_senha').removeClass('invalid-value');
	$('#confirm_nova_senha').removeClass('invalid-value');
	var valid = true;
	if($('#nova_senha').val() == ''){
		$('#nova_senha').addClass('invalid-value');
		$('#nova_senha').after("<p class='validate-error required'>Campo obrigatório!</p>");
		valid = false;
	}else if($('#nova_senha').val().length < 6){
		$('#nova_senha').addClass('invalid-value');
		$('#nova_senha').after("<p class='validate-error required'>A senha deve conter pelo menos 6 caracteres!</p>");
		valid = false;
	}
	if($('#confirm_nova_senha').val() == ''){
		$('#confirm_nova_senha').addClass('invalid-value');
		$('#confirm_nova_senha').after("<p class='validate-error required'>Campo obrigatório!</p>");
		valid = false;
	}
	if(valid){
		if($('#nova_senha').val() !== $('#confirm_nova_senha').val()){
			$('#confirm_nova_senha').addClass('invalid-value');
			$('#confirm_nova_senha').after("<p class='validate-error required'>As senhas não conferem!</p>");
			valid = false;
		}
	}
	if(valid){
		$('#LoginForm').submit();
	}
}