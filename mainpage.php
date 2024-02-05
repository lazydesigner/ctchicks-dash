<?php include './routes.php'; include './connection.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.min.css" async />
    <title>CTChicks - Dashboard</title>
    <link rel="stylesheet" href="./assets/css/index.css">
    <meta name="robots" content="noindex" />
    <meta name="googlebot" content="noindex,nofollow">
    <style>
        .search-add-add-profile {
            width: 100%;
            height: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* background-color: black; */
            padding: 1%;
            border-radius: 5px;
        }

        .search-add-add-profile .search {
            width: 400px;
            height: 40px;
            border: 1px solid rgb(255, 255, 255);
            border-radius: 5px;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            font-size: 1.4rem;
            padding: 0 .5%;
            color: white;
        }

        .search input {
            width: 100%;
            height: 100%;
            border: 0;
            outline: 0;
            background-color: transparent;
            padding: 1%;
            color: white;
        }

        .add-profile button {
            width: 100px;
            height: 40px;
            background-color: dodgerblue;
            color: white;
            font-weight: bold;
            font-size: 1.1rem;
            border-radius: 5px;
            border: 0;
            cursor: pointer;
        }

        .add-profile button:hover {
            background-color: rgba(16, 91, 213, 0.237);
            backdrop-filter: blur(12px);
        }

        .add-profile button:hover i {
            font-size: 1.3rem;
        }

        .list-of-profiles {
            width: 100%;
            height: auto;
            margin-top: 5%;
        }

        .list-of-profiles table {
            width: 100%;
            height: auto;
            border-collapse: collapse;
            text-align: center;
            /* border-spacing: 0; */

        }

        .list-of-profiles table thead th {
            background-color: black;
            color: white;
            padding: 1%;
            position: relative;

        }

        .list-of-profiles table tbody td {
            padding: 1%;
            color: rgb(0, 0, 0);
            text-transform: capitalize;
            background-color: #ffffff;
            border-bottom: 1px dashed tomato;
        }

        .action-btn span {
            font-size: 1.5rem;
            cursor: pointer;
        }

        .action-btn {
            height: 100%;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .action-btn a:last-child {
            color: dodgerblue;
        }

        .action-btn a:first-child {
            color: tomato;
        }

        .tooltip {
            position: relative;
        }

        .tooltip:hover::before {
            content: attr(data-tooltip);
            position: absolute;
            background-color: #000000;
            width: auto;
            color: #fff;
            padding: 8px;
            border-radius: 4px;
            top: -33px;
            /* Adjust the distance from the button */
            left: 50%;
            transform: translateX(-50%);
            font-size: small;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .tooltip:hover::before {
            opacity: 1;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="menu-pannel">
            <?php include './navbar.php' ?>
        </div>
        <div class="action-pannel">
            <div class="action-center">
                <div class="search-add-add-profile">
                    <div class="search">
                        <input type="text" name="search" id="search" autocomplete="off" placeholder="Search profiles..." /><i class="ri-search-eye-line"></i>
                    </div>
                    <div class="add-profile"><a href="<?=get_url() ?>add-profile/"><button><i class="ri-add-line"></i> Add</button></a></div>
                </div>

                <div class="list-of-profiles">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:2%">SNo.</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>City</th>
                                <th>Area</th>
                                <th style="width:12%;background:tomato">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            
                            $sql = "SELECT * FROM profiles";
                            $result = mysqli_query($con, $sql);
                            if (mysqli_num_rows($result)>0) {
                                while($row = mysqli_fetch_assoc($result)){?>
                                <tr>
                                <td><?=$row['profile_id'] ?></td>
                                <td><?=$row['profile_name'] ?></td>
                                <td>
                                    <?php 
                                    $cat_ = '';
                                    foreach(json_decode($row['cat_'],true) as $i => $cat){
                                        if($i == (count(json_decode($row['cat_'],true))  - 1 ) ){
                                            $cat_ .= $cat;
                                        }else{
                                        $cat_ .= $cat.', ';
                                    }}
                                    echo $cat_;
                                    ?>
                                </td>
                                <td><?=$row['cities'] ?></td>
                                <td><?=$row['areas'] ?></td>
                                <?php                                 
                                $create_url = 'https://ctchicks.com/'.$row['cities'].'/';
                                    if(strtolower($row['areas']) == 'all'){
                                        $create_url.= $row['identity_cat'].'/';
                                    }else{
                                        $create_url.= $row['areas'].'/'.$row['identity_cat'].'/';
                                    }

                                
                                ?>
                                <td>
                                    <div class="action-btn"><a href="<?=get_url() ?>edit-profile/<?=$row['profile_id'] ?>"><span class="tooltip" data-tooltip="Edit!"><i class="ri-edit-box-line"></i></span></a> <a href="<?=$create_url ?>"><span class="tooltip" data-tooltip="View!"><i class="ri-eye-2-line"></i></span></a></div>
                                </td>
                            </tr>
                                <?php }
                            }else{
                                ?><tr>
                                <td colspan="6">No Profile Created Yet</td>
                                  </tr>
                                <?php
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>