const express = require('express');
const router = express.Router();
const authController = require('../controllers/authController');
const passport = require('../passport');
const jwt = require('jsonwebtoken');
const authMiddleware = require('../middleware/authMiddleware');

router.post('/register', authController.register);
router.post('/login', authController.login);
router.post('/refresh', authController.refresh);
router.post('/logout', authController.logout);

router.get('/google', passport.authenticate('google', {
    scope: ['profile', 'email']
}));

router.get('/google/callback',
    passport.authenticate('google', { failureRedirect: '/api/auth/login-failed' }),
    (req, res) => {
        const user = req.user;
        const accessToken = jwt.sign(
            { id: user.id, email: user.email },
            process.env.JWT_SECRET,
            { expiresIn: '15m' }
        );

        const refreshToken = jwt.sign(
            { id: user.id, email: user.email },
            process.env.JWT_REFRESH_SECRET,
            { expiresIn: '7d' }
        );

        res.json({ accessToken, refreshToken, user: {
            name: user.name,
            email: user.email,
            avatar: user.avatar
        }});
    }
);

router.get('/login-failed', (req, res) => {
    res.status(401).json({ message: 'Login Google Gagal.' });
});

router.post('/profile', authMiddleware, async (req, res) => {
    try {
        const db = require('../models/db');
        const [rows] = await db.query('SELECT id, name, email, avatar, oauth_provider FROM users WHERE id = ?', [req.user.id]);
        if (rows.length === 0) return res.status(404).json({ message: 'User Tidak Ditemukan.' });
        res.json(rows[0]);
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

module.exports = router;