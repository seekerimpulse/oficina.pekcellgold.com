<table  id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
								<thead>
									<tr>
										<th data-hide="phone">ID</th>
										<th data-class="expand">Fecha Solicitud</th>
										<th data-hide="phone">Fecha Pago</th>	
										<th data-hide="phone">Usuario</th>
										<th data-hide="phone,tablet">Metodo</th>
										<th data-hide="phone,tablet">Valor</th>
										<th data-hide="phone,tablet">Estado</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($cobros as $cobro) {?>
										<tr>
											<td><?php echo $cobro->id_cobro; ?></td>
											<td><?php echo $cobro->fecha; ?></td>
											<td><?php echo $cobro->fecha_pago; ?></td>
											<td><?php echo $cobro->usuario; ?></td>
											<td><?php echo $cobro->metodo_pago; ?></td>
											<td><?php echo $cobro->monto; ?></td>
											<td><?php echo $cobro->estado; ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
