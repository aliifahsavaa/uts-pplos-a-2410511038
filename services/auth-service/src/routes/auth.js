const express = require('express');
const router = express.Router();
const authController = require('../controllers/authController');
const passport = require('../passport');
const jwt = require('jsonwebtoken');

router.post('/register', authController.register);
router.post('/login', authController.login);
router.post('/refresh', authController.refresh);
router.post('/logout', authController.logout);

router.get('/google', passport.authenticate('google', {
    scope: ['profile', 'email']
}));

router.get('/google/callbacl',
    passport.authenticate('google', { failureRedirect: '/api/auth/login-failed' }),
    (req, res) => {
        const user = req.user;
        const accessToken = jwt.sign(
            { id: user.id, email: user.email },
            process.env.JWT_SECRET,
            { expiresIn: '15m' }
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

module.exports = router;