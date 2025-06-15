document.addEventListener("DOMContentLoaded", () => {
  const contenedor = document.getElementById("contenedor");
  const btnUsers = document.getElementById("btnUsers");
  const btnReservas = document.getElementById("btnReservas");
  const btnHabitaciones = document.getElementById("btnHabitaciones");

  // --------------------- BOTONES PANEL ---------------------
  if (btnUsers) btnUsers.addEventListener("click", () => cargarUsuarios());
  if (btnReservas)
    btnReservas.addEventListener("click", () => cargarReservas());

  // --------------------- HABITACIONES ---------------------
  if (btnHabitaciones) {
    btnHabitaciones.addEventListener("click", () => {
      fetch("adminhabitaciones.php")
        .then((res) => res.text())
        .then((data) => {
          contenedor.innerHTML = data;
          cargarHabitaciones();

          const form = document.getElementById("formCrearHabitacion");
          if (form) {
            form.addEventListener("submit", async (e) => {
              e.preventDefault();
              const datos = new FormData(form);
              const res = await fetch("createhabitaciones.php", {
                method: "POST",
                body: datos,
              });
              const txt = await res.text();
              document.getElementById("respuestaHabitacion").innerHTML = txt;
              cargarHabitaciones();
              form.reset();
            });
          }
        });
    });
  }

  // --------------------- LOGIN ---------------------
  const formLogin = document.getElementById("formLogin");
  const respuestaDiv = document.getElementById("respuesta");

  if (formLogin) {
    formLogin.addEventListener("submit", async function (e) {
      e.preventDefault();
      const datos = new FormData(formLogin);
      const res = await fetch("autenticar.php", {
        method: "POST",
        body: datos,
      });
      const json = await res.json();

      if (json.status === "admin" || json.status === "cliente") {
        bootstrap.Modal.getInstance(
          document.getElementById("modalLogin")
        ).hide();
        window.location.reload();
        return;
      }

      if (json.status === "error") {
        respuestaDiv.innerHTML = json.mensaje;
        setTimeout(() => {
          const enlace = document.getElementById("enlaceCrearCuenta");
          if (enlace) {
            enlace.addEventListener("click", (e) => {
              e.preventDefault();
              bootstrap.Modal.getInstance(
                document.getElementById("modalLogin")
              ).hide();
              new bootstrap.Modal(
                document.getElementById("modalCrearCuenta")
              ).show();
            });
          }
        }, 50);
      }
    });
  }

  // --------------------- REGISTRO ---------------------
  const formCrear = document.getElementById("formCrearCuenta");
  const respuestaRegistro = document.getElementById("respuestaRegistro");

  if (formCrear) {
    formCrear.addEventListener("submit", async function (e) {
      e.preventDefault();
      const datos = new FormData(formCrear);
      const res = await fetch("createusers.php", {
        method: "POST",
        body: datos,
      });
      const json = await res.json();

      respuestaRegistro.innerHTML = json.mensaje;

      if (json.status === "success") {
        setTimeout(() => {
          bootstrap.Modal.getInstance(
            document.getElementById("modalCrearCuenta")
          ).hide();
          new bootstrap.Modal(document.getElementById("modalLogin")).show();
          cargarUsuarios();
        }, 2000);
      }
    });
  }
});

//CRUD USUARIOS
let ordenActual = "id";
let buscarActual = "";

function cargarUsuarios(pagina = 1) {
  fetch(
    `readusers.php?pagina=${pagina}&orden=${ordenActual}&buscar=${buscarActual}`
  )
    .then((res) => res.json())
    .then((data) => mostrarTabla(data));
}

