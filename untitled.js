var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var Redis = require('ioredis');
var redis = new Redis();
 
server.listen(8890, function(){
  console.log('listening');
});
redis.subscribe('notification');
redis.subscribe('message');
redis.subscribe('transaction');
redis.subscribe('project_filters');

io.on('connection', function(socket){
  // console.log('connection');
  socket.on('join', function(data){
    // console.log(data);
  });
});

redis.on('message', function(channel, message){
  var data = JSON.parse(message);
  if(channel == 'notification'){
  	io.emit('notification_' + data.user_id, data);
  }
  if(channel == 'message'){
  	io.emit('message_' + data.user_id, data);
  }
  if(channel == 'transaction'){
  	io.emit('transaction_' + data.user_id, data);
  }
  if(channel == 'project_filters'){
    io.emit('project_filters', data);
    console.log(data);
  }
});
//   console.log("new client connected");
//   var redisClient = redis.createClient();
//   redisClient.subscribe('notification');
 
//   redisClient.on("message", function(channel, message) {
//     console.log("mew message in queue "+ message + "channel");
//     socket.emit(channel, message);
//   });
 
//   socket.on('disconnect', function() {
//     redisClient.quit();
//   });

 