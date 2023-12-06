function initPayPalButton(total, claveTransaccion, idVenta) {
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: total,
                        currency_code: 'MXN'
                    },
                    custom_id: claveTransaccion + '#' + idVenta 
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(detalles) {
                let URL = '../usuario_normal/captura.php';
                let idTransaccion = detalles.id;
                console.log(detalles); // Maneja la lógica después de la aprobación del pago
                alert('Pago aprobado. ¡Gracias por tu compra!');
                //let URL = '../usuario_admin/captura.php';
                
               //window.location.href = URL;
                // Ahora puedes hacer algo con el ID de la transacción, como enviarlo al servidor
                return fetch(URL, {
                    method: 'post',
                    headers: {'content-type': 'application/json'},
                    body: JSON.stringify({
                        detalles: detalles,
                        id_transaccion: idTransaccion
                    })
                 })
           
            });
        },
        onError: function(err) {
            console.error('Error en el pago:', err);
            alert('Ocurrió un error durante el proceso de pago. Por favor, inténtalo de nuevo.');
        }
    }).render('#paypal-button-container');
}
