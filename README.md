# demo_API
demo_API
 v3: tinh chỉnh code/dung swith,loại bỏ code thừa, đặt lại tên function cho dễ hiểu/code lại khó hiểu hơn v2 :))/ có thể mở rộng thêm staff đơn giản.
1: Tạo table nhanvien(ma,ten,gioitinh,ngaysinh).
	- cho index.php vào thư mục làm việc.
2: Mở POSTMAN để test:
	-get dữ liệu theo ten:GET localhost:8080/nhanvien?name={tencantim}.
	-post dữ liệu để them mới 1 obj vào DB:POST localhost:8080/nhanvien->Body->Row->truyền dãy json theo định dạng sau:
			{
			  	"ten":"long",
			  	"gioitinh":"11",
			  	"ngaysinh":"1998-01-01"
		  	}
			=>send.
	-put dữ liệu update DB:PUT localhost:8080/nhanvien/{manv}->Body->Row->truyền dãy json theo định dạng sau:
			    {
				"ten": "toan",
				"gioitinh": "1",
				"ngaysinh": "1998-01-13"
			    }
			=>send.
	-delete dữ liệu DB theo ma: DELETE localhost:8080/nhanvien/{manv}
			=>send.
	*cac ma erro can luu y: 'erro'=>'01','message'=>'khong ton tai yeu cau json tu clien !'/dành cho  post/put do không có file json truyên vào khi send.
				'erro'=>'02','message'=>'json sai dinh dang !' /dành cho  post/put/ do json bi sai định dang, nhìn lại json mẫu.
				'erro'=>'03','message'=>'khong co object nay trong CSDL'/ dành cho get do không tồn tai/bị xóa obj trong db.
				'erro'=>'04','message'=>'json sai dinh dang mau!'/dành cho post/put do json bi thiếu các trường yêu cầu.
				'erro'=>'05','message'=>"khong co tham so name tren URL !"/ dành cho get do trên URL gửi đi không có biến ?name={tên}
				'erro'=>'06','message'=>"khong co staff tren URL hoac staff khong ton tai !"/dành cho tất cá các method do trên URL không tìm tháy staff vd: /nhanvien/
				'erro'=>'07','message'=>"khong ton tai ma dang nay trong csdl"/dành chodelete/put do {manv} gửi đi sai định dạng không phải number hoặc =0 vd:nhanvien/abc.
				'08','khong co ID tren URL  !'
				'09','Khong do yeu cau API, sai method !'
				'erro'=>'00','message'=>'insert success !'/ insert thành công 1 obj vào csdl.
				'erro'=>'00','message'=>'update success !'/update thành công 1 obj vào csdl.
				'erro'=>'00','message'=>'delete success !'/delete thành công 1 phần tử trong csdl.
				



