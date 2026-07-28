<!DOCTYPE html>
<html>
<head>

<title>Login RPM Management</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI';
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#0f172a,#2563eb);
}

.login-box{
    width:420px;
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(10px);
    padding:40px;
    border-radius:25px;
    box-shadow:0 8px 25px rgba(0,0,0,0.3);
    border:1px solid rgba(255,255,255,0.2);
}

.title{
    text-align:center;
    color:white;
    margin-bottom:35px;
}

.title h1{
    font-size:35px;
}

.title p{
    color:#cbd5e1;
    margin-top:8px;
}

.input-group{
    margin-bottom:20px;
}

.input-group label{
    color:white;
    display:block;
    margin-bottom:8px;
}

.input-group input{
    width:100%;
    padding:15px;
    border:none;
    border-radius:12px;
    outline:none;
    background:rgba(255,255,255,0.2);
    color:white;
}

.input-group input::placeholder{
    color:#e2e8f0;
}

button{
    width:100%;
    padding:15px;
    border:none;
    border-radius:12px;
    background:white;
    color:#2563eb;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    transform:scale(1.03);
}

.register{
    text-align:center;
    margin-top:25px;
}

.register a{
    color:white;
    text-decoration:none;
}

</style>

</head>
<body>

<div class="login-box">

    <div class="title">
        <h1>RPM</h1>
        <p>Management Event Organizer</p>
    </div>

    <form action="proses_login.php" method="POST">

        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan username">
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password">
        </div>

        <button type="submit">
            LOGIN
        </button>

    </form>

    <div class="register">
        <a href="register.php">Belum punya akun?</a>
    </div>

</div>

</body>
</html>