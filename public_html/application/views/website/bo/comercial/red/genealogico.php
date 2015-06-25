<div class="tab-pane fade in active" id="s1" style="margin-bottom: 6rem">
	<div class="tree smart-form">
		<ul>
			<li>
				<span><i class="fa fa-lg fa-folder-open"></i>Tú</span>
				<ul>
					<? 
						foreach ($afiliados as $key) 
						{
							if($key->debajo_de==$id)
							{?>
								<li id="<?=$key->id_afiliado?>" class="parent_li" role="treeitem" style="display: list-item;">
									<span class="quitar" onclick="subred(<?=$key->id_afiliado?>)"><i class="fa fa-lg fa-plus-circle"></i> <?=$key->afiliado?> <?=$key->afiliado_p?></span>
				                </li>
							<?}
			                                                                           
						}
					?>
				</ul>
			</li>
		</ul>
	</div>
</div>
	
<script type="text/javascript">
	function subred(id)
	{
		$("#"+id).children(".quitar").attr('onclick','');
		$.ajax({
			type: "POST",
			url: "/bo/comercial/subred",
			data: {id: id},
		})
		.done(function( msg )
		{
			$("#"+id).append(msg);
		});
	}
</script>