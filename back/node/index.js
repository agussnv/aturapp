const express = require('express');
const { createServer } = require('node:http');
const { Server } = require('socket.io');
const { join } = require('node:path');

const app = express();
const server = createServer(app);
const io = new Server(server, {
  cors: {
    // origin: 'http://localhost',
    origin: 'http://aturapp.daw.inspedralbes.cat',
    methods: ['GET', 'POST']
  }
});

app.use(express.json());
app.use(cors({
  origin: "http://aturapp.daw.inspedralbes.cat",
  methods: ["GET", "POST"],
  credentials: true,
}));


const alumnos = new Map();
const profesores = new Map();
const alumnosEsperando = new Map();

app.get('/', (req, res) => {
  res.send('Todo OK');
});


io.on('connection', (socket) => {
  // socket.emit('obtenerRol');
  socket.on('connexion', (data) => {

    if (data.rol == 1 && !alumnos.has(socket)) {
      alumnos.set(socket, { data, profesorAsignado: null });
    } else if (data.rol == 2 && !profesores.has(socket)) {
      profesores.set(socket, { data, alumnoAsignado: null });
      //si hay algun alumno esperando, salte noti
    }
    // if (alumnos.has(socket)) {
    //   console.log(`user-alumno: ${alumnos.get(socket).data.id} connectat`);
    // } else if (profesores.has(socket)) {
    //   console.log(`user-profesor: ${profesores.get(socket).data.id} connectat`);
    // }
    console.log('Alumnos:', Array.from(alumnos.values()));
    console.log('Profesores:', Array.from(profesores.values()));
  });
  socket.on('disconnect', () => {
    if (alumnos.has(socket)) {
      alumnos.delete(socket);
    } else if (profesores.has(socket)) {
      profesores.delete(socket);
    }
    // console.log('user disconnected');
    // console.log('Alumnos:', Array.from(alumnos.values()));
    // console.log('Profesores:', Array.from(profesores.values()));
  });
  socket.on('busquedaContacto', (data) => {
    let chatAceptado = false;

    alumnosEsperando.set(data, { socket, horaInicio: null, timer: null });
    profesores.forEach((value, profSocket) => {
      if (value.alumnoAsignado === null) {
        profSocket.emit('peticionChat', data);
      }
    });

    alumnosEsperando.get(data).horaInicio = new Date();
    alumnosEsperando.get(data).timer =
      setTimeout(() => {
        if (!chatAceptado) {
          socket.emit('sinRespuesta', {
            mensaje: 'No se encontró un profesor disponible. Se te contactará los mas pronto posible mediante mail, puedes seguir añadiendo informacion en el chat.',
          });
        }
      }, 1000);
      // }, 3 * 60 * 1000);
  });

  socket.on('chatAceptado', (data) => {
    // chatAceptado = true;
    // clearTimeout(alumnosEsperando.get(data).timer);
    // console.log(alumnosEsperando.get(data));
    // alumnosEsperando.delete(data);
    // console.log(profesores.get(socket));
    const alumneSocket = getAlumneSocketById(data.user.id);
    profesores.get(socket).alumnoAsignado = alumneSocket;
    alumnos.get(alumneSocket).profesorAsignado = socket;
    socket.emit('connexionChats');
  });

  socket.on('compartirChat', (data) => {
    alumnos.get(socket).profesorAsignado.emit('cargarChat', data);
  });

  socket.on('sendMessage', (msg) => {
    let socketAfiliado = null;
    if (alumnos.has(socket)) {
      socketAfiliado = alumnos.get(socket).profesorAsignado;
    } else if (profesores.has(socket)) {
      socketAfiliado = profesores.get(socket).alumnoAsignado;
    }
    socketAfiliado.emit('storeMessage', msg);
    console.log('message: ' + msg);
  });

  socket.on('test', () => {
    socket.emit('test', { alumnos: Array.from(alumnos.values()), profesores: Array.from(profesores.values()) });
  });
});

function getAlumneSocketById(alumneId) {
  for (const [socket, info] of alumnos.entries()) {
    if (info.data.id === alumneId) {
      return socket;
    }
  }
  return null;
}

server.listen(27105, () => {
  console.log('server running at http://localhost:27105');
});