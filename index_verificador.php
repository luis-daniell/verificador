<!DOCTYPE html>
<?php
	include("conexion_sql_server.php");
?>
<html lang="es" dir="ltr">
  <head>
  	<title >Verificador de Precios</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">-->
   <link href="css/bootstrap-toggle.css" rel="stylesheet">
   <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <link rel="stylesheet" href="css/media.css">

    <title></title>
  </head>
  
  <body  style="background-color:lightgreen;">
    <div class="container ">
		<img src="logo2.jpg"  class="center-block w-50%" alt="">
    	<h1 class="text-center " style="color:Gray; font-family: Arial,Helvetica, sans-serif;"><a href="index.php" class="tittle-link"> Verificador De Precios</a></h1>
       
		<br><br>
		
        <div class="row form-cod" >
          <form  method="post" action="index.php">
          <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
          	
          
				<div class="row">
              		<div class="col-xs-4 col-xs-offset-0 col-sm-3 col-sm-offset-3 col-md-2 col-md-offset-0 col-lg-1 col-lg-offset-1">
              			<div class="form-group">
							<button type="submit" name="buscarx" style="height:50px;" class="btn btn-primary ">
								<span class="">Buscar</span>
							</button>
						</div>

              		</div>
              		
              		<div class="col-xs-8 col-xs-offset-0 col-sm-4 col-sm-offset-0  col-md-3 col-md-offset-0 col-lg-3 col-lg-offset-0">
              			<div class="form-group div-check">
              				<label>Descripción</label>
							<input type="checkbox" id="Checkk"  data-toggle="toggle" data-on="Si" data-off="No" name="descrip"  data-onstyle="success" data-offstyle="danger"></input>
							
							<script>
  function toggleOn() {
    $('#Checkk').bootstrapToggle('off')
  }
