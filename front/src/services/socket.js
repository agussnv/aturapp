import { io } from 'socket.io-client';  

const socket = io('http://aturapp.daw.inspedralbes.cat:27105', {
    reconnection: true,
    reconnectionAttempts: 10,
    reconnectionDelay: 1000,
    reconnectionDelayMax: 5000,
    randomizationFactor: 0.5
});

socket.on('test', (data) => {
    console.log(data);
});

export default socket;