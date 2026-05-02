const express = require('express');
const mysql = require('mysql2/promise');
const axios = require('axios');
const authMiddleware = require('./middleware');
const app = express();
app.use(express.json());
require('dotenv').config();

const db = mysql.createPool({
    host: process.env.DB_HOST,
    port: process.env.DB_PORT,
    user: process.env.DB_USER,
    password: process.env.DB_PASS, 
    database: 'payment_db',
});

app.post('/api/payments', authMiddleware, async (req, res) => {
    try {
        const { booking_id, jumlah, metode_pembayaran } = req.body;

        const booking = await axios.get(`http://localhost:8000/api/booking/${booking_id}`, {
            headers: { Authorization: req.headers['authorization'] }
        });

        if (!booking.data) {
            return res.status(404).json({ message: 'Booking Tidak Ditemukan.' });
        }

        await db.query(
            'INSERT INTO pembayaran (booking_id, jumlah, tanggal_pembayaran, status, metode_pembayaran) VALUES (?, ?, NOW(), "lunas", ?)',
            [booking_id, jumlah, metode_pembayaran]
        );
        res.status(201).json({ message: 'Pembayaran Berhasil Dicatat.' });
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

app.get('/api/payments', authMiddleware, async (req, res) => {
    try {
        const [rows] = await db.query('SELECT * FROM pembayaran');
        res.status(200).json(rows);
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

app.listen(3003, () => console.log('Payment Service Berjalan di Port 3003'));