</script>
						</div>
              		</div>
              		
              		<div class="col-xs-12 col-xs-offset-0 col-sm-6 col-sm-offset-3 col-md-7 col-md-offset-0 col-lg-6 col-lg-offset-0">
              			<div class="form-group">
							<input type="text" style="height:50px;" name="buscar" class="form-control" placeholder="Ingrese el código a buscar." autofocus>
						</div>
              			
              		</div>
              		
              	</div>
             

          </div>
				
          </form>

			

        </div>

          <?php
          
            if (isset($_POST['buscar'])) {
							$codigo = $_POST['buscar'];
							if (isset($_POST['descrip'])){
										//$consulta = "SELECT * FROM prods where DESCRIP LIKE '%$codigo%'";
										$consulta = "select prods.articulo,prods.descrip,prods.imagen,
													impuestos.valor,prods.precio1,prods.precio2,prods.precio3
													from prods inner join impuestos on prods.impuesto = impuestos.impuesto
													where prods.articulo LIKE '%$codigo%'";
							}else{
								//$consulta = "SELECT * FROM prods WHERE ARTICULO='$codigo'";
								$consulta = "select prods.articulo,prods.descrip,prods.imagen,
													impuestos.valor,prods.precio1,prods.precio2,prods.precio3
													from prods inner join impuestos on prods.impuesto = impuestos.impuesto
													where prods.articulo = '$codigo'";
							}
              $ejecutar = sqlsrv_query($conn_sis,$consulta,array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
							$row_count = sqlsrv_num_rows( $ejecutar );


							if ($row_count !== 0) {
									if($row_count > 1){
										echo "<br><br><br> <div class='list-group' align='center'>";
										while ($datos = sqlsrv_fetch_array($ejecutar)) {
											$descripcion = $datos[1];
											echo "<a href='index.php?buscaArt=$descripcion' class='list-group-item'>
											   $descripcion
											</a>";
										}
										echo "</div>";
									}else{
										showArticulo($ejecutar);
									}
							}else{
								echo "<br><br><br>
								<div class='alert alert-warning col-md-8 col-md-offset-2'>
										<strong>Código no encontrado!</strong><br><br> El código que ingresó no se encuentra o verifique que lo escribio correctamente
								</div>";
							}
				 }

				 function showArticulo($art){
				 	setlocale(LC_MONETARY,"es_MX");
					 $datos = sqlsrv_fetch_array($art);
					//echo " ".$datos[3];
					 $articulo = $datos[0];
					 $descripcion = $datos[1];
					 
					 $img = $datos[2];
					 $imp = $datos [3];
					
					 
					 $ejecimpuestos = ($imp/100)+1;
					 //round($datos[4]*$ejecimpuestos * 100) / 100
					 //money_format("%.2n",round($datos[4]*$ejecimpuestos * 100) / 100 );
					 $p1 = round($datos[4]*$ejecimpuestos * 100) / 100;
					 $p2 = round($datos[5]*$ejecimpuestos * 100) / 100;
					 $p3 = round($datos[6]*$ejecimpuestos * 100) / 100;
					 //echo " ".money_format('%i', $p1) . "\n";

					 

					 if ($img=="") {
					 
					 }else{
					 	$extension = substr($img,-3);

					 	$dir="img\\".$articulo.".".$extension;

					 	if(file_exists($dir)){
					 		//echo "El fichero $dir Existe";
						 	}else{
						 		if (file_exists($img)) {
						 			$dir= getcwd() . "\img\\".$articulo.".".$extension;
							copy($img, $dir);
							//$dir="img\prueba.".$extension;
							$dir="img\\".$articulo.".".$extension;
						 		}else{
						 			$dir="";
						 		}
						 		
						 	}


					 	//$dir= getcwd() . "\img\prueba.".$extension;
					 	
						//echo "ruta de copia: ".$img." a la cual copia: ".$dir;
					 }


		


					 $Muestra="";
					 $Muestra = "<br><br>
					 <div class='row box-prod'>
						 <div class='col-xs-12 col-xs-offset-0 col-sm-12 col-sm-offset-0 col-md-6  col-md-offset-0 col-lg-8 col-lg-offset-0'>
							 <br>
								 <font size='4' >Código: </font>
								 <br>
								 <font size='6' style='color:DodgerBlue;'> $articulo </font>
								 <br><br>
								 <font size='4'>Descripción:</font>
								 <br>
								 <font size='6' style='color:DodgerBlue;'>$descripcion</font>
								 <br><br>
								 <font size='4'>Precio 1:</font>
								 <br>
								 <font size='6' style='color:Tomato;'>$$p1</font>
								 <br><br>";

					

								 if ($p2 > 0 ) {
									$Muestra = $Muestra."<font size='4'>Precio 2:</font>
								 <br>
								 <font size='6' style='color:Tomato;'>$$p2</font>
								 <br><br>";
								 }
								 if ($p3 >0) {
									$Muestra = $Muestra."<font size='4'>Precio 3:</font>
								 <br>
								 <font size='6' style='color:Tomato;'>$$p3</font>
								 <br><br>";
								 }
								 echo $Muestra."</div> <br><br><br><br>

								 ";
								 if ($img != "") {
								echo "<div class='col-xs-8 col-xs-offset-2 col-sm-8 col-sm-offset-2  col-md-4 col-md-offset-0 col-lg-4 col-lg-offset-0'>
										<img src=$dir class='img-responsive' >
									</div>";
									}else{
										echo "</div>";
									}

							

							
							//echo "</div>";
					}

					if (isset($_GET['buscaArt'])) {
						$busca_art = $_GET['buscaArt'];
						//$consulta2 = "SELECT * FROM prods WHERE DESCRIP= '$busca_art'";
						$consulta2 = "select prods.articulo,prods.descrip,prods.imagen,
													impuestos.valor,prods.precio1,prods.precio2,prods.precio3
													from prods inner join impuestos on prods.impuesto = impuestos.impuesto
													where prods.descrip = '$busca_art'";
						$ejecutar = sqlsrv_query($conn_sis, $consulta2);
						

						showArticulo($ejecutar);
					}
				  ?>

</div>
<div class="footer">
  <p><a href="https://bytesmx.com" target="_blank">Bits&Bytes 2018</a></p>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="js/bootstrap-toggle.js"></script>
  </body>
</html>
