const redis = require("redis");
require("dotenv").config();
const jwt = require("jsonwebtoken");
const httpServer = require("http").createServer();
const io = require("socket.io")(httpServer, {
    cors: {
        origin: "*",
    },
});

io.use((socket, next) => {
    const token = socket.handshake.auth.token;
    if (token) {
        jwt.verify(token, process.env.JWT_SECRET, function (err, decoded) {
            if (err) return next(new Error("Authentication error"));
            socket.auth = decoded;
            console.log(decoded);
            next();
        });
    } else {
        next(new Error("Authentication error"));
    }
});

io.on("connection", async (socket) => {
    console.log("new client connected");

    const redisClient = redis.createClient({
        host: "127.0.0.1",
        port: 6379,
    });

    redisClient.on("error", (err) => console.log("Redis Client Error", err));

    await redisClient.connect();

    await redisClient.pSubscribe(
        "private.chat." + socket.auth.id,
        (message, channel) => {
            socket.emit(channel, message);
        }
    );

    await redisClient.pSubscribe("public.*", (message, channel) => {
        socket.emit(channel, message);
    });

    socket.on("disconnect", function () {
        redisClient.quit();
    });
});

httpServer.listen(8890, function () {
    console.log("connected");
});
