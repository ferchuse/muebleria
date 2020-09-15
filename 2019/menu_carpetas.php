<nav class="menu navbar navbar-default ">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Cambiar Navegación</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="../index.php">
				<img src="../img/logo_menu.png" class="logo">
			</a>
		</div>
		
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<?php
					if ($_COOKIE['permiso_usuarios'] == 'mostrador' || $_COOKIE['permiso_usuarios'] == 'administrador') {
						
					?>
					<li class="<?php echo $menu_activo == "principal" ? "active" : ''; ?>">
						<a href="../index.php">
							<i class="fas fa-dollar-sign"></i> Ventas
						</a>
					</li>					
					<?php
					}
				?>
				
				<?php
					if ($_COOKIE["permiso_usuarios"] == "administrador") { ?>
					<li class=" <?php echo $menu_activo == "compras" ? "active" : ''; ?>">
						<a href="../compras/compras_lista.php">
							<i class="fas fa-shopping-cart"></i> Compras
						</a>
					</li>
					<li class="dropdown <?php echo $menu_activo == "reportes" ? "active" : ''; ?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fas fa-chart-bar"></i> Reportes <strong class="caret"></strong>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="../reportes"><i class="fas fa-chart-bar"></i> Ventas Por Día</a>
							</li>
							<li>
								<a href="../reportes/egresos.php"><i class="fas fa-chart-bar"></i> Egresos</a>
							</li>
							<li>
								<a href="../inventarios/movimientos.php"><i class="fas fa-chart-bar"></i> Movimientos</a>
							</li>
						</ul>
					</li>
					
					<li class="dropdown <?php echo $menu_activo == "productos" ? "active" : ''; ?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fas fa-list"></i> Productos <strong class="caret"></strong>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="../productos/editar.php?accion=nuevo">
										<i class="fas fa-plus"></i> Nuevo</a>
							</li>
							<li>
								<a href="../productos/editar.php?accion=editar">
										<i class="fas fa-edit"></i> Editar</a>
							</li>
							<li>
								<a href="../productos/catalogo.php"><i class="fas fa-file-alt"></i> Catálogo</a>
							</li>
						</ul>
					</li>
					
					<li class="dropdown <?php echo $menu_activo == "catalogos" ? "active" : ''; ?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fas fa-file-alt"></i> Catálogos <strong class="caret"></strong>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="../departamentos.php"><i class="fas fa-file-alt"></i> Departamentos</a>
							</li>
							<li>
								<a href="../proveedores.php"><i class="fas fa-file-alt"></i> Proveedores</a>
							</li>
							<li>
								<a href="../egresos.php"><i class="fas fa-file-alt"></i> Egresos</a>
							</li>
						</ul>
					</li>
					
					<?php
					}
					if ($_COOKIE["permiso_usuarios"] == "caja" || $_COOKIE['permiso_usuarios'] == "administrador") {
					?>
					<li class="<?php echo $menu_activo == "resumen" ? "active" : ''; ?>">
						<a href="../corte/resumen.php">
							<i class="fas fa-cash-register"></i> Corte de Caja
						</a>
					</li>
					
					<?php
					}
				?>
			</ul>
			
			<ul class="nav navbar-nav navbar-right">
				<?php
					if ($_COOKIE["permiso_usuarios"] == "administrador") {
					?>
					<li class="dropdown <?php echo $menu_activo == "control" ? "active" : ''; ?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fas fa-cog"></i> Configuración <strong class="caret"></strong>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="../usuarios/"><i class="fa fa-user-plus "></i> Usuarios</a>
							</li>
						</ul>
					</li>
					
					<?php
					}
				?>
				<li >
					<a href="index.php">
						<i class="fas fa-clock"></i> Turno <?php echo $_COOKIE["id_turnos"];?>
					</a>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-user"></i>
						<span id="menu_nombre_usuario">
							<?php echo isset($_COOKIE["nombre_usuarios"]) ? $_COOKIE["nombre_usuarios"] : "" ?>
						</span>
						<strong class="caret"></strong>
						<input type="hidden" id="id_usuarios" value="<?php echo isset($_COOKIE["id_usuarios"]) ? $_COOKIE["id_usuarios"] : ""; ?>">
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="../login/logout.php"><i class="fas fa-sign-out-alt"></i> Salir</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>