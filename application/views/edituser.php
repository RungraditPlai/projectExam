<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
</head>
<style>
</style>

<body>



    <h2>Edit</h2>
    <form action="http://localhost/example/user/editUserData" method="post">

        <input type="hidden" id="us" name="user" value="<?= $data['temp'] ?>">
        <label for="ชื่อ - นามสกุล">First name:</label><br>
        <input type="text" id="fname" name="fname" value="<?= $data['name'] ?>"><br>

        <label for="telephone">telephone:</label><br>
        <input type="telephone" id="telephone" name="telephone" value="<?= $data['phone'] ?>"><br>

        <label for="password">password:</label><br>
        <input type="password" id="password" name="password" value="<?= $data['password'] ?>"><br>

        <label for="email">email:</label><br>
        <input type="text" id="email" name="email" value="<?= $data['email'] ?>"><br>

        <label for="username">username:</label><br>
        <input type="text" id="username" name="username" value="<?= $data['username'] ?>"><br>

        <label for="company">company:</label><br>
        <input type="text" id="company" name="company" value="<?= $data['company'] ?>"><br>

        <label for="nationality">nationality:</label><br>
        <input type="text" id="nationality" name="nationality" value="<?= $data['nationality'] ?>"><br><br>

        <input type="submit" value="Submit">
    </form>
</body>

</html>