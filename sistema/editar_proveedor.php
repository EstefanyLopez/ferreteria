<?php 
	
	session_start();
	if($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}

	include "../conexion.php";

	if(!empty($_POST))
	{
		$alert='';
		if(empty($_POST['proveedor']) || empty($_POST['contacto']) || empty($_POST['telefono']) || empty($_POST['direccion']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$proveedor = $_POST['proveedor'];
			$contacto  = $_POST['contacto'];
			$telefono   = $_POST['telefono'];
			$direccion   = $_POST['direccion'];
			$usuario_id  = $_SESSION['idUser'];

			$result = 0;

			if(is_numeric($nit) and $nit !=0)
			{
			$query = mysqli_query($conection,"SELECT * FROM provedores
											WHERE (nit = '$nit' AND codproveedor != $codproveedor) 
								");
								
			$result = mysqli_fetch_array($query);
			$result = count($result);
			}

			if($result > 0){
				$alert='<p class="msg_error">El proveedor ya existe, ingrese otro proveedor.</p>';
			}else{

				if($init == '')
				{
					$nit = 0;
				}
				$sql_update = mysqli_query($conection,"UPDATE proveedor
															SET codproveedor = '$codproveedor', proveedor='$proveedor',contacto='$contacto',telefono='$telefono',direccion='$direccion'
															WHERE codproveedor= $codproveedor");

				if($sql_update){
					$alert='<p class="msg_save">Proveedor actualizado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al actualizar el proveedor.</p>';
				}

			}


		}

	}



	//Mostrar Datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_proveedor.php');
		mysqli_close($conection);
	}
	$idcliente = $_REQUEST['id'];

	$sql= mysqli_query($conection,"SELECT * FROM proveedor WHERE codproveedor= $codproveedor ");
	mysqli_close($conection);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_proveedor.php');
	}else{
		
		while ($data = mysqli_fetch_array($sql)) {
			# code...
			$codproveedor  = $data['codproveedor'];
			$proveedor 		= $data['proveedor'];
			$contacto  	= $data['contacto'];
			$telefono 	= $data['telefono'];
			$direccion 	= $data['direccion'];

		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Actualizar Proveedores</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<div class="form_register">
			<h1>Actualizar Proveedor</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
				<label for="proveedor">Nombre del proveedor</label>
				<input type="text" name="proveedor" id="proveedor" placeholder="Ingresar nombre del proveedor">
				<label for="contacto">Contacto</label>
				<input type="text" name="contacto" id="contacto" placeholder="Ingrese nombre del proveedor">
				<label for="telefono">Telefono</label>
				<input type="number" name="telefono" id="telefono" placeholder="Ingrese telefono">
				<label for="direccion">Direccion</label>
				<input type="direccion" name="direccion" id="direccion" placeholder="Ingrese direccion">
				
				<input type="submit" value="Actualizar proveedor" class="btn_save">

			</form>


		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>