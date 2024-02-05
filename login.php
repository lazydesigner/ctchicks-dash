<?php include './routes.php';
include './connection.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.min.css" async /> -->
    <title>CTChicks - Dashboard</title>
    <link rel="stylesheet" href="<?= get_url() ?>assets/css/index.css">


</head>

<body>

    <div class="container">
        <div class="menu-pannel">
            <?php include './navbar.php'; ?>
        </div>
        <div class="action-pannel">
            <div class="action-center">

                <div class="login-body">
                    <div class="colors"></div>
                    <div class="colors"></div>
                    <div class="colors"></div>
                    <div class="colors"></div>
                </div>
                <div class="login-form">
                   <div>
                   <h1>Login</h1>
                    <form action="" method="post">
                        <div><input type="email" name="admin_e" id="admin_e" placeholder="Email....."></div>
                        <div><input type="password" name="admin_p" id="admin_p" placeholder="Password....."></div>
                        <div><button name='login' >Login</button></div>
                    </form>
                   </div>
                </div>

                <button class="login-bn" id="login-bn">Login</button>

            </div>
        </div>
    </div>

    <script>
        document.getElementById('login-bn').addEventListener('click',(e)=>{
            var tog = document.querySelectorAll('.colors')
            var log = document.querySelector('.login-form')
            for(i=0;i<tog.length;i++){
                tog[i].classList.toggle('activate-the-animation')
            }
            text = e.target.innerText;
            log.classList.toggle('login-form-2')
            if(text == 'Login'){
                e.target.innerText = 'X'
            }else{e.target.innerText= 'Login'}

            e.target.classList.toggle('login-btn-click')
        })
    </script>

    
</body>

</html>

<?php

if(isset($_POST['login'])){
    $eml=$_POST['admin_e'];
    $pass = md5($_POST['admin_p']);
    if(empty($eml) || empty($pass)){
        ?><script>alert('Both Fiels Are Required')</script><?php
    }else{
        $admin = "SELECT * FROM user_auth WHERE email = '$eml' AND password = '$pass'";
        $res = mysqli_query($con,$admin);
        $row = mysqli_fetch_assoc($res);
        if(mysqli_num_rows($res)>0){         
            $_SESSION["email"] = "$eml";
            $_SESSION["user_name"] = $row['admin_name'];
            header('Location: '. get_url().'');

        }else{?><script>alert('Failed To Logged In')</script><?php }
    }


}

// pass = b4dc27c0f8065b1252a063df4800cc2e;
?>
