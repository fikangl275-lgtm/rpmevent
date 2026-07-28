<!DOCTYPE html>
<html>
<head>

<title>Register RPM Management</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI';
}

body{
    background:#0f172a;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}

.register-box{
    width:450px;
    background:white;
    padding:40px;
    border-radius:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
}

.title{
    text-align:center;
    margin-bottom:30px;
}

.title h1{
    color:#2563eb;
}

.input-group{
    margin-bottom:20px;
}

.input-group label{
    display:block;
    margin-bottom:8px;
    color:#334155;
}

.input-group input{
    width:100%;
    padding:14px;
    border:1px solid #cbd5e1;
    border-radius:12px;
    outline:none;
}

button{
    width:100%;
    padding:14px;
    border:none;
    background:#2563eb;
    color:white;
    border-radius:12px;
    cursor:pointer;
    font-size:16px;
    font-weight:bold;
}

button:hover{
    background:#1d4ed8;
}

</style>

</head>
<body>

<div class="register-box">

    <div class="title">
        <h1>REGISTER</h1>
        <p>Buat akun klien</p>
    </div>

    <form action="proses_register.php" method="POST">

        <div class="input-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama">
        </div>

        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email">
        </div>

        <div class="input-group">
            <label>No HP</label>
            <input type="text" name="no_hp">
        </div>

        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username">
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password">
        </div>

        <button type="submit">
            REGISTER
        </button>

    </form>

</div>

</body>
</html>