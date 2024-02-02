// Función para obtener la lista de alumnos del servidor y mostrarla
const URL = "Alumnos_sw.php";

function getAlumnos(pagina = 1) {
    

    var data = { action: "get", pagina: pagina }; 

    fetch(URL, {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json",
        },
    })
    .then((res) => res.json())
    .catch((error) => console.error("Error:", error))
    .then((response) => {
        tablaMostrar(response.data);

        // Actualiza el total de registros y el paginador
        totalRegistros();
    });
}


    // Función para mostrar la tabla en en html
    
function tablaMostrar(Alumnos){
    
    // sirve para cargar la tabla de alumnos
    var select = document.getElementById("tbody");
    select.innerHTML = "";


    for (var i = 0; i < Alumnos.length; i++) {
        var tr = document.createElement('tr');

        var dni = document.createElement('td');
        dni.innerHTML = Alumnos[i].DNI;

        var apellido1 = document.createElement('td');
        apellido1.innerHTML = Alumnos[i].APELLIDO_1;

        var apellido2 = document.createElement('td');
        apellido2.innerHTML = Alumnos[i].APELLIDO_2;

        var nombre = document.createElement('td');
        nombre.innerHTML = Alumnos[i].NOMBRE;

        var direccion = document.createElement('td');
        direccion.innerHTML = Alumnos[i].DIRECCION;

        var localidad = document.createElement('td');
        localidad.innerHTML = Alumnos[i].LOCALIDAD;

        var provincia = document.createElement('td');
        provincia.innerHTML = Alumnos[i].PROVINCIA;

        var fecha = document.createElement('td');
        fecha.innerHTML = Alumnos[i].FECHA_NACIMIENTO;
            // optiene el dni del aulumno que quiero eliminar
        var eliminar= document.createElement("button");
        eliminar.setAttribute('id', Alumnos[i].DNI );

        //optiene el dni del aLumno que quiere editar
        var editar= document.createElement("button");
        editar.setAttribute('id', Alumnos[i].DNI );
        editar.innerHTML = 'Actualizar';
       // aqui
        editar.onclick = function () {
            var dni = this.getAttribute("id");
            var dni_ = document.getElementById("dni");
            dni_.value = dni;
            ObtenerAlumno(dni);
        };

        eliminar.innerHTML = 'Eliminar';
    
        eliminar.onclick = function () {
            var dni = this.getAttribute("id");

            eliminarAlumno(dni);
        };
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
// funcion para limpiar la tabla
}
function limpiarTabla(table){
    while(table.rows.length>0) table.deleteRow(0);
}
// Función para eliminar
function eliminarAlumno(dni) {
 
    var table=document.getElementById('tbody')

    var data = {
        action: "Delete",
        DNI: dni,
    };

    fetch(URL, {
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
    .then((response)=> {

          limpiarTabla(table);
            getAlumnos();  
     
    });
}
// Función para insertar un nuevo alumno

function insert() {

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

    fetch(URL, {
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
    .then((response)=> {

    });
}
// Función para obtener los datos de un alumno específico
function ObtenerAlumno(dni) {
    var data = { action: "Buscar", DNI:dni};
    

    fetch(URL,{
        method:"POST",
        body:JSON.stringify(data),
        headers:{
            "Content-Type":"application/json",
        },
    })
    .then((res)=>res.json())
    
    .then((response)=>{
       
      document.getElementById("nombre").value= response.data[0].NOMBRE
      document.getElementById("apellido1").value = response.data[0].APELLIDO_1;
      document.getElementById("apellido2").value = response.data[0].APELLIDO_2
      document.getElementById("direccion").value = response.data[0].DIRECCION;
      document.getElementById("localidad").value = response.data[0].LOCALIDAD;
      document.getElementById("provincia").value = response.data[0].PROVINCIA;
      document.getElementById("fecha_nacimiento").value = response.data[0].FECHA_NACIMIENTO;
    })
    .catch((error) => console.error("Error",error))
}



// Función para actualizar un alumno
function update() {
    var table=document.getElementById('tbody')

    var dni = document.getElementById('dni').value;
    var nombre = document.getElementById('nombre').value;
    var apellido1 = document.getElementById('apellido1').value;
    var apellido2 = document.getElementById('apellido2').value;
    var direccion = document.getElementById('direccion').value;
    var localidad = document.getElementById('localidad').value;
    var provincia = document.getElementById('provincia').value;
    var fecha_nacimiento = document.getElementById('fecha_nacimiento').value;

    var data = {
        action: "Update",
        DNI: dni,
        NOMBRE: nombre,
        APELLIDO_1: apellido1,
        APELLIDO_2: apellido2,
        DIRECCION: direccion,
        LOCALIDAD: localidad,
        PROVINCIA: provincia,
        FECHA_NACIMIENTO: fecha_nacimiento,
    };

    fetch(URL, {
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
    .then((response)=> {
        tablaMostrar(response.data); 
 
    });
}
// funcion del buscador
function buscarAlumnos() {
    var dni = document.getElementById('dniBuscar').value;
    var nombre = document.getElementById('nombreBuscar').value;

    var data = {
        action: "BuscarAlumno",
        DNI: dni,
        NOMBRE: nombre
    };

    fetch(URL, {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json",
        },
    })
    .then((res) => res.json())
    .catch((error) => console.error("Error en la solicitud:", error))
    .then((response) => {
        if (response.success) {
            // Actualiza la tabla
            tablaMostrar(response.data);

            // Actualiza el total de registros y el paginador
            totalRegistros(true); // Se aplica un filtro
        }
    });
}


function totalRegistros(filtro = false) {
    var totalRegistros = document.getElementById('TotalR');
    var totalPaginas = document.getElementById('TotalPaginas');
    var data = {
        action: "TotalRegistros",
        filtro: filtro
    };

    fetch(URL, {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json",
        },
    })
    .then((res) => res.json())
    .catch((error) => console.error("Error en la solicitud:", error))
    .then((response) => {
        totalRegistros.innerHTML = "total de registros: " + response.data[0]["COUNT(*)"];
        totalPaginas.innerHTML = "total de paginas: " + Math.ceil(response.data[0]["COUNT(*)"] / 10);
    });
}

function paginador(boton) {
    var paginaActual = document.getElementById("pagina").value;
    var table = document.getElementById('tbody');
    var dni = document.getElementById('dniBuscar').value;
    var nombre = document.getElementById('nombreBuscar').value;

    // Hacer una solicitud para obtener el número total de registros con el filtro actual
    var filtroData = {
        action: "TotalRegistros",
        filtro: true
    };

    fetch(URL, {
        method: "POST",
        body: JSON.stringify(filtroData),
        headers: {
            "Content-Type": "application/json",
        },
    })
    .then((res) => res.json())
    .catch((error) => console.error("Error en la solicitud de filtro:", error))
    .then((filtroResponse) => {
        if (!filtroResponse.success) {
            console.error("Error al obtener el número total de registros:", filtroResponse.msg);
            return;
        }

        var maxPaginas = Math.ceil(filtroResponse.data[0]["COUNT(*)"] / 10);

        if (boton == 1) {
            paginaActual = 1;
        } else if (boton == 2) {
            paginaActual = Math.max(1, paginaActual - 1);
        } else if (boton == 3) {
            paginaActual = Math.min(maxPaginas, paginaActual + 1);
        } else if (boton == 4) {
            paginaActual = maxPaginas;
        }

        document.getElementById("pagina").value = paginaActual;

        var data = {
            action: "get",
            pagina: paginaActual,
            DNI: dni,
            NOMBRE: nombre
        };

        // Hacer la solicitud para obtener los datos de la página actual
        fetch(URL, {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                "Content-Type": "application/json",
            },
        })
        .then((res) => res.json())
        .catch((error) => console.error("Error en la solicitud:", error))
        .then((response) => {
            limpiarTabla(table);
            tablaMostrar(response.data);
        });
    });
}