function mostrarTabla(datos) {
  const usuarios = datos.data;
  const pagina = datos.pagina;
  const totalPaginas = datos.nropaginas;
  const orden = datos.orden;
  const buscar = datos.buscar;

  let html = `
    <div class="row mb-3 align-items-end">
      <div class="col-md-4">
        <label class="form-label">Buscar:</label>
        <input type="text" id="campoBuscar" class="form-control" value="${buscar}">
      </div>

      <div class="col-md-3">
        <label class="form-label">Ordenar por:</label>
        <select id="selectOrden" class="form-select">
          <option value="id" ${orden === "id" ? "selected" : ""}>ID</option>
          <option value="correo" ${
            orden === "correo" ? "selected" : ""
          }>Correo</option>
          <option value="rol" ${orden === "rol" ? "selected" : ""}>Rol</option>
        </select>
      </div>
    </div>

    <h4 class="mb-3">Listado de Usuarios</h4>
    <table class="table table-bordered text-center align-middle">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Correo</th>
          <th>Rol</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
  `;

  for (let i = 0; i < usuarios.length; i++) {
    const usuario = usuarios[i];
    html += `
      <tr>
        <td>${usuario.id}</td>
        <td>${usuario.correo}</td>
        <td>${usuario.rol}</td>
        <td>
          <button class="btn btn-sm btn-primary" onclick="editarUsuario(${usuario.id}, '${usuario.correo}', '${usuario.rol}')">Editar</button>
          <button class="btn btn-danger btn-sm" onclick="eliminarUsuario(${usuario.id})">Eliminar</button>
        </td>
      </tr>
    `;
  }

  html += `
      </tbody>
    </table>
    <nav>
      <ul class="pagination justify-content-center">
  `;

  for (let i = 1; i <= totalPaginas; i++) {
    html += `
      <li class="page-item ${i === parseInt(pagina) ? "active" : ""}">
        <button class="page-link" onclick="cargarUsuarios(${i})">${i}</button>
      </li>
    `;
  }

  html += `
      </ul>
    </nav>
  `;

  document.getElementById("contenedor").innerHTML = html;

  const campoBuscar = document.getElementById("campoBuscar");
  if (campoBuscar) {
    campoBuscar.addEventListener("keydown", function (e) {
      if (e.key === "Enter") {
        buscarActual = campoBuscar.value;
        cargarUsuarios(1);
      }
    });
  }

  const selectOrden = document.getElementById("selectOrden");
  if (selectOrden) {
    selectOrden.addEventListener("change", () => {
      ordenActual = selectOrden.value;
      cargarUsuarios(1);
    });
  }
}

function editarUsuario(id, correo, rol) {
  document.getElementById("editarCorreo").value = correo;
  document.getElementById("editarRol").value = rol;
  document.getElementById("editarPassword").value = "";
  document.getElementById("editarId").value = id;

  const modal = new bootstrap.Modal(
    document.getElementById("modalEditarUsuario")
  );
  modal.show();
}

function eliminarUsuario(id) {
  fetch(`deleteusers.php?id=${id}`)
    .then((res) => res.text())
    .then(() => {
      alert("Usuario eliminado correctamente.");
      cargarUsuarios();
    });
}

// Configuración del dropdown de roles
document.addEventListener("DOMContentLoaded", () => {
  const opcionesRol = document.querySelectorAll(".rol-opcion");

  opcionesRol.forEach((opcion) => {
    opcion.addEventListener("click", function () {
      const nuevoRol = this.getAttribute("data-valor");
      const boton = document.getElementById("dropdownRolBtn");
      const inputRol = document.getElementById("editarRol");

      boton.textContent = this.textContent;
      inputRol.value = nuevoRol;
    });
  });
});

// Form de editar usuario
const formEditar = document.getElementById("formEditarUsuario");
if (formEditar) {
  formEditar.addEventListener("submit", function (e) {
    e.preventDefault();

    const datos = new FormData(formEditar);
    const password = datos.get("password");

    if (password !== "") {
      datos.set("password", sha1(password));
    }

    fetch("updateusers.php", {
      method: "POST",
      body: datos,
    })
      .then((res) => res.json())
      .then((json) => {
        alert(json.message);
        const modal = bootstrap.Modal.getInstance(
          document.getElementById("modalEditarUsuario")
        );
        modal.hide();
        cargarUsuarios();
      });
  });
}

