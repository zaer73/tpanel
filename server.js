var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var Redis = require('ioredis');
var redis = new Redis();
 
server.listen(8890, function(){
  console.log('listening');
});
redis.subscribe('notification');
redis.subscribe('received');

io.on('connection', function(socket){
  // console.log('connection');
  socket.on('join', function(data){
    // console.log(data);
  });
});

redis.on('message', function(channel, message){
  var data = JSON.parse(message);
  	io.emit(channel + '_' + data.user_id, data);
});


 
