<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
    <div id="sidebar">
        <h2 id="a1">Admin Dashboard</h2>
        <nav>
            <ul>
                <li><a href="?page=edit"><button>View Users</button></a></li>
                <li><a href="?page=view"><button>View Resturants</button></a></li>
                <li><a href="?page=add"><button>Add Users</button></a></li>
                <li><a href="?page=addr"><button>Add Resturants</button></a></li>
                <li><a href="?page=index"><button>Logout</button></a></li>
            </ul>
        </nav>
    </div>
    <div class="content">
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';

        switch ($page)
        {
            case 'edit':
                include('action.php');
                break;
            case 'view':
                include('edit_rest.php');
                break;
            case 'add':
                include('add_user.php');
                break;
            case 'addr':
                include('add_hotel.php');
                break;
            case 'index':
                header("Location: index.html");
                break;
        }
        ?>
    </div>
</body>
</html>
