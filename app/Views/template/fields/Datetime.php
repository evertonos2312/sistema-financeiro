<label for="{$name}">{$label}</label>{if $required} <span class="required">*</span>{/if}
<p><input class="form-control {if $error}invalid-value{/if}" type="text" name="{$name}" value="{$value}" {$ext_attrs} {if $disabled}disabled="true"{/if} />{if $error}<span class='validate-error required'>{$error}</span>{/if}</p>
<script type="text/javascript">
$('input[name="{$name}"]').datetimepicker({literal}{{/literal}
	{if $value != ""}
		defaultDate: moment("{$value}", "DD/MM/YYYY HH:i"),
	{/if}
	locale: 'pt-br',
{literal}}{/literal});
$('input[name="{$name}"]').mask('99/99/9999 99:99');
</script>