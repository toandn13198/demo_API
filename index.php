<?php 
////////////////////////////////Nhân vien và các phương thức, thuộc tính liên quan.
class Nhanvien
{
    private $ma;
    private $ten;
    private $ngaysinh;
    private $gioitinh;

    function setten($ten){
        $this->ten = $ten;
    }
    function getten(){
        return $this->ten;
    }
     function setngaysinh($ngaysinh){
        $this->ngaysinh = $ngaysinh;
    }
   function getngaysinh(){
        return $this->ngaysinh;
    }
     function setgioitinh($gioitinh){
        $this->gioitinh= $gioitinh;
    }
     function getgioitinh(){
        return $this->gioitinh;
    }
     function setma($ma){
        $this->ma= $ma;
    }
     function getma(){
        return $this->ma;
    }
    function set_all($arr_data){
        $this->setma($arr_data['ma']);
        $this->setten($arr_data['ten']);
        $this->setngaysinh($arr_data['ngaysinh']);
        $this->setgioitinh($arr_data['gioitinh']);
    }
    function show_nhanvien_db_name($name){
        $sql="select *from nhanvien where ten='".$name."'";
        $model=new Model();
        $arr_obj=$model->get_db($sql);
        $arr_json=array();
        foreach($arr_obj as $key => $row)
        {
            $arr_json[$key]['ma']=$row['ma'];
            $arr_json[$key]['ten']=$row['ten'];
            $arr_json[$key]['gioitinh']=$row['gioitinh'];
            $arr_json[$key]['ngaysinh']=$row['ngaysinh'];       
        }
        $model->show($arr_json);  
    }
    function create_nhanvien_db_json(){
        $model=new Model();
        $Nhanvien=new Nhanvien();
        $arr_data=$model->convert_json_toarr();
        if(!isset($arr_data['ten'])||!isset($arr_data['ngaysinh'])||!isset($arr_data['gioitinh']))
        {
            $model->repon_message('04','json sai dinh dang mau!');
        }
        else{
            $Nhanvien->set_all($arr_data);
            $sql="insert into nhanvien(ten,gioitinh,ngaysinh) values('".$Nhanvien->getten()."',".$Nhanvien->getgioitinh().",'".$Nhanvien->getngaysinh()."')";
            $model->crud($sql,'insert sucess !'); 
        }      
    }
    function update_nhanvien_db_json($id){
            $model=new Model();
            $Nhanvien=new Nhanvien();
            $arr_data=$model->convert_json_toarr();
            if(!isset($arr_data['ten'])||!isset($arr_data['ngaysinh'])||!isset($arr_data['gioitinh']))
            {
                $model->repon_message('04','json sai dinh dang mau!');
            }
            else{
                $Nhanvien->set_all($arr_data);
                $Nhanvien->setma($id);
                $sql="update nhanvien set ten='".$Nhanvien->getten()."',ngaysinh='".$Nhanvien->getngaysinh()."',gioitinh=".$Nhanvien->getgioitinh()." where ma=".$Nhanvien->getma()."";
                $model->crud($sql,'update success !');
            }
    }
    function delete_nhanvien_db($id){
        $Nhanvien=new Nhanvien();
        $Nhanvien->setma($id);
        $id1=$Nhanvien->getma();
        $model=new Model();
        $sql="delete from nhanvien  where ma=".$Nhanvien->getma();
        $model->crud($sql,'delete sucess !');

    }
}
//////////////////////class DB ket noi CSDL
class DB{ 
    private $nameserver="mysql";
    private $db="my_db";
    private $username="root";
    private $pass="root";

    public function get_db($sql)
    { 
        try {
            $con=new PDO("mysql:host=$this->nameserver;dbname=$this->db","$this->username","$this->pass");
            $resul=$con->query($sql);
            $con=null;
            return $resul;
            }
        catch(PDOException $e)
            {
            echo "Connection failed: " . $e->getMessage();
            exit();
            }
    }
    function execdb($sql){ 
        try {
                $con=new PDO("mysql:host=$this->nameserver;dbname=$this->db","$this->username","$this->pass");
                $con->exec($sql);
                $con=null;
            }
        catch(PDOException $e)
            {
                echo "Connection failed: " . $e->getMessage();
            }
    }
}

//// class model//////////////////////////////////////////////////////////////////////////
class Model extends DB{
    function convert_json_toarr()
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
                $this->repon_message('02','json sai dinh dang !');
            }
            else{
                return $arr_data;
            } 
        }     
    }
    function repon_message($erro,$message){
        echo json_encode(array('erro'=>$erro,'message'=>$message));
        exit();
    } 
    function show($arr_json){
        if(empty($arr_json))
        {
            $this->repon_message('03','khong co object nay trong CSDL');
        }
        else{
            echo json_encode($arr_json);
        }
    }
    function crud($sql,$message){thay doi cau truc thuc thi thanh swith
            $this->execdb($sql);thay doi cau truc thuc thi thanh swith
            $this->repon_message('0thay doi cau truc thuc thi thanh swith0',$message); 
    }
}

//Thực thi toàn bộ code.
$path=ltrim($_SERVER['REQUEST_URI'],"/");
switch($_SERVER['REQUEST_METHOD']){
    case "GET":  
                $arr_path=explode('?', $path);
                if($arr_path[0]=='nhanvien')
                { 
                        if(isset($_GET['name'])&&!empty($_GET['name']))
                        {
                            Nhanvien::show_nhanvien_db_name($_GET['name']);
                        }
                        else{
                            Model::repon_message('05','khong co tham so name tren URL !');
                        }
                }else
                {
                    Model::repon_message('06','khong co staff tren URL hoac staff khong ton tai !');
                }
                break;
    case "POST": //create 1 obj mới vào csdl
                if($path=='nhanvien')
                { 
                   Nhanvien::create_nhanvien_db_json();
                }else
                {
                    Model::repon_message('06','khong co staff tren URL hoac staff khong ton tai !');  
                }
                break;
    case "PUT":
                $arr_path=explode('/',$path);
                if($arr_path[0]=='nhanvien')
                {  
                    if(!empty($arr_path[1]))
                    {
                        $check=1 + $arr_path[1];
                        if($check>1)
                        {     
                            Nhanvien::update_nhanvien_db_json($arr_path[1]);
                        }else{
                            Model::repon_message('07','khong ton tai ma dang nay trong CSDL !');
                        }    
                    }else
                    {
                        Model::repon_message('08','khong co ID tren URL  !');
                    } 
                }else
                {
                    Model::repon_message('06','khong co staff tren URL hoac staff khong ton tai !');   
                }
                break;
    case "DELETE":       
                $arr_path=explode('/',$path);
                if($arr_path[0]=='nhanvien')
                { 
                    if(!empty($arr_path[1]))
                    { 
                        $check=1 + $arr_path[1];
                        if($check>1){
                            Nhanvien::delete_nhanvien_db($arr_path[1]);
                        }else{
                            Model::repon_message('07','khong ton tai ma dang nay trong CSDL !');
                        }    
                    }else
                    {
                        Model::repon_message('08','khong co ID tren URL  !');
                    }
                }else
                {
                    Model::repon_message('06','khong co staff tren URL hoac staff khong ton tai !');  
                }   
                break;            
    default: 
            Model::repon_message('09','Khong do yeu cau API, sai method !');
}
?>