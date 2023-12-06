<?php 
require_once ( '../modelos/config.php');
include '../modelos/conexion.php';
include '../carrito.php';
include 'cabecera.php';
?>
<br>
    <?php if($mensaje!=""){?>
        <div class="alert alert-success">
           
            <?php echo $mensaje;?>
            <a href="../mostrarCarrito.php" class="badge badge-success">Ver carrito</a>
        </div>
    <?php }?>

<div class="row" id="row">
    <?php 
    //Estructura PDO
    $sentencia = $pdo->prepare("SELECT * FROM `tblproductos`");
    $sentencia->execute();
    $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($listaProductos as $producto) { // Abre el bucle foreach 
    ?>
        <div class="col-md-3 col-sm-6">
            <div class="fila">
                <div class="product-grid5" onclick="cargar(this)">
                    <div class="product-image5">
                        <a href="#">
                            <img title="<?php echo $producto['Nombre'];?>" class="pic-1" 
                            src="<?php echo $producto['Imagen'];?>"
                            >
                            <img class="pic-2" src="<?php echo $producto['Imagen2'];?>">
                        </a>
                        <ul class="social">
                            <li><a href="" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                            <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-shopping-bag"></i></a></li>
                            <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                        <a href="#" class="select-options"><i class="fa fa-arrow-right "></i> Select Options</a>
                    </div>
                  <!--   <div class="product-content">
                        <h3 class="title"><a href="#"><?php echo $producto['Nombre'];?></a></h3>
                        <p class="card-text"><?php echo $producto['Descripcion'];?></p>
                        <h5 class="precio">$<?php echo $producto['Precio'];?></h5>
                      
                    </div>-->
                </div>
            </div>
            <div class="card-body">
                        <span><?php echo $producto['Nombre'];?></span>
                        <h5 class="card-title">$<?php echo $producto['Precio'];?></h5>
                        <h5 class="card-title">Cantidad Disponible: <?php echo $producto['UnidadesEnStock'];?></h5>
                  
                        <form action="" method="post">
                        <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($producto['ID'],COD,KEY);?>">
                        <input type="hidden" name="nombre" id="nombre" value="<?php echo openssl_encrypt($producto['Nombre'],COD,KEY);?>">
                        <input type="hidden" name="precio" id="precio" value="<?php echo  openssl_encrypt($producto['Precio'],COD,KEY);?>">
                        <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1,COD,KEY);?>">
                        
                        <button class="btn btn-primary" name="btnAccion" value="Agregar" 
                        type="submit" style="background-color: #FFD700; color: white;">Agregar al carrito</button>

                        </form>  
                    </div>
        </div>

    <?php
    } 
    ?>
</div>

</div>
</body>
</html>