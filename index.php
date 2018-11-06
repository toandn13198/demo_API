<?php 



class Nhanvien
{
    private $ma;
    private $ten;
    private $ngaysinh;
    private $gioitinh;

    //khởi tạo đối tượng.
    public function __construct()
    {
        $this->ma;
        $this->ten;
        $this->ngaysinh;
        $this->gioitinh;
    }
    
    //các phương thức set,get cho thuộc tính nhanvien.
    public function setten($ten){
        $this->ten = $ten;
    }
    public function getten(){
        return $this->ten;
    }
    //
    public function setngaysinh($ngaysinh){
        $this->ngaysinh = $ngaysinh;
    }
    public function getngaysinh(){
        return $this->ngaysinh;
    }
    //
    public function setgioitinh($gioitinh){
        $this->gioitinh= $gioitinh;
    }
    public function getgioitinh(){
        return $this->gioitinh;
    }
    //
    public function setma($ma){
        $this->ma= $ma;
    }
    public function getma(){
        return $this->ma;
    }


    //phuong thuc set gia tri tu url
    function urlset($arr_data){
        
        $this->setma($arr_data['ma']);
        $this->setten($arr_data['ten']);
        $this->setngaysinh($arr_data['ngaysinh']);
        $this->setgioitinh($arr_data['gioitinh']);
    }
}





///////////////////////////////////////////////////////////////////
class Model{

    //ket noi csdl
    public function getdbname($name)//get co tra ve
    {
        $con=new PDO("mysql:host=mysql;dbname=my_db","root","root");
        $sql="select *from nhanvien where ten='$name'";
        $resul=$con->query($sql);
        $con=null;
        return $resul;     
    }
    function execdb($sql){ //thuc thi khong tra la kq
        $con=new PDO("mysql:host=mysql;dbname=my_db","root","root");
        $con->exec($sql);
        $con=null;
    }

    //chuyen doi json tu request->array;
    function convertjsontoarr()
    {
        $json_data = file_get_contents("php://input");
        if(empty($json_data))//check neu k ton tai file json yeu cau tu clien,
        {
            echo json_encode(array('erro'=>'01','message'=>'khong ton tai yeu cau json tu clien !'));
            exit();
        }
        else{
            $arr_data = json_decode($json_data, true);
            if(empty($arr_data))//check neu khong phai la json.
            {
                echo json_encode(array('erro'=>'02','message'=>'json sai dinh dang !'));
                exit();
            }
            else{
                return $arr_data;
            } 
        }     
    }


    //show obj can tim
    function show($name){

        $arr=$this->getdbname($name);
        $arrjson=array();
        $arrerro=array('erro'=>'03','message'=>'khong co object nay trong CSDL');
        foreach($arr as $key => $row)
        {
             $arrjson[$key]['ma']=$row['ma'];
             $arrjson[$key]['ten']=$row['ten'];
             $arrjson[$key]['gioitinh']=$row['gioitinh'];
             $arrjson[$key]['ngaysinh']=$row['ngaysinh'];       
        }
        if(empty($arrjson))
        {
            return $arrerro;
        }
        else{
            return $arrjson;
        }
    }

