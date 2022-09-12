<div class="content-widgets white">
						<div class="widget-head light-blue">
							<h3><i class="icon-comments-alt"></i> Chat</h3>
						</div>
						<div class="widget-container">
							<div class="tab-widget tabbable tabs-left chat-widget">
								
								<ul class="nav nav-tabs" id="chat-tab">
									<?php
									$usuariosChat = mysql_query("SELECT * FROM usuarios WHERE usr_bloqueado='0'",$conexion);
									while($uChat = mysql_fetch_array($usuariosChat)){
									?>
									<li>
										<a href="#user" id="<?=$uChat['usr_id'];?>" name="<?=$_SESSION["id"];?>" onClick="listarTareas(this)"> 
											<span class="user-online"></span><i class="icon-user"></i> <?=$uChat['usr_nombre'];?>
										</a>
									</li>
									<?php }?>
								</ul>
								
								<div class="tab-content">
									<div class="tab-pane active" id="user">
										<p id="listarDatos"></p>
									</div>
									
									
									
								</div>
								
								<div class="chat-input">
									<input type="hidden" id="nombreOrigen" value="<?=$datosUsuarioActual['usr_nombre'];?>">
									<input type="hidden" id="origen" value="<?=$_SESSION["id"];?>">
									<input type="hidden" id="destino">
									<textarea class="chat-inputbox span12" name="input" id="mensaje"></textarea>
									<button class="btn btn-primary btn-large" type="button" onClick="insertar()"><i class="icon-ok"></i> Enviar</button>
								</div>
							</div>
						</div>
					</div>