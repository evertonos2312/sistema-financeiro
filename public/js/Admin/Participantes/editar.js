var read_for = ['usuario_nome', 'usuario', 'cpf', 'contmatic_id', 'razao_social'];
read_for.forEach(function(field){
	$('input[name="'+field+'"]').attr('disabled', true);
});

$('select[name="tipo"]').change(function(){
	//Padrao esconder os campos
	let hideF = {
		'contmatic_id': false,
		'razao_social': false,
		'cargo': false,
		'tel_comercial': false,
	};
	let showF = {
		
	};
	switch($(this).val()){
		case 'cliente':
			showF = {
				'contmatic_id': true,
				'razao_social': true,
				'cargo': false,
				'tel_comercial': false,
			};
			break;
		case 'nao_cliente':
			break;
		default:
			break;
	}
	hideShowFields(hideF, showF);
}).change();

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