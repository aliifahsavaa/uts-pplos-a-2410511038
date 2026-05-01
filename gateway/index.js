const express = require('express');
const proxy = require('express-http-proxy');
const rateLimit = require('express-rate-limit');
const jwt = require('jsonwebtoken');
require('dotenv').config();

const app = express();

app.use(express.json());
app.use(express.urlencoded({ extended: true }));

const limiter = rateLimit({
    windowMs: 1 * 60 * 1000,
    max: 60,
    message: { message: "Terlalu Banyak Permintaan, Coba Lagi Nanti." }
});
app.use(limiter);

const verifyJWT = (req, res, next) => {
    const authHeader = req.headers['authorization'];
    if (!authHeader) return res.status(401).json({ message: 'Unauthorized: Token Tidak Ditemukan.' });

    const token = authHeader.split(' ')[1];
    try {
        const decoded = jwt.verify(token, process.env.JWT_SECRET);
        req.user = decoded;
        next();
    } catch (err) {
        return res.status(403).json({ message: 'Forbidden: Token Tidak Valid.' });
    }
};

app.use('/api/auth', proxy('http://localhost:3001', {
    proxyReqPathResolver: (req) => {
        const parts = req.url.split('?');
        const queryString = parts[1] ? '?' + parts[1] : '';
        const path = parts[0];
        return path.startsWith('/') ? path + queryString : '/' + path + queryString;
    }
}));

app.use('/api/kos', verifyJWT, proxy('http://localhost:8000', {
    proxyReqPathResolver: (req) => `/api${req.url}`
}));

app.use('/api/payments', verifyJWT, proxy('http://localhost:3002'));

const PORT = 3000;
app.listen(PORT, () => {
    console.log(`Gateway Berjalan di Port ${PORT}`);
});