//CRUD RESERVAS adm

function cargarReservas() {
  fetch("readreservas.php")
    .then((res) => res.json())
    .then((data) => mostrarReservas(data));
}

function mostrarReservas(datos) {
  const reservas = datos.data;

  let html = `
    <h4 class="mb-3">Listado de Reservas</h4>
    <table class="table table-bordered text-center align-middle">
      <thead class="table-dark">
        <tr>
          <th>Nro de reserva</th>
          <th>Usuario</th>
          <th>Nro deHabitacion</th>
          <th>Tipo de Habitacion</th>
          <th>Fecha de ingreso</th>
          <th>Fecha de Salida</th>
          <th>Estado</th>
        </tr>
      </thead>
      <tbody>
  `;

  for (let i = 0; i < reservas.length; i++) {
    const reserva = reservas[i];
    html += `
      <tr>
        <td>${reserva.reserva_id}</td>
        <td>${reserva.usuario_correo}</td>
        <td>${reserva.numero_habitacion}</td>
        <td>${reserva.tipo_habitacion}</td>
        <td>${reserva.fecha_ingreso}</td>
        <td>${reserva.fecha_salida}</td>
        <td>${reserva.estado}</td>

      </tr>
    `;
  }

  html += `
      </tbody>
    </table>
  `;

  document.getElementById("contenedor").innerHTML = html;
}

// Formulario crear reserva
const formCrearReserva = document.getElementById("formCrearReserva");
const respuestaReserva = document.getElementById("respuestaReserva");

if (formCrearReserva) {
  formCrearReserva.addEventListener("submit", async (e) => {
    e.preventDefault();
    const datos = new FormData(formCrearReserva);

    const res = await fetch("createreservas.php", {
      method: "POST",
      body: datos,
    });

    const json = await res.json();

    respuestaReserva.innerHTML = json.mensaje;

    if (json.status === "success") {
      setTimeout(() => {
        bootstrap.Modal.getInstance(
          document.getElementById("modalCrearReserva")
        ).hide();
        cargarReservas();
        formCrearReserva.reset();
        respuestaReserva.innerHTML = "";
      }, 2000);
    }
  });
}

//reservas user

document.addEventListener("DOMContentLoaded", () => {
  fetch("misreservas.php")
    .then((res) => res.json())
    .then((json) => {
      if (json.status === "ok") {
        mostrarReservasUser(json.data);
      }
    });

  const formEditar = document.getElementById("formEditarReserva");
  formEditar.addEventListener("submit", async (e) => {
    e.preventDefault();
    const datos = new FormData(formEditar);

    const res = await fetch("updatereservas.php", {
      method: "POST",
      body: datos,
    });
    const json = await res.json();

    if (json.status === "ok") {
      bootstrap.Modal.getInstance(
        document.getElementById("modalEditarReserva")
      ).hide();
      location.reload();
    } else {
      document.getElementById("errorEditarReserva").textContent = json.mensaje;
    }
  });
});

function mostrarReservasUser(reservas) {
  const contenedor = document.getElementById("tablaReservas");
  let html = `
    <table class="table table-bordered text-center align-middle">
      <thead class="table-dark">
        <tr>
          <th>Habitación</th>
          <th>Tipo</th>
          <th>Ingreso</th>
          <th>Salida</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead><tbody>`;

  reservas.forEach((reserva) => {
    html += `
      <tr>
        <td>${reserva.numero_habitacion}</td>
        <td>${reserva.tipo_habitacion}</td>
        <td>${reserva.fecha_ingreso}</td>
        <td>${reserva.fecha_salida}</td>
        <td>${reserva.estado}</td>
        <td>
          <button class="btn btn-sm btn-primary" onclick="editarReserva(${reserva.reserva_id}, '${reserva.fecha_ingreso}', '${reserva.fecha_salida}')">Editar</button>
          <button class="btn btn-sm btn-danger" onclick="eliminarReserva(${reserva.reserva_id})">Eliminar</button>
        </td>
      </tr>`;
  });

  html += "</tbody></table>";
  contenedor.innerHTML = html;
}

