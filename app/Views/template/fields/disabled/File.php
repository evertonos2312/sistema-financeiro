<label for="{$name_id}">{$label}</label>
<p><input type="hidden" name="{$name}" value="{$value_id}" {$ext_attrs} disabled="true" />
{if $value}<a class="link link-related-record" href="{$app_url}downloadManager/download/{$value}">{/if}<input class="form-control" type="text" name="{$filename_field}" value="{$value_nome}" {$ext_attrs} disabled="true" />{if $value}</a>{/if}
</p>