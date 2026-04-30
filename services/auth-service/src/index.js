const express = require('express');
const cors = require('cors');
const session = require('express-session');
const passport = require('./passport');
require('dotenv').config();

const app = express();
app.use(cors());
app.use(express.json());

app.use(session({
    secret: process.env.JWT_SECRET,
    resave: false,
    saveUnitialized: false
}));

app.use(passport.initialize());
app.use(passport.session());

const authRoutes = require('./routes/auth');
app.use('/api/auth', authRoutes);

const PORT = process.env.PORT || 3001;
app.listen(PORT, () => {
    console.log(`Auth Service Berjalan di Port ${PORT}`);
});