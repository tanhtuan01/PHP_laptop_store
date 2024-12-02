<?php 

    require_once 'base.php';

    class Role extends Database{
     
        public function getRoleByUser($userId){
            
            $sql = "
                SELECT r.role, r.roleName 
                FROM t_roles r 
                JOIN t_user_roles ur on r.id = ur.roleId
                WHERE  ur.userId = :userId;
            ";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

            $stmt->execute();

            $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $orderDetails;

        }
        
    }

?>