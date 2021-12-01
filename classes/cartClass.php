
<?php 
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'../lib/database.php');
    include_once ($filepath.'../halpers/formet.php');
?>
<?php
    class cartClass{
        private $db;
        private $fm;
        public function __construct(){
            $this->db = new Database();
            $this->fm = new Format();
        }
        public function insert($gatId, $quantity){
            $quantity = $this->fm->validation($_POST['quantity']);
            $quantity = mysqli_real_escape_string($this->db->link, $quantity);
            $id = mysqli_real_escape_string($this->db->link, $gatId);
            if($quantity > 0){

                $squery = "SELECT * FROM tbl_product WHERE id = '$id'";
                $result = $this->db->select($squery)->fetch_assoc();
                $sId = session_id();
                $productName = $result['title'];
                $price = $result['price'];
                $image = $result['thumbnail'];
                
                $chkQuery = "SELECT * FROM tbl_cart WHERE productId = '$id' AND sId = '$sId'";
                $check_pro = $this->db->select($chkQuery);
                if($check_pro){
                    $msg = "<strong><h4 class='text-danger bg-danger' style='padding:15px;'>Product Already Added! <a href='index.php'> Continue Shopping</a></h4></strong>";
                    return $msg;
                }else{
                    $query = "INSERT INTO tbl_cart(sId, productId, productName, price, quantity, image) VALUES ('$sId','$id','$productName','$price','$quantity','$image')";
                    $inserted = $this->db->insert($query);

                    if($inserted){
                        echo "<script>window.location='shopping-cart.php';</script>";
                    }else{
                        header("Location:404.php");
                    }
                }
            }else{
                $msg = "<strong><h4 class='text-danger bg-danger' style='padding:15px;'> Quentaty must be at last 1 <a href='index.php'> Continue Shopping</a></h4></strong>";
                    return $msg;
            }
        }
        
        public function selectCrtProduct(){
            $sId = session_id();
            $squery = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
            $result = $this->db->select($squery);
            return $result;
            
        }

        public function updateCart($cartId, $quentaty){
            $proId = $this->fm->validation($cartId);
            $update_qtty = $this->fm->validation($quentaty);

            $proId = mysqli_real_escape_string($this->db->link, $proId);
            $update_qtty = mysqli_real_escape_string($this->db->link, $update_qtty);
            $sId = session_id();
           
            $query = "UPDATE tbl_cart SET quantity = '$update_qtty' WHERE productId = '$proId' AND sId = '$sId'";
            $result = $this->db->update($query);
            
            if($result){
                echo "<script>window.location='shopping-cart.php';</script>";
                if(!isset($_GET['id'])){
                    echo "<meta http-equiv='refresh' content='0;URL=?id=load'/>";
                }
            }else{
                $msg = '<p class="mb-0 text-warning">There Was Something Wrong to updated</p>';
                return $msg;
            }
        }
        public function delete($gatId){
            $sId = session_id();
            $delquery = "DELETE FROM tbl_cart WHERE productId = '$gatId' AND sId = '$sId'";
            $delresult = $this->db->delete($delquery);
        }

        public function checkTbl(){
            $sId = session_id();
            $query = "SELECT* FROM tbl_cart WHERE sId = '$sId'";
            $result = $this->db->select($query);
            return $result;
        }
        public function delCrtData(){
            $sId = session_id();
            $delquery = "DELETE FROM tbl_cart WHERE sId = '$sId'";
            $delresult = $this->db->delete($delquery);
        }

        public function addtocart($gatId){
            $gatId = mysqli_real_escape_string($this->db->link, $gatId);
            $sId = session_id();

            $ckquery = "SELECT * FROM tbl_cart WHERE productId = '$gatId' AND sId = '$sId'";
            $result = $this->db->select($ckquery);
            if($result){
                // echo "<meta http-equiv='refresh' content='0;URL=?id=load'/>";
                // echo "<script>window.location='index.php';</script>";
                $msg = '<h4 class=""><span class=" bg-info warning">Already added Please visit cart Page</span></h4>';
                return $msg;
            }else{

                $query = "SELECT * FROM tbl_product WHERE id = '$gatId'";

                $result = $this->db->select($query);
                $data = $result->fetch_assoc();

                $productId = $data['id'];
                $productName = $data['title'];
                $price = $data['price'];
                $image = $data['thumbnail'];
                $quantity = 1;

                $query = "INSERT INTO tbl_cart(sId, productId, productName, price, quantity, image) VALUES ('$sId','$productId ','$productName','$price','$quantity','$image')";
                $inserted = $this->db->insert($query);
                    if($inserted){
                        echo "<meta http-equiv='refresh' content='0;URL=?id=load'/>";
                        $msg = '<p class="mb-0 text-success">Cart insertd</p>';
                        return $msg;
                    }
            }
        }
        
    }
    
?>