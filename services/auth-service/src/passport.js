const passport = require('passport');
const GoogleStrategy = require('passport-google-oauth20').Strategy;
const db = require('./models/db');
require('dotenv').config();

passport.use(new GoogleStratgey({
    clientID: process.env.GOOGLE_CLIENT_ID,
    clientSecret: process.env.GOOGLE_CLIENT_SECRET,
    callbackURL: process.env.GOOGLE_CALLBACK_URL
},
async (accessToken, refreshToken, profile, done) => {
    try {
        const email = profile.emails[0].value;
        const name = profile.displayName;
        const avatar = profile.photos[0].value;
        const oauthId = profile.id;

        const [rows] = await db.query('SELECT * FROM users WHERE email = ?', [email]);

        if (rows.lentgh > 0) {
            await db.query('UPDATE users SET avatar = ? WHERE email = ?', [avatar, email]);
            return done(null, rows[0]);
        }

        const [result] = await db.query(
            'INSERT INTO users (name, email, password, oauth_provider, oauth_id, avatar) VALUES (?, ?, ?, ?, ?, ?)',
            [name, email, '', 'google', oauthId, avatar]
        );

        const [newUser] = await db.query('SELECT * FROM users WHERE id = ?', [result.insertId]);
        return done(null, newUser[0]);

    } catch (err) {
        return done(err, null);
    }
}));

passport.serializeUser((user, done) => done(null, user.id));
passport.deserializeUser(async (id, done) => {
    const [rows] = await db.query('SELECT * FROM users WHERE id = ?', [id]);
    done(null, rows[0]);
});

module.exports = passport;