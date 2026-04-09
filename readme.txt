Ứng dụng web quản lý chi tiêu có các thành phần cơ bản sau trong mã nguồn:
	Thư mục ExCSS: chứa các file css
	Thư mục ExFunct: Chứa các hàm để và biến để thực hiện các chức năng backend của web
	Thư mục picture chứa các ảnh cần thiết phục vụ cho việc CSS
	Tệp tin login.php chứa mã nguồn thực hiện chức đăng nhập và connect đến database
	Tệp tin query.php chứa mã nguồn thực hiện chức năng xem và thêm
	Tập tin alter.php chứa mã nguồn thực hiện chức năng xóa và update dữ liệu
	Tập tin table.sql chứa model của database
Giải thích code:
	ExCSS:
		format.css:chứa css về việc căn chỉnh kích thước và vị trí của thành phần
		frame.css:chứa các khuôn mẫu cho các khung hiển thị
		hover.css:chứa các hiệu ứng focus vật thể và màu sắc của chúng
		proImg.css:chứa các mẫu về việc hiển thị ảnh nền cho các khung
		text.css:chứa css liên quan đến kí tự

	ExFunct:
		class.php: Chứa mẫu dữ liệu về các thành phần có trong dataBase
			Table là class chung của các bảng gồm 
				name(tên bảng), 
				atb ( mảng chứa các phần tử dưới dạng key=>value để thể hiện dữ liệu ở một atribute nào đó của bảng), 
				cons (mảng chứa tên các attribute bắt buộc phải có dữ liệu), 
				numAtb ( mảng chứa tên các attribute dạng số)
				
				Hàm  __construct có đối số đầu vào là tên bảng, sẽ tạo ra thể hiện mới và đặt tên cho nó
				Hàm  __getClone nhận vào đối số là một mảng có các phần tử là key=>value để lấy đối tượng clone từ đối tượng hiện tại
				Các lớp con khác là thể hiện của các bảng trong dữ liệu, có thể config lại để phù hợp với dữ liệu thực tế
	connection.php:
		selectFromTable nhận vào tên bảng, các trường cần hiển thị, mảng có phần tử key=>[value1,value2] ( ví dụ "id"=>[">",2] ) chứa điều kiện
			hàm trả về một mảng (key1=>value1,key2=>value2,...) là dữ liệu select được, nếu truy vấn thất bại trả về null
		deleteFromTable nhận vào tên bảng và id mẫu tin cần xóa
			hàm trả về giá trị 1 nếu xóa thành công và -1 nếu xóa thất bại
		updateFromTable nhận vào tên bảng, mảng chứa dữ liệu thay đổi có phần tử key=>value và id của mẫu tin cần đổi
			hàm trả về 1 nếu xóa thành công và -1 nếu xóa thất bại
		inserFromTable nhận vào tên bảng và dữ liệu dạng mảng có phần tử key=>value
			hàm trả về chuỗi để thể hiện thêm thành công hay thất bại
		connect_DB nhận vào các chuỗi thể hiện tên loại server, tên user, password, tên database
			hàm trả về chuỗi thể hiện việc kết nối thành công hay thất bại.
	function.php
		showInput nhận vào một đối tượng table để hiển thị các trường nhập liệu
		showRow nhận vào một mảng chứa dữ liệu của một record được thển hiện qua một $talbe->atb tạo ra một form để gửi dữ liệu thực hiện thay đổi hoặc xóa.
		showColumn nhận vào một mảng chứa dữ liệu của một record được thể hiện dưới dạng một $table->atb tạo ra tên các cột của bảng truy vấn
	var.inc
		chứa các biến liên quan đến việc connect

	picture
		Chứa các ảnh cho css

	login.php 
		là tệp tin chứa mã nguồn để người dùng đăng nhập và connect tới database
		nếu đăng nhập thất bại sẽ hiện thông báo
		nếu đăng nhập thành công sẽ chuyển sang query.php để thực hiện truy vấn
	query.php
		phải đăng nhập xong mới thực hiện truy vấn được
		tạo ra các trường nhập liệu dựa trên option mà người dùng select
		người dùng có thể select các mẫu tin của bảng dựa trên mọi option mà họ muốn, đối với các dữ liệu số và ngày thì có các toán tử >,<,=; đối với các dữ liệu dạng chuỗi thì có like, nếu không có điều kiện truy vấn ở trường đó thì chọn none
		việc thêm sẽ được tự dộng gán id nên sẽ không thực hiện việc thêm trên id để tránh những lỗi không mong muốn
		khi có lỗi xảy ra sẽ hiển thị lỗi
		khi người dùng truy vấn thành công sẽ hiển thị ra một trang con mới alter.php để hiển thị các dữ liệu đã được chọn
	alter.php
		phải truy vấn bằng query.php mới có dữ liệu để thao tác
		hiển thị dữ liệu đã được truy vấn cho người dùng thao tác sửa hoặc xóa dữ liệu
		nó sẽ hiển thị có dữ liệu để hiển thị không, hiển thị các thao tác thành công hay thất bại và cập nhật lại dữ liệu hiển thị.

Quy trình thực hiện cơ bản: Login ở login.php->thêm hoặc select dữ liệu ở query.php->xóa hoặc thay đổi dữ liệu ở alter.php
