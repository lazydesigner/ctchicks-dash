<?php include '../routes.php';
include '../connection.php' ?>
<?php

$edit_id = $_GET["id_"];

$city_query = "SELECT * FROM profiles WHERE profile_id = $edit_id ";
$result = mysqli_query($con, $city_query);
$row = mysqli_fetch_assoc($result);


$city_option_query = "SELECT * FROM city";
// $city_query = "SELECT * FROM city INNER JOIN area on city.city_id = area.city_area_id";
$result_option = mysqli_query($con, $city_option_query);
$option = '<option value="all">---Select A City---</option>';

if (mysqli_num_rows($result_option) > 0) {
    while ($row_option = mysqli_fetch_array($result_option)) {
        if (strtolower($row_option['city_name']) == strtolower($row['cities'])) {
            $option .= '<option value="' . strtolower($row_option['city_name']) . '" selected>' . $row_option['city_name'] . '</option>';
        } else {
            $option .= '<option value="' . strtolower($row_option['city_name']) . '">' . $row_option['city_name'] . '</option>';
        }
    }
}

$area_option_query = "SELECT * FROM area2 WHERE area_city_name = '" . strtolower($row['cities']) . "'";
$area_result = mysqli_query($con, $area_option_query);

$area_result_row = mysqli_fetch_assoc($area_result);
$option_area = '<option value="all">All Location</option>';

if (!empty($area_result_row['area_name'])) {

    foreach (json_decode($area_result_row['area_name'], true) as $area_row) {
        $x = explode('-', $area_row);
        $d = '';
        foreach ($x as $c) {
            $d .= $c . ' ';
        }
        if (strtolower($area_row) == strtolower($row['areas'])) {
            $option_area .= "<option value='" . strtolower($area_row) . "' selected>" . $d . "</option>";
        } else {
            $option_area .= "<option value='" . strtolower($area_row) . "'>" . $d . "</option>";
        }
    }
}






