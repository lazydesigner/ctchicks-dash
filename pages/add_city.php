<?php include '../routes.php';
include '../connection.php' ?>

<?php

$city_query = "SELECT * FROM city ";
// $city_query = "SELECT * FROM city INNER JOIN area on city.city_id = area.city_area_id";
$result = mysqli_query($con, $city_query);
$grid = '';
$option = '<option value="0">Select a city...</option>';

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $grid .= '<div class="city-list" value="' . strtolower($row['city_name']) . '" ><span class="city-list-delete" onclick="Deletethecity(\'city_name\',' . $row['city_id'] . ',0)">x</span><p>' . $row['city_name'] . '</p></div>';
        $option .= '<option value="' . strtolower($row['city_name']) . '">' . $row['city_name'] . '</option>';
    }
}
// AREA QUERY BELLOW

function show_area($con){
    $area_query = "SELECT * FROM area2";
$area_result = mysqli_query($con, $area_query);
$area_grid = '';
$AREA_NAME = '';
$CITY_NAME = '';
if (mysqli_num_rows($area_result) > 0) {
    while ($area_row = mysqli_fetch_array($area_result)) {
        $CITY_NAME = '<div class="city-list" value="' . strtolower($area_row['area_city_name']) . '" ><p style="text-transform: capitalize;">' . $area_row['area_city_name'] . '</p></div>';

        $convertjsontoarray = json_decode($area_row['area_name'], true);
        foreach ($convertjsontoarray as $key => $value) {
            $list_y = "'".implode(",",[$key, $value, $area_row['area_city_name']])."'";
            $AREA_NAME .= '<div class="city-list" value="' . strtolower($value) . '" ><span class="city-list-delete" onclick="Deletethecity(\'city_area\',' . $area_row['add_id'] . ', ' . $list_y . ')">x</span><p style="text-transform: capitalize;">' . $value . '</p></div>';
        }

        $area_grid .= '<div class="list_of_all_area_with_city">
                        <div class="city_dedicated_to_areas">' . $CITY_NAME . '</div>
                        <div class="areas_dedicated_to_city list-of-all-cities">' . $AREA_NAME . '</div>
                    </div>';

        $AREA_NAME = '';
    }
}
return $area_grid;
}

$area_grid = show_area($con);


mysqli_close($con);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.min.css" async />
    <title>CTChicks - Dashboard</title>
    <link rel="stylesheet" href="<?= get_url() ?>assets/css/index.css">
    <style>
        /* ADD CITY */
.action-center{padding: 0}
.add-city{
    width: 100%;
    height: auto;
    padding: 1%;
    border-radius: 5px;
    background-color: rgba(0, 0, 255, 0.104);
    /* backdrop-filter: blur(12px); */
    color: var(--links);
}
.add-city form{
    padding: 0 3%;
}
input{
    width: 100%;
    height: 50px;
    outline: 0  ;
    border: 1px solid lightgrey;
    border-radius: 5px;
    margin: 1% 0;
}
button{
    width: 150px;
    height: 40px;
    border: 5px;
    font-size: 1.1rem;
    cursor: pointer;
    border-radius: 5px;
    background-color: transparent;
    position: relative;
    overflow: hidden;
    color: white;
    box-shadow: inset 0 2px 12px 5px rgb(254, 254, 254);
}
button::after{
    content: '';
    width: 0%;
    height: 100%;
    background-color: rgb(10, 110, 210);
    border-radius: 3px;
    position: absolute;
    box-shadow: 0 2px 12px 5px rgb(10, 110, 210);
    top: 0;
    left: 0;
    z-index: -1;
    transition: .25s;
}
button:hover::after{
    width: 100%;
}

.list-of-all-cities{
    margin-top: 2%;
    width: 100%;
    height: auto;
    display: grid;
    grid-template-columns: repeat(auto-fill ,minmax(16%, 1fr));
    grid-template-rows: minmax(auto, auto);
    padding: 1% 5%;
    font-size: 1.1rem;
}
.city-list{
    margin: 2% ;
    width: auto;
    height: 40px;
    line-height: 40px;
    text-align: center;
    border-radius: 100px;
    background-color: white;
    color: black;
    cursor: pointer;
    position: relative;
}
.city-list p{padding: 0;margin: 0;}

.city-list-delete{
    width: 20px;
    height: 20px;
    border-radius: 50%;
    position: absolute;
    right:  0px;
    top: 10px;
    background-color: rgb(214, 15, 35);
    color: white;
    display: flex;
    align-items: center;justify-content: center;
    padding: 0;
    margin: 0;            
}
.city-list-delete:hover{background: black;}
.switch-the-tab{
    width: 100%;
    height: auto;
    padding: 2% 5%;
    background-color: rgba(0, 0, 0, 0.4);
    display: flex;
    gap: 5%;
}
.switch-the-tab button{    
    box-shadow: inset 0 2px 12px 5px rgb(255, 0, 0);
}
.switch-the-tab button:first-child{    
    box-shadow: inset 0 2px 12px 5px rgb(0, 30, 255);
}
.switch-the-tab button:first-child:hover::after{
    background-color: blue;
    box-shadow: 0 2px 12px 5px rgb(0, 30, 255);
    width: 100%;
}