    //create 1 obj mới vào csdl
    function create(){

        $arr_data=$this->convertjsontoarr();
        if(!isset($arr_data['ten'])||!isset($arr_data['ngaysinh'])||!isset($arr_data['gioitinh']))
        {
    
            echo json_encode(array('erro'=>'04','message'=>'json sai dinh dang mau!'));
            exit();
        }
        else
        {
            $Nhanvien=new Nhanvien();
            $Nhanvien->urlset($arr_data);
            $sql="insert into nhanvien(ten,gioitinh,ngaysinh) values('".$Nhanvien->getten()."',".$Nhanvien->getgioitinh().",'".$Nhanvien->getngaysinh()."')";
            $this->execdb($sql);
            echo json_encode(array('erro'=>'00','message'=>'insert success !'));
        }
       
    }
    //update 1 obj 
    function update($id){

        $arr_data=$this->convertjsontoarr();
        if(!isset($arr_data['ten'])||!isset($arr_data['ngaysinh'])||!isset($arr_data['gioitinh']))
        {
            echo json_encode(array('erro'=>'04','message'=>'json sai dinh dang mau!'));
            exit();
        }
        else{

            $Nhanvien=new Nhanvien();
            $Nhanvien->urlset($arr_data);
            $sql="update nhanvien set ten='".$Nhanvien->getten()."',ngaysinh='".$Nhanvien->getngaysinh()."',gioitinh=".$Nhanvien->getgioitinh()." where ma=".$id."";
            $this->execdb($sql);
            echo json_encode(array('erro'=>'00','message'=>'update success !'));
        }
       
    }
    //delete 1 obj
    function delete($id){

        // $arr_data=$this->convertjsontoarr();
        // if(!isset($arr_data['ten'])||!isset($arr_data['ngaysinh'])||!isset($arr_data['gioitinh'])||!isset($arr_data['ma']))
        // {
            // echo json_encode(array('erro'=>'04','message'=>'json sai dinh dang mau!'));
            // exit();    
        // }else
        // {  
            $Nhanvien=new Nhanvien();
            $Nhanvien->setma($id);
            $sql="delete from nhanvien  where ma=".$Nhanvien->getma();
            $this->execdb($sql);
            echo json_encode(array('erro'=>'00','message'=>'delete success !'));
            
        // }
        
    }
}
////////////////////////////


//bo ky tu dau trong day


if($_SERVER['REQUEST_METHOD']=="GET")
{   
    $arrstaff=array('nhanvien');
    $path=$_SERVER['PHP_SELF'];
    $arrpath=explode('/', $path);
    if(in_array($arrpath[2],$arrstaff))
    {
          
            if(isset($_GET['name'])&&!empty($_GET['name']))
            {
            $obj=new Model();
            $arrjsondata= json_encode($obj->show($_GET['name']));
            echo $arrjsondata;
            }
            else{
                    echo json_encode(array('erro'=>'05','message'=>"khong co tham so name tren URL !"));
            }
    }else
    {
        echo json_encode(array('erro'=>'06','message'=>"khong co staff tren URL hoac staff khong ton tai !"));  
    }

}elseif($_SERVER['REQUEST_METHOD']=="POST")
{

    $arrstaff=array('nhanvien');
    $path=$_SERVER['PHP_SELF'];
    $arrpath=explode('/', $path);
     if(in_array($arrpath[2],$arrstaff))
    { 
        $obj=new Model();
        $obj->create();
    }else
    {
        echo json_encode(array('erro'=>'06','message'=>"khong co staff tren URL hoac staff khong ton tai !"));  
    }

     
    
}elseif($_SERVER['REQUEST_METHOD']=="PUT")
{
    $arrstaff=array('nhanvien');
    $path=$_SERVER['PHP_SELF'];
    $arrpath=explode('/', $path);
     if(in_array($arrpath[2],$arrstaff))
    { 
        if(!empty($arrpath[3]))
        {
            $check=1 + $arrpath[3];
            if($check>1){

            $obj=new Model();
            $obj->update($arrpath[3]);

            }else{
               echo json_encode(array('erro'=>'07','message'=>"khong ton tai ma dang nay trong csdl !"));
            }    
           
        }else
        {
            echo json_encode(array('erro'=>'06','message'=>"khong co ID tren URL  !"));
        }
    }else
    {
        echo json_encode(array('erro'=>'06','message'=>"khong co staff tren URL hoac staff khong ton tai !"));  
    }

}elseif($_SERVER['REQUEST_METHOD']=="DELETE")
{

    $arrstaff=array('nhanvien');
    $path=$_SERVER['PHP_SELF'];
    $arrpath=explode('/', $path);
     if(in_array($arrpath[2],$arrstaff))
    { 
        if(!empty($arrpath[3]))
        {
            
            $check=1 + $arrpath[3];
             if($check>1){

                $obj=new Model();
                $obj->delete($arrpath[3]);

             }else{
                echo json_encode(array('erro'=>'07','message'=>"khong ton tai ma dang nay trong csdl !"));
             }    
        }else
        {
            echo json_encode(array('erro'=>'06','message'=>"khong co ID tren URL  !"));
        }
    }else
    {
        echo json_encode(array('erro'=>'06','message'=>"khong co staff tren URL hoac staff khong ton tai !"));  
    }

   
}
else{
    echo json_encode(array('erro'=>'07','message'=>"API erro khong do yeu cau !"));
}
?>