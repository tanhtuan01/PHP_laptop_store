<?php 

	require_once dirname(dirname(__DIR__)) . '/db/base.php';

	$db = new Database();
	
	if(isset($_POST['submit'])){

		 $data = [
            'name' => $_POST['name'],
            'description' => $_POST['desc']
        ];

       if ($db->insert('t_features', $data)) {
           header("Location: ../index.php?page=features&type=success&message=Thêm thành công");
            exit();
        } else {
           header("Location: ../index.php?page=features&type=error&message=Thêm thất bại");
            exit();
        }

	}

	if(isset($_GET['action']) && $_GET['action'] === 'delete'){

	    if ($db->delete('t_features', $_GET['id'])) {
	        header("Location: ../index.php?page=features&type=success&message=Xóa thành công");
	    } else {
	        header("Location: ../index.php?page=features&type=error&message=Xóa thất bại");
	    }
	}


?>