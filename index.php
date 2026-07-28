<!DOCTYPE html>
<html>
<head>

<title>RPM Management</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI';
}

body{
    background:#f8fafc;
}

.navbar{
    width:100%;
    padding:20px 80px;
    background:#0f172a;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.logo{
    color:white;
    font-size:28px;
    font-weight:bold;
}

.menu a{
    color:white;
    text-decoration:none;
    margin-left:30px;
    transition:0.3s;
}

.menu a:hover{
    color:#60a5fa;
}

.hero{
    height:90vh;
    background:linear-gradient(rgba(15,23,42,0.7),rgba(15,23,42,0.7)),
    url('https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=1470&auto=format&fit=crop');
    background-size:cover;
    background-position:center;
    display:flex;
    justify-content:center;
    align-items:center;
    text-align:center;
    color:white;
    padding:20px;
}

.hero-content h1{
    font-size:60px;
    margin-bottom:20px;
}

.hero-content p{
    font-size:20px;
    max-width:700px;
    margin:auto;
    line-height:1.8;
}

.hero-content a{
    display:inline-block;
    margin-top:30px;
    padding:15px 30px;
    background:#2563eb;
    color:white;
    text-decoration:none;
    border-radius:12px;
    font-weight:bold;
    transition:0.3s;
}

.hero-content a:hover{
    background:#1d4ed8;
}

.section{
    padding:80px;
}

.section-title{
    text-align:center;
    margin-bottom:50px;
}

.section-title h2{
    font-size:40px;
    color:#0f172a;
}

.card-area{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:25px;
}

.card{
    background:white;
    padding:35px;
    border-radius:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    text-align:center;
    transition:0.3s;
}

.card:hover{
    transform:translateY(-8px);
}

.card h3{
    margin-bottom:20px;
    color:#0f172a;
}

.card p{
    color:#64748b;
    line-height:1.8;
}

.footer{
    background:#0f172a;
    color:white;
    text-align:center;
    padding:30px;
}

</style>

</head>
<body>

<div class="navbar">

    <div class="logo">
        RPM MANAGEMENT
    </div>

    <div class="menu">

        <a href="index.php">Home</a>

        <a href="auth/login.php">Login</a>

        <a href="auth/register.php">Register</a>

    </div>

</div>

<div class="hero">

    <div class="hero-content">

        <h1>Event Organizer Professional</h1>

        <p>
            RPM Management membantu anda mengelola acara dengan
            layanan event organizer profesional, modern, dan terpercaya.
        </p>

        <a href="auth/register.php">
            Pesan Event Sekarang
        </a>

    </div>

</div>

<div class="section">

    <div class="section-title">
        <h2>Layanan Kami</h2>
    </div>

    <div class="card-area">

        <div class="card">

            <h3>Wedding Organizer</h3>

            <p>
                Membantu acara pernikahan anda menjadi lebih elegan
                dan berkesan.
            </p>

        </div>

        <div class="card">

            <h3>Music Festival</h3>

            <p>
                Event musik modern dengan pengelolaan profesional
                dan tim terbaik.
            </p>

        </div>

        <div class="card">

            <h3>Corporate Event</h3>

            <p>
                Seminar, gathering, dan event perusahaan dengan
                konsep modern.
            </p>

        </div>

    </div>

</div>

<div class="footer">

    <p>
        © 2026 RPM Management - Event Organizer System
    </p>

</div>

</body>
</html>