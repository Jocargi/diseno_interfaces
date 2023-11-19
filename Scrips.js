function getAlumnos() {
    // Carga los alumnos
    var url = "Alumnos_sw.php";
    var data = { action: "get" };

    fetch(url, {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json",
        },
    })
    .then((res) => res.json())
    .catch((error) => console.error("Error:", error))
    .then(function(response) {
        var select = document.getElementById("tbody");

        for (var i = 0; i < response.data.length; i++) {
            var tr = document.createElement('tr');

            var dni = document.createElement('td');
            dni.innerHTML = response.data[i].DNI;

            var apellido1 = document.createElement('td');
            apellido1.innerHTML = response.data[i].APELLIDO_1;

            var apellido2 = document.createElement('td');
            apellido2.innerHTML = response.data[i].APELLIDO_2;

            var nombre = document.createElement('td');
            nombre.innerHTML = response.data[i].NOMBRE;

            var direccion = document.createElement('td');
            direccion.innerHTML = response.data[i].DIRECCION;

            var localidad = document.createElement('td');
            localidad.innerHTML = response.data[i].LOCALIDAD;

            var provincia = document.createElement('td');
            provincia.innerHTML = response.data[i].PROVINCIA;

            var fecha = document.createElement('td');
            fecha.innerHTML = response.data[i].FECHA_NACIMIENTO;

            var eliminar = document.createElement("td");
            eliminar.innerHTML = '<input type="submit" class="btn" value="eliminar" onclick="eliminarAlumno(' + response.data[i].DNI + ')">';

            var editar = document.createElement("td");
            editar.innerHTML = '<input type="submit" class="btn" value="editar" onclick="editarAlumno(' + response.data[i].DNI + ')">';

            tr.appendChild(dni);
            tr.appendChild(nombre);
            tr.appendChild(apellido1);
            tr.appendChild(apellido2);
            tr.appendChild(direccion);
            tr.appendChild(localidad);
            tr.appendChild(provincia);
            tr.appendChild(fecha);
            tr.appendChild(eliminar);
            tr.appendChild(editar);

            select.appendChild(tr);
        }
    });
}

function eliminarAlumno(dni) {
    console.log(dni);
    var url = "Alumnos_sw.php";

    var data = {
        action: "Delete",
        DNI: dni,
    };

    fetch(url, {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json",
        },
    })
    .then((res) => res.json())
    .catch((error) => {
        console.error("Error:", error);
    })
    .then(function(response) {
        if (response && response.success) {
            console.log("Alumno eliminado correctamente.");

        } else {
            console.error("Error al eliminar el alumno.");
        }
    });
}

function insert() {
    var url = "Alumnos_sw.php";

    // Obtén los valores del formulario
    var dni = document.getElementById('dni').value;
    var nombre = document.getElementById('nombre').value;
    var apellido1 = document.getElementById('apellido1').value;
    var apellido2 = document.getElementById('apellido2').value;
    var direccion = document.getElementById('direccion').value;
    var localidad = document.getElementById('localidad').value;
    var provincia = document.getElementById('provincia').value;
    var fecha = document.getElementById('fecha_nacimiento').value;

    var data = {
        action: "Insert",
        DNI: dni,
        NOMBRE: nombre,
        APELLIDO_1: apellido1,
        APELLIDO_2: apellido2,
        DIRECCION: direccion,
        LOCALIDAD: localidad,
        PROVINCIA: provincia,
        FECHA_NACIMIENTO: fecha
    };

    fetch(url, {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json",
        },
    })
    .then((res) => res.json())
    .catch((error) => {
        console.error("Error:", error);
    })
    .then(function(response) {
        if (response && response.success) {
            console.log("Alumno insertado correctamente.");

         
        } else {
            console.error("Error al insertar el alumno.");
        }
    });
}