.switch-the-tab button:hover::after{
    background-color: red;
    box-shadow: 0 2px 12px 5px rgb(210, 10, 10);
    width: 100%;
}
.form-flex{
    width: 100%;
    height: auto;
    display: flex;
    gap: 2%;
}
.form-flex select {
    width: 20%;
    height: 50px;
    outline: 0  ;
    border: 1px solid lightgrey;
    border-radius: 5px;
    margin: 1% 0;
}
.form-flex input{width: 80%;}

/* ADD CITY */

        .uploading,
        .report {
            width: 100%;
            height: 100%;
            position: fixed;
            inset: 0;
            color: white;
            background-color: rgb(0, 0, 0, .5);
            display: none;
            place-items: center;
        }

        #close_report {
            position: absolute;
            top: 5%;
            right: 5%;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: white;
            cursor: pointer;
            background-color: black;
        }

        .new-city-added {
            position: relative;
        }

        .new-city-added::after {
            content: '';
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background-color: tomato;
            position: absolute;
            top: -8px;
            right: 10px;
        }

        .list_of_all_area_with_city {
            width: 100%;
            overflow-y: auto;
            height: auto;
            display: flex;
            align-items: center;
            padding: 2%;


        }

        .city_dedicated_to_areas {
            flex: 20%;
        }

        .areas_dedicated_to_city {
            flex: 1 0 80%;
            margin-top: 0;
            grid-template-columns: repeat(auto-fill, minmax(25%, 1fr));
        }

        .delete-warning {
            width: 100%;
            height: 100%;
            position: fixed;
            inset: 0;
            background-color: rgb(0, 0, 0, .5);
            display: none;
            place-items: center;
        }

        .delete-confirm {
            width: auto;
            height: auto;
            background-color: white;
            text-align: center;
            border-radius: 5px;
            font-size: 1.2rem;
            padding: 2%;
            display: grid;
            place-items: center;
            font-weight: bold;
        }

        .delete-warning i {
            color: rgb(255, 0, 0, 1);
            font-size: 6rem;
            filter: drop-shadow(1px -12px 20px red);
            animation: glow .75s ease-in-out infinite alternate;
        }

        @keyframes glow {
            0% {
                color: rgb(255, 0, 0, .5);
                filter: drop-shadow(1px -12px 10px red);
            }

            ;

            50% {
                color: rgb(255, 0, 0, .75);
                filter: drop-shadow(1px -12px 15px red);
            }

            ;

            100% {
                color: rgb(255, 0, 0, 1);
                filter: drop-shadow(1px -12px 20px red);
            }
        }

        .btn-danger {
            background-color: tomato;
            box-shadow: none;
        }

        .btn-primary {
            box-shadow: none;
            border: 1px solid dodgerblue;
            color: dodgerblue;
        }
        .successMessage{
            position: absolute;
            top: 5%;
            left: 45%;
            z-index: 999;
            padding: .2% 3%;
            border-radius: 100px;
            display: none;
            place-items: center;
            color: white;
        }
    </style>

</head>

<body>

    <div class="container">
        <div class="menu-pannel">
            <?php include '../navbar.php' ?>
        </div>
        <div class="action-pannel">
            <div class="action-center">

                <div class="switch-the-tab">
                    <button id="add-city-btn">Add City</button>
                    <button id="add-area-btn">Add Area</button>
                </div>

                <div class="add-city" id="add-city" style="display: block;">

                    <h2>Add City:</h2>
                    <input type="hidden" name="token" value="<?= generateCsrfToken() ?>">
                    <input type="text" name="city_name" id="city_name" placeholder="City Name..." required /><br>
                    <button name="add-city" class="btn btn-primary" onclick="savethecityandarea('city_name')">Submit</button>

                    <div class="list-of-all-cities" id="list-of-all-cities">
                        <?= $grid ?>
                    </div>
                </div>

                <div class="add-city" id="add-area" style="display: none;">
                    <h2>Add Area:</h2>
                    <input type="hidden" name="token" value="<?= generateCsrfToken() ?>">
                    <div class="form-flex">
                        <select name="city_name_" id="city_name_" required>
                            <?= $option ?>
                        </select>
                        <input type="text" name="city_area" id="city_area" placeholder="City Area..." required />
                    </div>
                    <button name="add-area" class="btn btn-primary" onclick="savethecityandarea('city_area')">Submit</button>

                    <div id="list_of_all_area_with_city">
                        <?= $area_grid ?>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="uploading" id="uploading">
        <p>Uploading....</p>
    </div>

    <div class="report" id="report">
        <span id="close_report">X</span>
        <div style="width: 50%;height: 70%;overflow:auto;">
            <table id="table_report"></table>
        </div>
    </div>

    <div class="delete-warning">
        <div class="delete-confirm">
            <strong><i class="ri-alarm-warning-fill"></i></strong>
            <p style="text-wrap: nowrap;">Deleting The City Also Delete All Areas Under This City.<br>Are You Sure Want To Proceed?</p>
            <div><button id="confirmtodeletethecity" class="btn-danger">Yes, I'm sure!</button>
                <button onclick="noDeleteCity()" class="btn-primary">No, Go Back</button>
            </div>
        </div>
    </div>
