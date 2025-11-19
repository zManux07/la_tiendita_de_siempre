document.addEventListener('DOMContentLoaded', function() {
    initializeTooltips();
    initializeValidation();
});

function initializeTooltips() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

function initializeValidation() {
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
}

function agregarCarrito(idProducto, cantidad) {
    if (!cantidad || cantidad < 1) {
        alert('Ingresa una cantidad válida');
        return;
    }

    const formData = new FormData();
    formData.append('idProducto', idProducto);
    formData.append('cantidad', cantidad);

    fetch('index.php?route=carrito/agregar', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            actualizarContadorCarrito(data.cantidad);
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function actualizarContadorCarrito(cantidad) {
    const contador = document.getElementById('contadorCarrito');
    if (contador) {
        contador.textContent = cantidad;
    }
}

function eliminarDelCarrito(idCarrito) {
    if (confirm('¿Estás seguro de que deseas eliminar este producto del carrito?')) {
        const formData = new FormData();
        formData.append('idCarrito', idCarrito);

        fetch('index.php?route=carrito/eliminar', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function actualizarCantidadCarrito(idCarrito, cantidad) {
    if (cantidad < 1) {
        alert('La cantidad debe ser mayor a 0');
        return;
    }

    const formData = new FormData();
    formData.append('idCarrito', idCarrito);
    formData.append('cantidad', cantidad);

    fetch('index.php?route=carrito/actualizar', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function mostrarAlerta(tipo, mensaje) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${tipo} alert-dismissible fade show`;
    alertDiv.role = 'alert';
    alertDiv.innerHTML = `
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    const container = document.querySelector('main') || document.body;
    container.insertBefore(alertDiv, container.firstChild);

    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

function validarFormulario(form) {
    if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
        form.classList.add('was-validated');
        return false;
    }
    return true;
}

function limpiarFormulario(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.reset();
        form.classList.remove('was-validated');
    }
}

function ocultarElemento(elementId) {
    const elemento = document.getElementById(elementId);
    if (elemento) {
        elemento.style.display = 'none';
    }
}

function mostrarElemento(elementId) {
    const elemento = document.getElementById(elementId);
    if (elemento) {
        elemento.style.display = 'block';
    }
}

function formatearMoneda(valor) {
    return new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP'
    }).format(valor);
}

function formatearFecha(fecha) {
    return new Intl.DateTimeFormat('es-CO', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    }).format(new Date(fecha));
}
