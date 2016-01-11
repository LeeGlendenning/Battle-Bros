
var util = require("util"),					// Utility resources (logging, object inspection, etc)
	io = require("socket.io");				// Socket.IO


var socket,		// Socket controller
	players;	// Array of connected players
var dead;//array of dead players

function init() {
	// Create an empty array to store players
	players = [];
	dead = [];
	// Set up Socket.IO to listen on port 8000
	socket = io.listen(8000);

	// Configure Socket.IO
	socket.configure(function() {
		// Only use WebSockets
		socket.set("transports", ["websocket"]);

		// Restrict log output
		socket.set("log level", 2);
	});

	// Start listening for events
	setEventHandlers();
};


var setEventHandlers = function() {
	// Socket.IO
	socket.sockets.on("connection", onSocketConnection);
};

// New socket connection
function onSocketConnection(client) {
	util.log("New player has connected: "+client.id);

	// Listen for client disconnected
	client.on("disconnect", onClientDisconnect);

	// Listen for new player message
	client.on("new player", onNewPlayer);

	// Listen for update player message
	client.on("update player", onUpdatePlayer);
	
	client.on("player dead", onPlayerDeath);
};

function onPlayerDeath(){
	console.log("player dead: "+this.id);
	dead.push(this.id);
	setTimeout(function() { respawn(); }, 5000);
	this.broadcast.emit("display death", {id: this.id});
	this.emit("display death", {id: this.id});
}

function respawn(){
	dead.splice(0,1);//revive player dead for longest
}

// Socket client has disconnected
function onClientDisconnect() {
	util.log("Player has disconnected: "+this.id);

	var removePlayer = playerById(this.id);

	// Player not found
	if (!removePlayer) {
		//util.log("Player not found: "+this.id);
		return;
	};

	// Remove player from players array
	players.splice(players.indexOf(removePlayer), 1);

	// Broadcast removed player to connected socket clients
	this.broadcast.emit("remove player", {id: this.id});
};

// New player has joined
function onNewPlayer(data) {
	console.log("new player joined");
	console.log(data.user);
	data.id = this.id;
	// Add new player to the players array
	players[players.length] = data;
	
	// Broadcast new player to connected socket clients
	this.broadcast.emit("new player", players[players.length-1]);

	// Send existing players to the new player
	var i, existingPlayer;
	for (i = 0; i < players.length-1; i++) {
		//existingPlayer = players[i];
		this.emit("new player", players[i]);
		//console.log("just sent " + players[i].id);
	};
};

// Player has moved
function onUpdatePlayer(data) {
	//if player isn't dead
	if (dead.indexOf(this.id) == -1){
		var movePlayer = playerById(this.id);

		// Player not found
		if (!movePlayer) {
			//util.log("Player not found: "+this.id);
			return;
		};
		movePlayer = data;
		movePlayer.id = this.id;
		// Broadcast updated position to connected socket clients
		this.broadcast.emit("update player", movePlayer);
	}
};


// Find player by ID
function playerById(id) {
	var i;
	for (i = 0; i < players.length; i++) {
		if (players[i].id == id)
			return players[i];
	};
	
	return false;
};

init();