import express from "express";
import bodyParser from "body-parser";
import cors from "cors";
import http from "http";
import { Server } from 'socket.io';
import * as dotenv from "dotenv";
dotenv.config();

const app = express();
const port = process.env.PORT || 3001;
app.use(cors())
// parse application/x-www-form-urlencoded
app.use(bodyParser.urlencoded({ extended: false }))

// parse application/json
app.use(bodyParser.json())
const server = http.createServer(app);
// const { Server } = require("socket.io");
// const fs = require('fs');
// const helper = require("./helper/helper");
import connectDB from "./database/database.js";
// router
// import { wallRouter } from "./routers/index.js";
app.use(cors());
// app.use(cors());
// app.use(cors());
const io = new Server(server, {
    cors: {
        origin: "http://localhost:8000",
    },
});

class ServerChat{   
    constructor(){
        this.connectServer();
        this.connectSocket();
        //this.routerApp();
              
    }
    // connect socket
    connectSocket(){
        io.on("connection", async (socket) => {
            //socket.join('room user');   
            console.log("connection established");   
            socket.on("join room", (data) => {
                socket.join('padlet'); 
            })

            socket.on("send data", (data) => {
                if (data) {
                    // io.in('padlet').emit("listen data", data);
                    socket.to('padlet').emit("listen data", data);
                }
            })

            socket.on("send update data", (data) => {
                if (data) {
                    socket.to('padlet').emit("listen update data", data);
                }
            })
            // Sự kiện disconnect - xảy ra khi kết nối bị ngắt
            socket.on("disconnect", () => {
                console.log("socket disconnected");
            });      
        });
    }
    // connect server
    connectServer(){
        server.listen(port, async () => {
            await new connectDB();
            console.log("listening on *:3000");
        });
    }
    //router

    // routerApp(){
    //     // app.set('views', path.join(__dirname, 'views'));
    //     // app.set('view engine', 'ejs');
    //     // app.use('/', indexRouter);
    //     // app.get('/', (req, res) => {
    //     //     res.send('Hello, world!, hahaha');
    //     // });
    //     // app.use('/wall', wallRouter);
    // }
}
new ServerChat();