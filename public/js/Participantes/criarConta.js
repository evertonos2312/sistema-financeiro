if(is_connect){
	var read_for = ['nome', 'cpf', 'contmatic_id', 'razao_social'];
	
	read_for.forEach(function(field){
		$('input[name="'+field+'"]').attr('readonly', true);
	});
}
var valid_cpf = true;
$('input[name="cpf"]').change(function(){
	
	rmvValidateError();
	if(!is_connect
	&& $('input[name="cpf"]').val() !== ''
	&& $('input[name="id"]').val() == ''){
		$.ajax({
			url: app_url+'ajax_requests/checkExistCPF',
			dataType: 'json',
			method: 'POST',
			headers: {
			  "Content-Type": "application/json",
			  "X-Requested-With": "XMLHttpRequest"
			},
			data: JSON.stringify({
				'tipo': 'nao_cliente',
				'cpf': $('input[name="cpf"]').val(),
			}),
			success: function(d){
				//Protection
			},
			complete: function(d){
				var r = d.responseJSON;
				var valid_request = false;
				if(!!r && !!r.status){
					if(r.status == 'success'){
						valid_request = true;
						if(!!r.detail){
							addValidateError('input[name="cpf"]', 'Este CPF já está cadastrado!', true);
							valid_cpf = false;
						}
					}
				}
			},
		});
	}
});

function ValidateFormCstm(frm)
{
	if(valid_cpf){
		ValidateForm(frm);
	}else{
		$('input[name="cpf"]').focus();
	}
}

$('select[name="possui_crc"]').change(function(){
	//Padrao esconder os campos
	let hideF = {
		'crc': false,
	};
	let showF = [];
	if($(this).val() == 'sim'){
		showF = {
			'crc': true,
		};
	}
	hideShowFields(hideF, showF);
}).change();

$('select[name="origem"]').change(function(){
	//Padrao esconder os campos
	let hideF = {
		'origem_outro': false,
	};
	let showF = [];
	if($(this).val() == '5'){
		showF = {
			'origem_outro': true,
		};
	}
	hideShowFields(hideF, showF);
}).change();

$('select[name="nf_tipo"]').change(function(){
	//Padrao esconder os campos
	let hideF = {
		'regime_tributacao': false,
	};
	let showF = [];
	let mask_to = '999.999.999-99';
	if($(this).val() == 'pj'){
		showF = {
			'regime_tributacao': true,
		};
		mask_to = '99.999.999/9999-99';
	}
	$('input[name="nf_cpf_cnpj"]').mask(mask_to);
	hideShowFields(hideF, showF);
}).change();