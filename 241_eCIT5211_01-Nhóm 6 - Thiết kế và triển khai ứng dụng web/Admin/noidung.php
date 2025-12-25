<br>
<?php
if (isset($_GET["id"]))
{
 $id = $_GET["id"];
 switch ($id){
    case 1: 
        ?> <?php include "baocao.php" ?> <?php
        break;
        case 2:
            ?> <?php include "donhang.php" ?> <?php
            break;
            case 3:
                ?> <?php include "sanpham.php" ?> <?php
                break;
                case 4:
                    ?> <?php include "taikhoan.php" ?> <?php
                    break;

  }
}

 ?>