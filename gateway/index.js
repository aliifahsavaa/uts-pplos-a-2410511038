const express = require('express');
const proxy = require('express-http-proxy');
const rateLimit = require('express-rate-limit');
const jwt = require('jsonwebtoken');
require('dotenv').config();

const app = express();

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
        const decoded = jwt.verify(token, '052053cd9b08cce255944bac4849a1bdb6b5e98ba7439e5957c1d17c23bd25fc');
        req.user = decoded;
        next();
    } catch (err) {
        return res.status(403).json({ message: 'Forbidden: Token Tidak Valid.' });
    }
};

app.use('/api/auth', proxy('http://localhost:3001'));
app.use('/api/kos', verifyJWT, proxy('http://localhost:8000', {
    proxyReqPathResolver: (req) => `/api${req.url}`
}));

app.use('/api/payments', verifyJWT, proxy('http://localhost:3002'));

const PORT = 3000;
app.listen(PORT, () => {
    console.log(`Gateway Berjalan di Port ${PORT}`);
});