const express = require("express");
var fs = require('fs');
const app = express();
// const server = require("https").Server(app);
var server  =require('https').createServer({
  cert : fs.readFileSync('zamzamgames_com_b53d4_08891_1633651199_b532edd7423cdafff1cb42aa3f521884.crt'),
  key: fs.readFileSync('b53d4_08891_98474478a9f173002266828774b4b374.key'),
  ca : fs.readFileSync('zamzamgames_com_d341a_d82df_1657379959_5f80f5950faefcfcb793b7512997e0eb.crt'),
  requestCert: false,
  rejectUnauthorized: false,
}, app);







const { v4: uuidv4 } = require("uuid");
app.set("view engine", "ejs");
const io = require("socket.io")(server, {
  cors: {
    origin: '*'
  }
});
const { ExpressPeerServer } = require("peer");
const peerServer = ExpressPeerServer(server, {
  debug: true,
});

app.use("/peerjs", peerServer);
app.use(express.static("public"));

app.get("/", (req, res) => {
  res.redirect(`/${uuidv4()}`);
});

app.get("/:room", (req, res) => {
  res.render("room", { roomId: req.params.room });
});

io.on("connection", (socket) => {console.log(1);
  socket.on("join-room", (roomId, userId, userName) => {console.log(2);
    socket.join(roomId);
    socket.to(roomId).broadcast.emit("user-connected", userId);
    socket.on("message", (message) => {console.log(3);
         console.log(roomId, userId, userName,);
      io.to(roomId).emit("createMessage", message, userName);
    });
      console.log(roomId, userId, userName,);
  });
});

server.listen(process.env.PORT || 3000);
