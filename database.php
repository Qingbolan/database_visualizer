<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Visualization</title>
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            padding: 10px;
        }

        h1 {
            margin-top: 0;
            font-size: 1.8rem;
            text-align: center;
            font-weight: bold;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            color: #0077cc;
            text-decoration: none;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 0 5px rgba(0,0,0,0.3);
            background-color: #fff;
            border-radius: 5px;
            overflow: hidden;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        h2, h3 {
            margin-top: 20px;
            margin-bottom: 10px;
            font-weight: normal;
        }

        hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }

        @media screen and (max-width: 480px) {
            h1 {
                font-size: 1.4rem;
            }
            h2 {
                font-size: 1.2rem;
            }
            h3 {
                font-size: 1rem;
            }
            th, td {
                font-size: 0.9rem;
            }
            table {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <?php
    require_once 'database/config.php';

    $result_tables = $mysqli->query('SHOW TABLES');

    if ($result_tables->num_rows > 0) {
        echo '<h1>database_visualizer</h1><p>version-2023-4-2</p><tr><h2>Tables</h2>';
        echo '<ul>';
        while ($table = $result_tables->fetch_array()) {
            echo '<li><a href="#' . $table[0] . '"> \__' . $table[0] . '</a></li>';
        }
        echo '</ul>';

        $result_tables->data_seek(0);

        while ($table = $result_tables->fetch_array()) {
            echo '<hr id="' . $table[0] . '">';
            echo '<h2>Table: ' . $table[0] . '</h2>';

            $result_columns = $mysqli->query('SHOW COLUMNS FROM ' . $table[0]);

            echo '<h3>Structure</h3>';
            echo '<table>';
            echo '<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Extra</th></tr>';

            while ($column = $result_columns->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $column['Field'] . '</td>';
                echo '<td>' . $column['Type'] . '</td>';
                echo '<td>' . $column['Null'] . '</td>';
                echo '<td>' . $column['Key'] . '</td>';
                echo '<td>' . $column['Extra'] . '</td>';
                echo '</tr>';
            }

            echo '</table>';

            $result_data = $mysqli->query('SELECT * FROM ' . $table[0]);

            echo '<h3>Data</h3>';
            echo '<table>';
            echo '<tr>';

            foreach ($result_columns as $column) {
                echo '<th>' . $column['Field'] . '</th>';
            }

            echo '</tr>';

            while ($row = $result_data->fetch_assoc()) {
                echo '<tr>';

                foreach ($result_columns as $column) {
                    echo '<td>' . htmlspecialchars($row[$column['Field']], ENT_QUOTES, 'UTF-8') . '</td>';
                }
                echo '</tr>';
            }
    
            echo '</table>';
        }
    } else {
        echo '<p>No tables found in the database.</p>';
    }
    
    $result_tables->close();
    $mysqli->close();
    ?>

</body>
</html>