function editarReserva(id, ingreso, salida) {
  document.getElementById("editarReservaId").value = id;
  document.getElementById("editarFechaIngreso").value = ingreso;
  document.getElementById("editarFechaSalida").value = salida;
  document.getElementById("errorEditarReserva").textContent = "";
  new bootstrap.Modal(document.getElementById("modalEditarReserva")).show();
}

function eliminarReserva(id) {
  if (confirm("Desea eliminar su reserva?")) {
    fetch(`deletereservas.php?id=${id}`)
      .then((res) => res.json())
      .then((json) => {
        if (json.status === "ok") {
          location.reload();
        } else {
          alert(json.mensaje);
        }
      });
  }
}

//CRUD HABITACIONES

function cargarHabitaciones() {
  fetch("read_habitaciones.php")
    .then((res) => res.json())
    .then((json) => mostrarHabitaciones(json.data));
}

function mostrarHabitaciones(habitaciones) {
  let html = `
    <h4 class="mb-3">Listado de Habitaciones</h4>
    <table class="table table-bordered text-center align-middle">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Número</th>
          <th>Piso</th>
          <th>Tipo</th>
          <th>Acciones</th>

        </tr>
      </thead>
      <tbody>
  `;

  for (const habitacion of habitaciones) {
    html += `
      <tr>
        <td>${habitacion.id}</td>
        <td>${habitacion.numero}</td>
        <td>${habitacion.piso}</td>
        <td>${habitacion.tipo}</td>
        <td>
          <button class="btn btn-sm btn-danger" onclick="eliminarHabitacion(${habitacion.id})">Eliminar</button>
        
          <button class="btn btn-sm btn-info" onclick="verFotos(${habitacion.id})">Ver Fotos</button>
        </td>
      </tr>
    `;
  }

  html += `
      </tbody>
    </table>
  `;

  document.getElementById("tablaHabitaciones").innerHTML = html;
}

function editarHabitacion(id) {
  fetch(`updatehabitacion.php?id=${id}`)
    .then((res) => res.json())
    .then((data) => {
      const habitacion = data;

      document.getElementById("editarId").value = habitacion.id;
      document.getElementById("editarNumero").value = habitacion.numero;
      document.getElementById("editarPiso").value = habitacion.piso;
      document.getElementById("editarTipo").value =habitacion.tipo_habitacion_id;
      
      const div = document.getElementById("contenedorFotosActuales");
      div.innerHTML = ""; 

      habitacion.fotos.forEach((foto) => {
        div.innerHTML += `
    <div class="position-relative">
      <img src="${foto.fotografia}" alt="foto" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
      
    </div>
  `;
      });

      const modal = new bootstrap.Modal(
        document.getElementById("modalEditarHabitacion")
      );
      modal.show();
    });
}

function eliminarHabitacion(id) {
  if (confirm("¿Estás seguro de eliminar esta habitación?")) {
    fetch(`deletehabitaciones.php?id=${id}`)
      .then((res) => res.text())
      .then((mensaje) => {
        alert(mensaje);
        cargarHabitaciones();
      });
  }
}

function verFotos(habitacionId) {
  fetch(`read_fotos.php?habitacion_id=${habitacionId}`)
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "ok") {
        let html = `<h5>Fotos de la habitación ${habitacionId}</h5><div class="d-flex flex-wrap gap-2">`;
        for (let foto of data.fotos) {
          html += `<img src="${foto}" class="img-thumbnail" style="width: 150px;">`;
        }
        html += `</div>`;
        document.getElementById("contenedorFotos").innerHTML = html;
      } else {
        alert("Error: " + data.mensaje);
      }
    });
}
function eliminarFoto(habitacionId) {
  if (confirm("¿Estás seguro de eliminar la foto de esta habitación?")) {
    fetch(`eliminar_fotografia.php?habitacion_id=${habitacionId}`)
      .then((res) => res.json())
      .then((mensaje) => {
        alert(mensaje);
        cargarHabitaciones();
      });
  }
}





