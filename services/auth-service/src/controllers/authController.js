const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');
const db = require('../models/db');

const generateAccessToken = (user) => {
    return jwt.sign(user, process.env.JWT_SECRET, { expiresIn: '15m' });
};

const generateRefreshToken = (user) => {
    return jwt.sign(user, process.env.JWT_REFRESH_SECRET, { expiresIn: '7d' });
};

// Untuk Proses Registrasi
exports.register = async (req, res) => {
    try {
        const { name, email, password } = req.body;
        if (!name || !email || !password)
            return res.status(400).json({ message: 'Semua Field Wajib Diisi.'});

        const hash = await bcrypt.hash(password, 10);
        await db.query(
            'INSERT INTO users (name, email, password) VALUES (?, ?, ?)',
            [name, email, hash]
        );
        res.status(201).json({ message: 'Registrasi Berhasil!' });
    } catch (err) {
        res.status(500).json({ message: 'Server Error!', error: err.message });
    }
};

/// Untuk Proses Login
exports.login = async (req, res) => {
    try {
        const { email, password } = req.body;
        const [rows] = await db.query('SELECT * FROM users WHERE email = ?', [email]);
        if (rows.length === 0)
            return res.status(404).json({ message: 'User Tidak Ditemukan.' });

        const user = rows[0];
        const valid = await bcrypt.compare(password, user.password);
        if (!valid)
            return res.status(401).json({ message: 'Password Salah.' });

        const accessToken = generateAccessToken({ id: user.id, email: user.email });
        const refreshToken = generateRefreshToken({ id: user.id, email: user.email });

        await db.query('UPDATE users SET refresh_token = ? WHERE id = ?', [refreshToken, user.id]);

        res.json({ accessToken, refreshToken });
    } catch (err) {
        res.status(500).json({ message: 'Server Error.', error: err.message });
    }
};

// Refresh Token
exports.refresh = async (req, res) => {
    try {
        const { refreshToken } = req.body;
        if (!refreshToken)
            return res.status(401).json({ message: 'Token Diperlukan.' });

        const [rows] = await db.query('SELECT * FROM users WHERE refresh_token = ?', [refreshToken]);
        if (rows.length === 0)
            return res.status(403).json({ message: 'Token Tidak Valid.' });

        jwt.verify(refreshToken, process.env.JWT_REFRESH_SECRET, (err, user) => {
            if (err) return res.status(403).json({ message: 'Token Kadaluwarsa.' });
            const accessToken = generateAccessToken({ id: user.id, email: user.email });
            res.json({ accessToken });
        });
    } catch (err) {
        res.status(500).json({ message: 'Server Error', error: err.message });
    }
};

// Log Out
exports.logout = async (req, res) => {
    try {
        const { refreshToken } = req.body;
        await db.query('UPDATE users SET refresh_token = NULL WHERE refresh_token = ?', [refreshToken]);
        res.json({ message: 'Logout Berhasil.' });
    } catch (err) {
        res.status(500).json({ message: 'Server Error', error: err.message });
    }
};