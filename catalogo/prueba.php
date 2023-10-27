<?php
session_start();
$host = 'localhost';
$dbname = 'pruebas_f1';
$usuario = 'root';
$contrasena = 'root';

$conn = new mysqli($host, $usuario, $contrasena, $dbname);
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="img/F1logo.png">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        /* Estilos para el cuerpo y el encabezado */
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #ff2600;
            color: #fff;
            padding: 1px;
            text-align: center;
        }


        /* Estilos para el contenedor de productos */
        .product-container {
            display: flex;
            align-items: center;
            border: 1px solid #000;
            border-radius: 5px;
            max-width: 500px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            margin: 10px auto;
        }

        .product-container:hover {
            transform: scale(1.03);
        }

        .product-details {
            flex: 10;
            padding: 20px;
        }

        .product-details h2 {
            color: #ff2800;
            font-size: 30px;
            margin-bottom: 10px;
        }

        .product-details p {
            color: #555;
            font-size: 18px;
            line-height: 1.5;
        }

        .product-details button {
            background-color: #ff2800;
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            cursor: pointer;
        }

        /* Estilos para el carrusel y las imágenes */
        .product-carousel {
            max-width: 250px;
            margin-right: 20px;
        }

        .carousel img {
            width: 100%;
            height: auto;
            border-radius: 15px;
        }

        input.cantidad {
            padding: 15px;
            /* margin: 10px; */
            border: 1px solid #ccc;
            border-radius: 4px;
            border-color: #ff2800;
        }

        input.cantidad:hover {
            border-color: #ff2800;
        }

        /* Estilos para el selector de tamaño */
        #size {
            width: 100%;
            padding: 15px;
            border-radius: 15px;
            transition: all 0.3s ease-in-out;
            background-color: #fff;
            border: 2px solid #ccc;
            font-size: 15px;
        }

        #size:hover {
            border-color: #ff2800;
        }

        /* Estilos para las flechas del carrusel */
        .slick-prev:before,
        .slick-next:before {
            color: #0800ff;
        }

        /* Estilos para el pie de página */
        footer {
            background-color: #ff2800;
            color: #fff;
            text-align: center;
            padding: 20px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>

<body>
    <!-- Realizamos consulta SQL -->
    <?php
    $busqueda = mysqli_query($conn, "SELECT * FROM productos");
    $numero = mysqli_num_rows($busqueda);
    ?>
    <!-- Sección de encabezado -->
    <header>
        <h1>Productos F1</h1>
        <a href="carrito.html">carrito</a>
    </header>

    <!-- Sección del contenedor de productos -->
    <?php while ($resultado = mysqli_fetch_assoc($busqueda)) {
    ?>
        <div class="product-container">
            <div class="product-carousel">
                <div class="carousel">
                    <img src="../catalogo/img/<?php echo $resultado["imagen"]; ?>" alt="CamRedBull1" class="product-image">
                    <img src="../catalogo/img/<?php echo $resultado["imagen2"]; ?>" class="product-image">
                    <img src="../catalogo/img/<?php echo $resultado["imagen3"]; ?>" class="product-image">
                </div>
            </div>
            <!-- Sección de detalles del producto -->
            <!-- ... -->

            <!-- Sección de detalles del producto -->
            <div class="product-details">
                <h2><?php echo $resultado["nombreProducto"]; ?></h2>
                <label for "size">Talla:</label>
                <select id="size">
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                </select>
                <p>Descripción: <span id="description"><?php echo $resultado["descripcion"]; ?></span></p>
                <label for="quantity">Cantidad:</label>
                <input clas="cantidad" type="number" id="quantity" name="quantity" min="1" max="10" oninput="updatePrice()">
                <!-- Elemento para mostrar el precio -->
                <span id="price">Precio: $<?php echo $resultado["precio"]; ?></span>
                <h1></h1>
                <button onclick="addToCart()">Agregar al carrito</button>
            </div>

            <!-- ... -->

            <!-- Scripts -->
            <script>
                $(document).ready(function() {
                    $('.carousel').slick({
                        dots: true,
                        infinite: true,
                        speed: 500,
                        fade: true,
                        cssEase: 'linear'
                    });
                });

                // Función para actualizar el precio
                // function updatePrice() {
                //     var basePrice = 1000; // Precio base
                //     var quantity = parseInt(document.getElementById('quantity').value); // Cantidad seleccionada
                //     var totalPrice = basePrice * quantity; // Precio total
                //     document.getElementById('price').innerText = "$" + totalPrice; // Mostrar precio
                // }

                //var precio = <?php echo json_encode($resultado["precio"]); ?>;

                function addToCart() {
                    let cart = JSON.parse(localStorage.getItem('cart') || '[]');

                    let name = document.querySelector('.product-details h2').innerText;
                    let description = document.getElementById('description').innerText;
                    let size = document.getElementById('size').value;
                    let quantity = parseInt(document.getElementById('quantity').value);
                    let price = 1000; // Precio base
                    let image = document.querySelector('.product-carousel .carousel img').src; // Nueva línea

                    let product = {
                        name: name,
                        description: description,
                        size: size,
                        quantity: quantity,
                        price: price,
                        image: image // Nueva línea
                    };

                    cart.push(product);
                    localStorage.setItem('cart', JSON.stringify(cart));

                    alert('Producto añadido al carrito!');
                }
            </script>
        </div>
    <?php } ?>
</body>

</html>