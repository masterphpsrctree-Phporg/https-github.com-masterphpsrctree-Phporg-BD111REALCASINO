const express = require('express');
const nodemailer = require('nodemailer');
const bodyParser = require('body-parser');
const session = require('express-session');
const twilio = require('twilio');

const app = express();
app.use(bodyParser.urlencoded({ extended: true }));
app.use(session({ secret: 'otpsecret', resave: false, saveUninitialized: true }));
app.set('view engine', 'ejs');

// Twilio setup
const client = twilio('TWILIO_SID', 'TWILIO_AUTH_TOKEN');

app.post('/send-otp', async (req, res) => {
  const { email, phone } = req.body;
  const otp = Math.floor(100000 + Math.random() * 900000);
  req.session.otp = otp;
  req.session.otp_expire = Date.now() + 5*60*1000;

  // Send Email
  const transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: { user: 'your_email@gmail.com', pass: 'your_email_password' }
  });

  const htmlBody = await ejs.renderFile(__dirname + '/views/otp_email.ejs', { otp });

  await transporter.sendMail({
    from: 'BD111 Casino <your_email@gmail.com>',
    to: email,
    subject: 'Your BD111 Casino OTP',
    html: htmlBody
  });

  // Send SMS
  await client.messages.create({
    body: `Your BD111 Casino OTP is: ${otp}`,
    from: '+1234567890', // Twilio number
    to: phone
  });

  res.send('OTP sent via Email & SMS');
});

app.post('/verify-otp', (req, res) => {
  const { otp } = req.body;
  if (!req.session.otp) return res.send('No OTP sent.');
  if (Date.now() > req.session.otp_expire) return res.send('OTP expired!');
  if (parseInt(otp) === req.session.otp) res.send('Phone verified!');
  else res.send('Invalid OTP.');
});

app.listen(3000, () => console.log('Server running on port 3000'));