<div class="successMessage" id="successMessage"></div>
    <script>
        document.getElementById('add-city-btn').addEventListener('click', () => {
            let addCity = document.querySelector('#add-city');
            let addArea = document.querySelector("#add-area");
            if (addCity.style.display === "none") {
                addCity.style.display = "block";
                addArea.style.display = "none";
            }
        })
        document.getElementById('add-area-btn').addEventListener('click', () => {
            let addCity = document.querySelector('#add-city');
            let addArea = document.querySelector("#add-area");
            if (addArea.style.display === "none") {
                addArea.style.display = "block";
                addCity.style.display = "none";
            }
        })
    </script>

    <script>
        function savethecityandarea(id) {
            document.getElementById('uploading').style.display = 'grid';
            var values = document.getElementById(id).value
            const formData = new FormData()
            formData.append('token', '<?= generateCsrfToken() ?>')
            formData.append('value', values)
            formData.append('pass', id)
            if (id == 'city_area') {
                var _city_name_ = document.getElementById('city_name_').value
                formData.append('_city_name_', _city_name_)
            }
            fetch('<?= get_url() ?>save-the-city/', {
                    method: 'POST',
                    body: formData,
                }).then(res => res.json())
                .then(d => {
                    var values = document.getElementById(id).value = ''
                    document.getElementById('uploading').style.display = 'none';
                    document.getElementById('report').style.display = 'grid';
                    if (d['id'] == 'city_name') {
                        document.getElementById('table_report').innerHTML = d['report']
                        document.getElementById('list-of-all-cities').innerHTML += d['output']
                        document.getElementById('city_name_').innerHTML += d['option']
                    } else if (d['id'] == 'city_area') {
                        document.getElementById('table_report').innerHTML = d['report']
                        document.getElementById('list_of_all_area_with_city').innerHTML += d['output']
                    }
                })
        }
        document.getElementById('close_report').addEventListener('click', () => {
            document.getElementById('report').style.display = 'none'
        })
        confirmtodeletethecity = document.getElementById('confirmtodeletethecity');

        function Deletethecity(pass, id, key) {
            document.querySelector('.delete-warning').style.display = 'grid';
            confirmtodeletethecity.setAttribute('onclick', `yesDeleteCity('${pass}',${id},'${key}')`);
        }

        function yesDeleteCity(pass, id, key) {
            const DeleteData = new FormData();
            DeleteData.append('id', id)
            DeleteData.append('pass', pass)
            if (pass == 'city_area') {
                DeleteData.append('index', key);
            }
            fetch('<?= get_url() ?>delete-the-city', {
                method: "POST",
                body: DeleteData
            }).then(res => res.json()).then(d => {
                if ((d['status'] == 200) && (d['pass'] == 'city_name')) {
                    document.getElementById('list-of-all-cities').innerHTML = ''
                    document.getElementById('city_name_').innerHTML = ''
                    document.querySelector('.delete-warning').style.display = 'none';
                    document.getElementById('list-of-all-cities').innerHTML += d['output']
                    document.getElementById('city_name_').innerHTML += d['option']
                    // success message
                    document.getElementById('successMessage').style.backgroundColor = 'green';
                    document.getElementById('successMessage').innerHTML = '<p>Deleted Successfully</p>'
                    document.getElementById('successMessage').style.display = 'grid';
                    // success message
                }else if((d['status'] == 200) && (d['pass'] == 'city_area')){
                    document.querySelector('.delete-warning').style.display = 'none';
                    document.getElementById('list_of_all_area_with_city').innerHTML = '';
                    document.getElementById('list_of_all_area_with_city').innerHTML += d['output']
                    console.log(d['a'])
                    console.log('===============================')
                    console.log(d['b'])
                    // success message
                    document.getElementById('successMessage').style.backgroundColor = 'green';
                    document.getElementById('successMessage').innerHTML = '<p>Deleted Successfully</p>'
                    document.getElementById('successMessage').style.display = 'grid';
                    // success message
                }else{
                    document.querySelector('.delete-warning').style.display = 'none';
                    // success message
                    document.getElementById('successMessage').style.backgroundColor = 'tomato';
                    document.getElementById('successMessage').innerHTML = d['output']
                    document.getElementById('successMessage').style.display = 'grid';
                    // success message
                }
                setTimeout(()=>{document.getElementById('successMessage').style.display = 'none';},3000)

            })
        }

        function noDeleteCity() {
            document.querySelector('.delete-warning').style.display = 'none';
            confirmtodeletethecity.removeAttribute('onclick');
        }
    </script>

</body>

</html>