?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= get_url() ?>assets/fonts/remixicon.css" async />
    <title>CTChicks - Dashboard</title>
    <link rel="stylesheet" href="<?= get_url() ?>assets/css/index.css">
    <meta name="robots" content="noindex" />
    <meta name="googlebot" content="noindex,nofollow">
    <style>
        /* FORM STYLE */
        /* .action-center { */
        /* backdrop-filter: blur(4px); */
        /* background-color: transparent; */
        /* } */

        .form-container {
            /* width: 95%; */
            padding: .5% 2%;
            margin: 2% auto;
            border-radius: 5px;
            /* backdrop-filter:  blur(12px) saturate(180%) contrast(80%); */
            /* background-color: rgba(255, 0, 0, 0.201); */
        }

        .form-group {
            width: 100%;
            height: auto;
            margin: 2% 0;
        }

        #profile h2 {
            color: var(--links);
        }

        .form-flex,
        .form-flex2 {
            width: 100%;
            height: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 2%;
        }

        input,
        textarea[name='meta_description'] {
            width: 100%;
            height: 35px;
            border-radius: 5px;
            outline: 0;
            border: 1px solid lightgray;
            padding: 1%;
        }

        .form-flex :where(select, input, .body-shape) {
            flex: 1 0 32%;
            height: 40px;
            outline: 0;
            border: 1px solid lightgrey;
            font-size: 1rem;
            border-radius: 5px;
        }

        textarea[name='meta_description'] {
            height: 100px;
            resize: none;
        }

        .body-shape {
            border: 0;
            position: relative;
        }

        .form-flex2 input {
            flex: 1 0 32%;
            position: relative;
        }

        .body-shape::after {
            content: 'bust-waist-hip';
            width: 100px;
            height: 20px;
            position: absolute;
            top: -17px;
            border-radius: 5px;
            padding: 0 1%;
            text-align: center;
            left: 2%;
            background-color: black;
            color: var(--links);
        }

        .pro-type {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 1%;
            font-weight: bold;
            color: var(--links);
        }

        input[type='checkbox'] {
            width: 20px;
            height: 20px;
        }

        .cat {
            width: 100%;
            height: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .cat-col {
            flex: 1 0 15%;
        }

        input[type='file'] {
            padding: 0;
            margin: 0;
            border: 0;
        }

        ::-webkit-file-upload-button {
            width: 150px;
            height: 40px;
            padding: 0;
            margin: 0;
            font-size: 1.1rem;
        }

        .preview-the-image {
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.509);
            display: none;
            place-items: center;
            position: fixed;
            top: 0;
            left: 0;
        }

        .image-confirm {
            width: 55%;
            height: 65%;
            background-color: #fff;
            padding: 2%;
        }

        .the-image {
            width: 250px;
            height: 300px;
            margin: auto;
            background-color: lightgray;
        }

        .confirm-btn {
            width: 100%;
            height: auto;
            margin-top: 5%;
            display: flex;
            gap: 5%;
            align-items: center;
            justify-content: center;
        }

        .confirm-btn button {
            width: 100px;
            height: 40px;
            border: 0;
            background-color: green;
            color: #fff;
            cursor: pointer;
            font-size: 1rem;
        }

        .confirm-btn button:last-child {
            border: 1px solid tomato;
            background-color: transparent;
            color: tomato;
        }

        .preview-the-selected-image {
            width: 100%;
            height: auto;
            padding: 3% 2%;
            display: flex;
            justify-content: space-evenly;
        }

        .preview-image-box {
            width: 180px;
            height: auto;
            background-color: lightgrey;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .preview-image-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .delete-preview-image {
            position: absolute;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background-color: black;
            color: white;
            top: -20px;
            right: -20px;
            cursor: pointer;
        }

        .image-box-x {
            flex: 1 0 150px;
        }

        .image-preview-name {
            flex: 1 0 50px;
            background-color: red;
        }

        .image-preview-name input {
            width: 100%;
            height: 100%;
            border-radius: 0;
        }

        .image-preview-alt {
            flex: 1 0 40px;
        }

        .error-msg {
            width: auto;
            height: 60px;
            border-radius: 100px;
            background-color: tomato;
            color: var(--links);
            position: fixed;
            padding: 0 3%;
            line-height: 60px;
            top: 5%;
            left: 40%;
            display: none;
        }

        .error-msg p {
            padding: 0;
            margin: 0;
            font-size: 1.2rem;
        }

        textarea[name="content"] {
            width: 100%;
            height: auto;
            resize: none;
        }

        table {
            width: 80%;
            margin: auto;
        }

        table tr td {
            padding: 1% .2%;
        }

        table tr td label {
            width: 100%;
            display: flex;
            align-items: center;
            /* justify-content: space-between; */
            cursor: pointer;
            color: white;
        }

        button {
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

        button::after {
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

        button:hover::after {
            width: 100%;
        }

        /* FORM STYLE */
    </style>
</head>

<body>

    <div class="container">
        <div class="menu-pannel">
            <?php include '../navbar.php' ?>
        </div>
        <div class="action-pannel">
            <div class="action-center">
                <form id="profile" method="post" action="<?= get_url() ?>edit_pro.php" enctype="multipart/form-data">
                    <input type="hidden" name="id_user" value="<?= $_GET['id_'] ?>" />
                    <input type="hidden" name="identity" value="<?= $row['identity'] ?>" />
                    <div class="form-container">
                        <h2>Page Details</h2>
                        <div class="form-group">
                            <div class="form-flex">
                                <select name="callgirl-escort" id="callgirl-escort">
                                    <?php if ($row['callgirl_escort'] == 'call-girls') { ?>
                                        <option value="call-girls" selected>Call Girl</option>
                                        <option value="escorts">Escorts</option>
                                    <?php } else { ?>
                                        <option value="call-girls">Call Girl</option>
                                        <option value="escort" selected>Escorts</option>
                                    <?php } ?>
                                </select>
                                <select name="cities" id="cities">
                                    <?= $option ?>
                                </select>
                                <select name="areas" id="areas">
                                    <?= $option_area ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" name="page_title" value="<?= $row['page_title'] ?>" autocomplete="off" placeholder="Page Title (Optional)" id="page_title">
                        </div>
                        <div class="form-group">
                            <textarea name="meta_description" value="<?= $row['meta_description'] ?>" placeholder="Page Description (Optional)" id="meta_description" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="text" name="page_h1" autocomplete="off" value="<?= $row['page_h1'] ?>" placeholder="Page H1" id="page_title" required>
                        </div>
                    </div>
                    <div class="form-container">
                        <h2>Profile Details</h2>
                        <div class="form-group">
                            <div class="form-flex">
                                <input type="text" value="<?= $row['profile_name'] ?>" name="profile_name" placeholder="Enter Name" id="profile_name">
                                <input type="text" value="<?= $row['profile_age'] ?>" maxlength="2" name="profile_age" placeholder="Enter Age" pattern="[1-9][0-9]" id="profile_age">
                                <input type="text" value="<?= $row['profile_height'] ?>" name="profile_height" maxlength="4" placeholder="Enter Height (height must be in foot)" id="profile_height">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-flex">
                                <input type="text" value="<?= $row['profile_language'] ?>" name="profile_language" placeholder="Enter Language (Optional)" id="profile_language" list="profile_language2" style="appearance: none;">
                                <datalist id="profile_language2">
                                    <option value="Hindi">Hindi</option>
                                    <option value="Hindi, English">Hindi, English</option>
                                    <option value="English">English</option>
                                </datalist>
                                <input type="text" value="<?= $row['profile_nationality'] ?>" name="profile_nationality" placeholder="Enter Nationality (Optional)" id="profile_nationality" list="nation">
                                <datalist id="nation">
                                    <option value="Indian">Indian</option>
                                    <option value="Russian">Russian</option>
                                    <option value="Other">Other</option>
                                </datalist>
                                <div class="form-flex2 body-shape">

                                    <?php
                                    $body_ = json_decode($row['profile_body_shape'], true);
                                    ?>

                                    <input type="number" class="bust" min="28" name="profile_body_shape[]" value="<?= $body_[0] ?>" id="bust" placeholder="Bust">
                                    <input type="number" min="28" name="profile_body_shape[]" value="<?= $body_[1] ?>" id="Waist" placeholder="Waist">
                                    <input type="number" min="28" name="profile_body_shape[]" value="<?= $body_[2] ?>" id="Hip" placeholder="Hip">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-flex">
                                <select class="form-control" placeholder="Profile Type" name="profile_type" id="profile_type">
                                    <option value="0">Select Category</option>
                                    <option value="independent">Independent</option>
                                    <option value="Indian Call Girls">Indian Call Girls</option>
                                    <option value="Actress | Model | High Profile | VIP">Actress | Model | High Profile | VIP</option>
                                    <option value="College Girl | Young Girl">College Girl | Young Girl</option>
                                    <option value="House Wife | Desi Girl">House Wife | Desi Girl</option>
                                    <option value="Russian Escort | Foreigner Escort">Russian Escort | Foreigner Escort</option>
                                    <option value="Gujju Girl">Gujju Girl</option>
                                    <option value="Party Girl">Party Girl</option>
                                    <option value="Dating Escort">Dating Escort</option>
                                    <option value="Women Seeking Girl">Women Seeking Girl</option>
                                    <option value="Shemale Escort">Shemale Escort</option>
                                    <option value="Transgender | Lesbian">Transgender | Lesbian</option>
                                    <option value="Nepali Escort">Nepali Escort</option>
                                    <option value="Pubjabi Escort">Pubjabi Escort</option>
                                    <option value="Assamesse Escort">Assamesse Escort</option>
                                    <option value="Mallu Girl">Mallu Girl</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <table style="width: 100%;">
                                <tr>
                                    <td><label for="Independent"><input type="checkbox" name="cat_[]" id="Independent" value="Independent">Independent</label></td>
                                    <td><label for="Russian"><input type="checkbox" name="cat_[]" id="Russian" value="Russian Escorts">Russian Escorts</label></td>
                                    <td><label for="Indian-Call"><input type="checkbox" name="cat_[]" id="Indian-Call" value="Indian Call Girls">Indian Call Girls</label></td>
                                    <td><label for="Actress"><input type="checkbox" name="cat_[]" id="Actress" value="Actress">Actress</label></td>
                                    <td><label for="Model"><input type="checkbox" name="cat_[]" id="Model" value="Model">Model</label></td>
                                    <td><label for="High Profile"><input type="checkbox" name="cat_[]" id="High Profile" value="High Profile">High Profile</label></td>

                                </tr>
                                <tr>
                                    <td><label for="VIP"><input type="checkbox" name="cat_[]" id="VIP" value="VIP">VIP</label></td>
                                    <td><label for="Foreigner"><input type="checkbox" name="cat_[]" id="Foreigner" value="Foreigner Escort">Foreigner Escort</label></td>
                                    <td><label for="Gujju"><input type="checkbox" name="cat_[]" id="Gujju" value="Gujju Girl">Gujju Girl</label></td>
                                    <td><label for="Party"><input type="checkbox" name="cat_[]" id="Party" value="Party Girl">Party Girl</label></td>
                                    <td><label for="Dating"><input type="checkbox" name="cat_[]" id="Dating" value="Dating Escort">Dating Escort</label></td>
                                    <td><label for="Women-Seeking"><input type="checkbox" name="cat_[]" id="Women-Seeking" value="Women Seeking Girl">Women Seeking Girl</label></td>

                                </tr>
                                <tr>
                                    <td><label for="Shemale"><input type="checkbox" name="cat_[]" id="Shemale" value="Shemale Escort">Shemale Escort</label></td>
                                    <td><label for="Transgender"><input type="checkbox" name="cat_[]" id="Transgender" value="Transgender">Transgender</label></td>
                                    <td><label for="Lesbian"><input type="checkbox" name="cat_[]" id="Lesbian" value="Lesbian Girl">Lesbian Girl</label></td>
                                    <td><label for="Nepali"><input type="checkbox" name="cat_[]" id="Nepali" value="Nepali Escort">Nepali Escort</label></td>
                                    <td><label for="Pubjabi"><input type="checkbox" name="cat_[]" id="Pubjabi" value="Pubjabi Escort">Pubjabi Escort</label></td>
                                    <td><label for="Assamesse"><input type="checkbox" name="cat_[]" id="Assamesse" value="Assamesse Escort">Assamesse Escort</label></td>

                                </tr>
                                <tr>
                                    <td><label for="Mallu Girl"><input type="checkbox" name="cat_[]" id="Mallu Girl" value="Mallu Girl">Mallu Girl</label></td>
                                    <td><label for="College Girl"><input type="checkbox" name="cat_[]" id="College Girl" value="College Girl">College Girl</label></td>
                                    <td><label for="Young Girl"><input type="checkbox" name="cat_[]" id="Young Girl" value="Young Girl">Young Girl</label></td>
                                    <td><label for="Desi Girl"><input type="checkbox" name="cat_[]" id="Desi Girl" value="Desi Girl">Desi Girl</label></td>
                                    <td><label for="House Wife"><input type="checkbox" name="cat_[]" id="House Wife" value="House Wife">House Wife</label></td>
                                </tr>
                            </table>
                        </div>

                    </div>
                    <div class="form-container">
                        <div class="form-group">
                            <div class="form-flex">
                                <input type="file" name="images" id="images" accept="image/*" id="">

                                <div class="preview-the-selected-image" id="preview-the-selected-image">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-container">
                        <div class="form-group">
                            <textarea name="content" id="content" cols="30" rows="10"><?= $row['content'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-container">
                        <div class="form-group">
                            <button>Submit</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="preview-the-image" id="preview-the-image">

                <div class="image-confirm">
                    <div class="the-image">
                        <img src="" id="preview-image" width="100%" height="100%" alt="">
                    </div>
                    <div class="confirm-btn">
                        <button id="upload-the-image">Confirm</button>
                        <button onclick="denied()">Denied</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="error-msg">
        <p id="error_msg"></p>
    </div>


    <script>
            let checked_box = <?= $row['cat_'] ?>;

            if(checked_box == null || checked_box == ''){
                checked_box = []
            }

            let label = document.querySelectorAll('input[type="checkbox"]')
            for (j = 0; j < checked_box.length; j++) {
                for (let i = 0; i < label.length; i++) {
                    if (label[i].nextSibling.textContent.includes(checked_box[j])) {
                        label[i].checked = true;
                    }
                }
            }

        document.getElementById('images').addEventListener('change', (event) => {
            document.getElementById('preview-the-image').style.display = 'grid';
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imagePreview = document.getElementById('preview-image');
                    imagePreview.src = e.target.result;
                    document.getElementById('upload-the-image').click();
                };
                reader.readAsDataURL(input.files[0]);
            }
        })

        // const image_count = 0;
        let myImage = {};

        <?php
        if (!empty($row['image_']) && $row['image_'] != null) {
            $image_count = json_decode($row['image_'], true);

            $image_from_server = json_decode($row['image_']);
        $image_alt_from_server = json_decode($row['image_alt_']);

        foreach ($image_from_server as $i => $server_) {; ?>

            myImage[<?= $i ?>] = {}
            myImage[<?= $i ?>]['image_path'] = 'profiles/<?= $server_ ?>';
            myImage[<?= $i ?>]['image_name'] = '<?= $server_ ?>';
            myImage[<?= $i ?>]['number_of_image'] = <?= $i + 1 ?>;
            myImage[<?= $i ?>]['image_alt'] = '<?= $image_alt_from_server[$i] ?>';  

        <?php }} ?>

        async function confirm_(myImage) {
            confirm_image = document.getElementById('images');
            let imgPath = confirm_image.files[0];
            const formData = new FormData()
            formData.append('file', imgPath)
            await fetch('https://cdn.ctchicks.com/upload-image', {
                    method: 'POST',
                    body: formData
                }).then(res => res.json())
                .then(data => {
                    if (data['status'] == 200) {
                        image_count = Object.keys(myImage).length
                        image_count2 = Object.keys(myImage)
                        if (image_count == 0) {
                            image_count++
                        } else {
                            image_count = image_count2[image_count - 1]
                            image_count++
                        }
                        myImage[image_count] = {}
                        myImage[image_count]['image_path'] = data['image_path'];
                        myImage[image_count]['image_name'] = data['image_name'];
                        myImage[image_count]['number_of_image'] = image_count;
                        myImage[image_count]['image_alt'] = '';


                        displayImagesOnPage(myImage);
                        document.getElementById('preview-the-image').style.display = 'none';
                        if ((image_count2.length + 1) == 4) {
                            document.getElementById("images").disabled = true;
                        }

                    } else {
                        document.querySelector('.error-msg').style.display = 'block'
                        document.querySelector('.error-msg').style.backgroundColor = 'tomato'
                        document.getElementById('error_msg').innerText = data['error_msg']
                        setTimeout(() => {
                            document.querySelector('.error-msg').style.display = 'none'
                        }, 3000)
                    }
                })
        }

        document.getElementById('upload-the-image').addEventListener('click', () => {
            confirm_(myImage)
            document.getElementById('images').value = ''
        })

        function denied() {
            document.getElementById('preview-the-image').style.display = 'none';
            document.getElementById('images').value = ''
        }


        function deletetheimage(pathofimagetobedeleted, key) {
            // myImage = JSON.parse(myImage);
            const del_image = new FormData();
            del_image.append('path', pathofimagetobedeleted)
            fetch('https://cdn.ctchicks.com/delete-the-image.php', {
                method: 'POST',
                body: del_image
            }).then(res => res.json()).then(d => {
                if (d['status'] == 200) {
                    document.getElementById('preview-the-image').style.display = 'none';
                    delete myImage[key];
                    image_count = Object.keys(myImage).length
                    image_count--
                    displayImagesOnPage(myImage);
                    document.querySelector('.error-msg').style.display = 'block'
                    document.querySelector('.error-msg').style.backgroundColor = 'green'
                    document.getElementById('error_msg').innerText = 'Image Deleted Successfully';
                    setTimeout(() => {
                        document.querySelector('.error-msg').style.display = 'none'
                    }, 3000)
                    if (image_count < 4) {
                        document.getElementById("images").disabled = false;
                    }
                } else {
                    document.querySelector('.error-msg').style.display = 'block'
                    document.getElementById('error_msg').innerText = 'Something went Wrong: Not Deleted';
                    setTimeout(() => {
                        document.querySelector('.error-msg').style.display = 'none'
                    }, 3000)
                }
            })

        }

        function displayImagesOnPage(myImage) {
            document.getElementById('preview-the-selected-image').innerHTML = "";
            for (let key in myImage) {
                document.getElementById('preview-the-selected-image').innerHTML += '<div class="preview-image-box">\
                                        <span class="delete-preview-image" onclick="deletetheimage(\'' + myImage[key]['image_name'] + '\',' + key + ')"> X</span>\
                                         <div class="image-box-x">\
                                            <img src="<?= $pro_cdn ?>' + myImage[key]['image_path'] + '" width="100%" height="100%">\
                                         </div>\
                                         <div class="image-preview-name">\
                                            <input type="text" name="image_[]" value="' + myImage[key]['image_name'] + '" readonly>\
                                         </div>\
                                         <div class="image-preview-alt">\
                                            <input type="text" value = "' + myImage[key]['image_alt'] + '" name="image_alt_[]" id="image_alt_' + myImage[key]['number_of_image'] + '" onkeyup="changealtname(' + myImage[key]['number_of_image'] + ')" placeholder="Alt Name">\
                                         </div>\
                                    </div>'
            }
        }

        document.getElementById('cities').addEventListener('change', () => {
            let cityId = document.getElementById("cities").value;
            if (cityId == 0) {
                document.querySelector('#areas').innerHTML = "<option value='0'><p style='text-transform: capitalize;'>--Select Area--</p></option>"
            }
            const list_area = new FormData();
            list_area.append('city', cityId);
            list_area.append('pass', 'list-of-areas');

            fetch('<?= get_url() ?>delete-the-city', {
                    method: 'POST',
                    body: list_area
                }).then(res => res.json())
                .then(d => {
                    if (d['status'] == 200) {
                        document.querySelector('#areas').innerHTML = d['output'];
                    }
                })

        })


        function changealtname(id) {
            let v = document.getElementById('image_alt_' + id).value
            myImage[id]['image_alt'] = v;
        }
    </script>

    <script>
        document.getElementById('profile_type').addEventListener('change', () => {
            var type = document.getElementById('profile_type').value;
            if (type !== 0) {
                selected_category = type.split(' | ')
                category_label = document.getElementsByTagName('label');
                for (i = 0; i < category_label.length; i++) {
                    category_label[i].childNodes[0].checked = false
                }
                for (j = 0; j < selected_category.length; j++) {
                    for (i = 0; i < category_label.length; i++) {
                        if (category_label[i].childNodes[1].textContent.includes(selected_category[j])) {
                            category_label[i].childNodes[0].checked = true
                        }
                    }
                }
            }
        });
        <?php if (!empty($row['image_']) && $row['image_'] != null) { ?>
            displayImagesOnPage(myImage);
        <?php } ?>
    </script>
    <script src="<?= get_url() ?>assets/ckeditor/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content', {
            height: 490,
            // filebrowserUploadUrl: '/services/img_upload.php',
            removeButtons: 'PasteFromWord'
        });
    </script>


</body>

</html>