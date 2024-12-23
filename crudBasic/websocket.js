const socket = new WebSocket(`ws://127.0.0.1:8080`);
let sender_id;
if(window.location.search !== ""){
    sender_id = window.location.search.split("sender_id")[1].substring(1);
}

console.log(sender_id);
// Connection opened
socket.onopen = () => {
    console.log("Connection established");
    socket.send(JSON.stringify({
        type : "establish_notifications",
        sender_id : sender_id,
    }));
    console.log('WebSocket connection established for sender_id:', sender_id);
};

// Handle errors
socket.onerror = (error) => {
    console.log('WebSocket error:', error);
};

// Handle connection close
socket.onclose = () => {
    console.log('Connection closed');
};

export default socket;