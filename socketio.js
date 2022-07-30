const redis = require("redis");
const httpServer = require("http").createServer();
const io = require("socket.io")(httpServer, {
    cors: {
        origin: "*",
    },
});

io.on("connection", async (socket) => {
    console.log("new client connected");

    const redisClient = redis.createClient({
        host: "127.0.0.1",
        port: 6379,
    });

    redisClient.on("error", (err) => console.log("Redis Client Error", err));

    await redisClient.connect();

    await redisClient.pSubscribe("*", (message, channel) => {
        console.log(message, channel);
        socket.emit(channel, message);
    });

    socket.on("disconnect", function () {
        redisClient.quit();
    });
});

httpServer.listen(8890, function () {
    console.log("connected");
});
