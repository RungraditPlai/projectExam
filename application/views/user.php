<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>random items</title>
</head>
<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>

<body>

    <table border="1" cellpadding="10">

        <tr>
            <th>name</th>
            <th>telephone</th>
            <th>email</th>
            <th>username</th>
            <th>company</th>
            <th>nationality</th>
            <th>edit</th>
            <th>delete</th>
        </tr>
        <?php foreach ($data['list'] as $row) {

        ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['phone'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['company'] ?></td>
                <td><?= $row['nationality'] ?></td>
                <td><a href="http://localhost/example/user/edit?username=<?= $row['username'] ?>"><input type="button" value="edit" /></a></td>
                <td><a href="http://localhost/example/user/delete?username=<?= $row['username'] ?>"><input type="button" value="delete" /></a></td>
            </tr>

        <?php } ?>

    </table>
    <?php for ($x = 1; $x <= $data['total']; $x++) : ?>
        <a href='http://localhost/example/user/list?page=<?php echo $x; ?>'><?php echo $x; ?></a>
    <?php endfor; ?>
    <h2>Add</h2>

    <form action="http://localhost/example/user/add" method="post">
        <label for="ชื่อ - นามสกุล">First name:</label><br>
        <input type="text" id="fname" name="fname" value=""><br>

        <label for="telephone">telephone:</label><br>
        <input type="telephone" id="telephone" name="telephone" value=""><br>

        <label for="telephone">password:</label><br>
        <input type="password" id="password" name="password" value=""><br>

        <label for="email">email:</label><br>
        <input type="text" id="email" name="email" value=""><br>

        <label for="username">username:</label><br>
        <input type="text" id="username" name="username" value=""><br>

        <label for="company">company:</label><br>
        <input type="text" id="company" name="company" value=""><br>

        <label for="nationality">nationality:</label><br>
        <input type="text" id="nationality" name="nationality" value=""><br><br>

        <input type="submit" value="Submit">
    </form>
</body>

</html>