document.addEventListener('DOMContentLoaded', () => {
  const btnFotografias = document.getElementById('btnFotografias');
  const contenedor = document.getElementById('contenedor');

  btnFotografias.addEventListener('click', () => {
    fetch('subir_fotografia.php')
      .then(response => response.text())
      .then(html => {
        contenedor.innerHTML = html;
      })
      .catch(error => {
        contenedor.innerHTML = '<div class="alert alert-danger">Error al cargar fotografías</div>';
        console.error(error);
      });
  });
});









//--------
function cargarContenido(abrir) {
    var contenedor;
    contenedor = document.getElementById("contenido");
    fetch(abrir)
        .then((response) => response.text())
        .then((data) => (contenedor.innerHTML = data));
}

function cargarImagen(value) {
    var url = `readHabitacion.php?tipo=${value}`;
    var contenedor = document.getElementById("contenido");
    fetch(url)
        .then((response) => response.text())
        .then((data) => (contenedor.innerHTML = data));
}





// Abre el modal de reserva y gestiona el cambio de botón tras reserva exitosa
function abrirModalReserva(id_habitacion, btn) {
    var modal = document.getElementById("myModal");
    var contenidoModal = document.getElementById("contenido-modal");
    // Cargar el formulario de reserva por AJAX
    fetch(`formReserva.php?id_habitacion=${id_habitacion}`)
        .then(response => {
            if (!response.ok) throw new Error("No se pudo cargar el formulario");
            return response.text();
        })
        .then(data => {
            contenidoModal.innerHTML = data;
            modal.style.display = "block";
            // Esperar a que el formulario esté en el DOM
            var form = contenidoModal.querySelector('form');
            if (form) {
                form.onsubmit = function(e) {
                    e.preventDefault();
                    var formData = new FormData(form);
                    fetch('formReserva.php?id_habitacion=' + id_habitacion, {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.text())
                    .then(respuesta => {
                        // Puedes mejorar esto validando la respuesta del backend
                        if (respuesta.includes('Reservada') || respuesta.toLowerCase().includes('éxito')) {
                            modal.style.display = "none";
                            btn.textContent = "Reservado";
                            btn.classList.add("reservado");
                            btn.disabled = true;
                        } else {
                            // Mostrar mensaje de error en el modal
                            contenidoModal.innerHTML = respuesta;
                        }
                    })
                    .catch(err => {
                        contenidoModal.innerHTML = '<p style="color:red;">Error al procesar la reserva.</p>';
                    });
                }
            }
        })
        .catch(err => {
            contenidoModal.innerHTML = '<p style="color:red;">Error al cargar el formulario.</p>';
            modal.style.display = "block";
        });
}

// Cerrar el modal al hacer clic en la X
document.addEventListener("DOMContentLoaded", function() {
    var closeBtn = document.getElementById("closeModal");
    var modal = document.getElementById("myModal");
    if (closeBtn) {
        closeBtn.onclick = function() {
            modal.style.display = "none";
        }
    }
    // Cerrar el modal al hacer clic fuera del contenido
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});

function moverCarrusel(id, dir) {
    var carrusel = document.getElementById('carrusel-' + id);
    var imgs = carrusel.querySelectorAll('.carrusel-img');
    var idx = 0;
    imgs.forEach(function(img, i) { if (img.classList.contains('active')) idx = i; });
    imgs[idx].classList.remove('active');
    imgs[idx].style.display = 'none';
    var next = (idx + dir + imgs.length) % imgs.length;
    imgs[next].classList.add('active');
    imgs[next].style.display = 'block';
}