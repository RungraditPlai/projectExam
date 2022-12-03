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
            <th>No.</th>
            <th>item</th>

        </tr>
        <?php $num = 1;
        foreach ($data as $row) {
        ?>
            <tr>
                <td><?= $num ?></td>
                <td><?= $row['name'] ?></td>
            </tr>
        <?php $num++;
        } ?>
    </table>
</body>

</html>