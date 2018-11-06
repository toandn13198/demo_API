# demo_API
demo_API

1: Mở POSTMAN để test:
	-get dữ liệu theo ten:GET localhost:8080/index.php/nhanvien?name={tencantim}.
	-post dữ liệu để them mới 1 obj vào DB:POST localhost:8080/index.php/nhanvien->Body->Row->truyền dãy json theo định dạng sau:
			{
			  	"ten":"long",
			  	"gioitinh":"11",
			  	"ngaysinh":"1998-01-01"
		  	}
			=>send.
	-put dữ liệu update DB:PUT localhost:8080/index.php/nhanvien/{manv}->Body->Row->truyền dãy json theo định dạng sau:
			
			    {
				"ten": "toan",
				"gioitinh": "1",
				"ngaysinh": "1998-01-13"
			    }
			=>send.
	-delete dữ liệu DB theo ma: DELETE localhost:8080/index.php/nhanvien/{manv}
			=>send.

	-cac ma erro can luu y: 'erro'=>'01','message'=>'khong ton tai yeu cau json tu clien !'/dành cho  post/put do không có file json truyên vào khi send.
				'erro'=>'02','message'=>'json sai dinh dang !' /dành cho  post/put/ do json bi sai định dang, nhìn lại json mẫu.
				'erro'=>'03','message'=>'khong co object nay trong CSDL'/ dành cho get do không tồn tai/bị xóa obj trong db.
				'erro'=>'04','message'=>'json sai dinh dang mau!'/dành cho post/put do json bi thiếu các trường yêu cầu.
				'erro'=>'05','message'=>"khong co tham so name tren URL !"/ dành cho get do trên URL gửi đi không có biến ?name={tên}
				'erro'=>'06','message'=>"khong co staff tren URL hoac staff khong ton tai !"/dành cho tất cá các method do trên URL không tìm tháy staff vd: /nhanvien/
				'erro'=>'07','message'=>"khong ton tai ma dang nay trong csdl"/dành chodelete/put do {manv} gửi đi sai định dạng không phải number hoặc =0 vd:nhanvien/abc.
lưu ý: nếu đã chỉnh chỏ thẳng vào index.php thì URL:localhost:8080/nhanvien/... cần chỉnh lại $arrpath,va các $arrpath[]  để các biến phù hợp không sẽ bị lỗi.


