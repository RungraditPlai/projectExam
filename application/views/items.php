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
    <table>
        <tr>
            <th>name</th>
            <th>itemId</th>
            <th>chance</th>
            <th>stock</th>
        </tr>
        <?php foreach ($data as $row) { ?>
            <tr>
                <td><?= $row->name ?></td>
                <td><?= $row->game_item_id ?></td>
                <td><?= $row->chance ?></td>
                <td><?= $row->stock ?></td>
            </tr>
        <?php } ?>
    </table>

    <a href="http://localhost/example/home/random"><input type="button" value="random" /></a>
</body>

</html>