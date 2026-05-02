const express = require('express');
const mysql = require('mysql2/promise');
const app = express();
app.use(express.json());
require('dotenv').config();

const db = mysql.createPool({
    host: process.env.DB_HOST,
    user: process.env.DB_USER,
    password: process.env.DB_PASS, 
    database: 'payment_db',
});

app.post('/api/payments', async (req, res) => {
    try {
        const { booking_id, jumlah, metode_pembayaran } = req.body;
        await db.query(
            'INSERT INTO pembayaran (booking_id, jumlah, tanggal_pembayaran, status, metode_pembayaran) VALUES (?, ?, NOW(), "lunas", ?)',
            [booking_id, jumlah, metode_pembayaran]
        );
        res.status(201).json({ message: 'Pembayaran Berhasil Dicatat.' });
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

app.listen(3002, () => console.log('Payment Service Berjalan di Port 3002'));