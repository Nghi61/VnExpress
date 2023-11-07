<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'title' => 'Dàn sao dự tiệc cưới của Gin Tuấn Kiệt, Pu',
                'slug'=>'dan-sao-du-tiec-cuoi-cua-gin-tuan-kiet-pu',
                'image' => 'http://localhost:8000/storage/img/news/mr557pXsozpHcoI8jmBTykdMRJppCRpp3eEzGryv.jpg',
                'description' => 'Trường Giang, Lý Nhã Kỳ cùng nhiều sao dự tiệc cưới bên bờ biển của Gin Tuấn Kiệt, Puka, hôm 4/11.',
                'content' => 'Diễn viên Gin Tuấn Kiệt dắt tay Puka tiến vào sảnh đường lễ cưới tại một resort thuộc bãi biển Cam Ranh, với sự chúc phúc của ca sĩ Tóc Tiên (phải) và hàng chục sao của làng giải trí.
                Video Player is loading.
                Gin Tuấn Kiệt hát tặng vợ, trao lời hẹn ước trong lễ cưới ở bãi biển. Video: Trương Thế Vinh
                Từ trái qua: Trường Giang, Lý Nhã Kỳ, Khánh Vân. Trường Giang vốn là đàn anh thân thiết, chứng kiến cặp sao trưởng thành từ những ngày đầu vào nghề. Anh nhiều lần tác hợp cho Gin Tuấn Kiệt và Puka trước khi cả hai công khai chuyện tình cảm đầu tháng 9.
                Diễn viên Thúy Ngân chọn đầm hở vai màu be - dresscode của tiệc cưới. Cô thân thiết với cô dâu, chú rể qua những lần ghi hình game show chung.
                Ca sĩ Hòa Minzy cùng nhiều đồng nghiệp đến Cam Ranh trước một ngày để dự tiệc độc thân của Gin Tuấn Kiệt, Puka.
                Ninh Dương Lan Ngọc (trái) và Thúy Ngân.
                Vợ chồng diễn viên Lâm Vỹ Dạ, Hứa Minh Đạt. Trong chương trình "Hành trình rực rỡ" hồi tháng 7, Puka, Gin Tuấn Kiệt đóng giả cô dâu, chú rể tái hiện đám cưới phong cách miền Tây, Lâm Vỹ Dạ đóng vai sui gia bên đàng trai.
                Jun Phạm (trái, hàng trên), Minh Dự (trái, hàng dưới) và vợ chồng Thu Trang, Tiến Luật (phải).
                Diễn viên Trương Thế Vinh (trái) tham gia màn hòa giọng cùng chú rể hát tặng cô dâu trước lễ cưới.
                Puka, 34 tuổi, tên thật là Nguyễn Kiều Cẩm Thơ, được biết đến khi tham gia một số vở kịch hài của sân khấu Thế giới trẻ (TP HCM), đóng phim điện ảnh: "Chạy đi rồi tính" (2016), "Yêu đi, đừng sợ" (2017), "Mùa viết tình ca" (2018). Gin Tuấn Kiệt, 29 tuổi, từng học Cao đẳng Văn hóa Nghệ thuật TP HCM. Vai Đức Mẫn trong sit-com "Gia đình là số 1" giúp anh nổi tiếng hơn. Năm 2022, Gin Tuấn Kiệt đoạt danh hiệu Nam diễn viên truyền hình được yêu thích ở giải Ngôi sao xanh với phim "Sui gia hay xui gia".',
                'user_id'=>'1',
                'category_id' => '2',
                'view'=> '0',
            ],
            [
                'title' => 'Arsenal đề nghị Ngoại hạng Anh giải quyết khâu trọng tài',
                'slug'=>'arsenal-de-nghi-ngoai-hang-anh-giai-quyet-khau-trong-tai',
                'image' => 'http://localhost:8000/storage/img/news/N6zBLARkUmox9pcnurcdOKyJsgaOgc2nqgjMtc5v.png',
                'description' => 'Trên trang chủ, Arsenal ủng hộ việc HLV Mikel Arteta nói rằng quyết định của trọng tài ở trận thua Newcastle "ô nhục", và kêu gọi Ngoại hạng Anh sớm xử lý các vấn đề trong khâu điều hành trận đấu.',
                'content' => '"Chúng tôi hết lòng ủng hộ phát biểu của HLV Arteta, sau khi trọng tài và VAR lại mắc thêm những lỗi không thể chấp nhận", thông báo trên trang chủ Arsenal có đoạn. "Ngoại hạng Anh hay nhất thế giới, từ cầu thủ đến HLV và CĐV, và họ xứng đáng với những thứ tốt hơn. Ban trọng tài cần khẩn trương giải quyết các vấn đề về khâu điều hành trận đấu, tránh các phân tích muộn màng, giải thích thừa thãi và những lời xin lỗi".
                Trọng tài Stuart Attwell trong lúc chờ VAR xác định bàn của Newcastle trên sân St James Park, khiến Arsenal thua trận đầu tiên ở Ngoại hạng Anh 2023-2024 ngày 4/11/2023. Ảnh: AFP
                Arsenal viết thêm rằng họ vẫn ủng hộ những nỗ lực của Trưởng Ban trọng tài (PGMOL) Howard Webb, và sẵn sàng làm việc cùng các trọng tài để giúp các trận đấu được điều hành theo đúng tiêu chuẩn của giải.
                Một đội bóng công khai chê trọng tài, qua một bài riêng trên trang chủ, là chuyện hiếm gặp tại giải. Nhưng gần đây Liverpool cũng ra thông báo không chấp nhận lời xin lỗi của trọng tài, sau khi họ nhầm lẫn khi tước bàn hợp lệ của Luis Diaz trong trận gặp Tottenham.
                PGMOL vẫn chưa xin lỗi Arsenal về việc công nhận bàn thắng của Anthony Gordon trên sân St James Park, khiến "Pháo Thủ" thua trận đầu ở Ngoại hạng Anh mùa này. Trang chủ giải cũng dẫn lời cựu trọng tài Dermot Gallagher, cho rằng VAR Andy Madley và trọng tài Stuart Attwell không nghĩ rằng việc công nhận bàn có những sai sót nào rõ ràng khiến họ thay đổi quyết định.
                Trong phát biểu sau trận, HLV Mikel Arteta cho rằng có nhiều hơn một khả năng khiến bàn thắng bị hủy. Ông nhiều lần nhắc đến hai từ "tủi hổ" và "nhục nhã". Những phát biểu tương tự nhắm vào trọng tài thường khiến cho cầu thủ hoặc HLV có nguy cơ bị phạt tiền hoặc kỷ luật. Nhưng đến giờ, ban kỷ luật cũng chưa ra thông báo phạt Arteta.
                Bàn thắng của Gordon được VAR kiểm tra ba khả năng, gồm bóng ra ngoài, Joelinton phạm lỗi với Gabriel Magalhaes và Gordon việt vị. Nhưng sau vài phút, VAR quyết định không can thiệp tình huống. Theo quy định, họ chỉ can thiệp những quyết định mà trọng tài trên sân đã "mắc sai lầm rõ ràng và dễ thấy".
                cho đến khả năng Gordon việt vị trong tình huống dẫn đến bàn thắng của Newcastle. Ảnh: Sky Sports
                VAR kiểm tra để xem liệu Willock đã để bóng ra ngoài đường biên chưa,...
                đến Joelinton có đẩy ngã Gabriel hay không,...
                cho đến khả năng Gordon việt vị trong tình huống dẫn đến bàn thắng của Newcastle. Ảnh: Sky Sports
                VAR kiểm tra để xem liệu Willock đã để bóng ra ngoài đường biên chưa,...
                Điểm đáng tranh luận hơn cả trong ba khả năng này, là việc Joelinton có thể đã đẩy ngã Gabriel. Tuy nhiên trọng tài Attwell cho rằng tác động từ tiền vệ Newcastle chưa đủ để bị thổi phạt. Còn về khả năng bóng ra ngoài, kênh beIN Sports cung cấp góc nhìn cho thấy một phần nhỏ của bóng vẫn còn ở trong sân.
                Sau thất bại 0-1 ở St James Park, Arsenal sẽ trở lại Emirates lần lượt gặp Sevilla tối 8/11 và Burnley ngày 11/11. Nếu bị cấm chỉ đạo, Arteta có nguy cơ vắng mặt trước Burnley.',
                'user_id'=>'1',
                'category_id' => '3',
                'view'=> '0',
            ],
            [
                'title' => '5 thói quen hủy hoại làn da',
                'slug'=>'5-thoi-quen-huy-hoai-lan-da',
                'image' => 'http://localhost:8000/storage/img/news/tKqIXqmp5PLZtdcP79YgSpjcxCUYPw4TfyVURk1u.jpg',
                'description' => 'Hút thuốc lá, ăn nhiều dầu mỡ, rửa mặt bằng nước nóng, mua và dùng thuốc không kê đơn, dùng sai mỹ phẩm có thể hủy hoại làn da.',
                'content' => 'Theo thời gian, làn da dần trở nên mỏng hơn và xuất hiện các nếp nhăn, sạm màu, đồi mồi. Tuy nhiên, có thể làm chậm tình trạng lão hóa sớm bằng cách tránh những thói quen dưới đây, theo ThS.BS Thái Thanh Yến, khoa Da liễu - Thẩm mỹ Da, Bệnh viện Đại học Y Dược TP HCM.
                Hút thuốc lá
                Hút thuốc làm thu hẹp các mạch máu nhỏ ở lớp ngoài cùng, làm giảm lưu lượng máu và khiến da nhợt nhạt hơn. Thuốc lá tàn phá da, làm cho làn da trông già hơn và góp phần tạo ra nếp nhăn.
                Ngoài ra, trong khói thuốc lá có chứa carbon monoxide, nicotine, làm cạn kiệt oxy và các chất dinh dưỡng trong da khiến da loang lổ, khô và sạm màu. Hút thuốc lá cũng làm tổn thương collagen và elastin, góp phần hình thành nếp nhăn sớm và làm tăng nguy cơ ung thư tế bào vảy ở da.
                Ăn nhiều dầu mỡ
                Ăn nhiều dầu mỡ có thể gây mụn và tắc nghẽn lỗ chân lông. Thành phần carbohydrate tinh chế trong thực phẩm sẽ khiến lượng đường trong máu tăng đột biến và kích hoạt sự gia tăng, sản xuất quá mức insulin, dẫn đến sự mất cân bằng nội tiết tố, có thể làm trầm trọng thêm tình trạng mụn và kích ứng.
                Rửa mặt bằng nước nóng
                Sử dụng nước quá nóng để rửa mặt có thể gây hại vì đã lấy đi tất cả loại dầu có trên da và làm mất đi độ ẩm tự nhiên của da.
                Mua và dùng thuốc không kê đơn
                Sử dụng thuốc không kê đơn (OTC) mà không có kiến thức đầy đủ có thể gây hại cho làn da. Mỗi cá nhân có một loại da khác nhau, nếu dùng thuốc theo người khác, không tham khảo ý kiến bác sĩ sẽ không phát huy tác dụng mà còn gây hại cho da.
                Dùng sai mỹ phẩm
                Một sai lầm phổ biến của hầu hết phụ nữ là mua và sử dụng mỹ phẩm sai, chỉ dựa vào giá cả, quảng cáo mà không kiểm tra xem sản phẩm có phù hợp hay không. Nên kiểm tra kỹ lưỡng trước khi mua bất kỳ mỹ phẩm nào để tránh gây hại da.',
                'user_id'=>'1',
                'category_id' => '6',
                'view'=> '0',
            ],
            [
                'title' => 'Quán phở Hà Nội để khách tự nấu trong bát đá 300 độ C',
                'slug'=>'quan-pho-ha-noi-de-khach-tu-nau-trong-bat-da-300-do-c',
                'image' => 'http://localhost:8000/storage/img/news/EQIi4J1oMuwFGAzZ9NpKKWDWFUSzZEYb3WSYZP7q.jpg',
                'description' => 'Thay vì dùng bát sứ, một quán phở sử dụng bát đá đựng nước dùng nóng 300 độ C để thực khách tự nhúng bánh phở, thịt, trứng tại bàn.',
                'content' => 'Nằm ở phố Thái Thịnh (quận Đống Đa), quán phở của chị Chu Phương Linh mới mở được 3 năm nhưng thu hút đông thực khách với món phở bát đá. Để tạo sự khác biệt với những quán phở nổi tiếng, lâu đời tại Hà Nội, chị Linh quyết định sử dụng bát đá thay cho những chiếc bát sứ trắng thông thường. "Bát đá giữ nhiệt tốt hơn, giúp nước dùng còn nóng hổi đến khi thực khách thưởng thức xong và mang đến diện mạo độc đáo cho món phở truyền thống", chị Linh chia sẻ.
                Quán phục vụ hai khung giờ, từ 6h đến 14h và từ 17h đến 21h hằng ngày. Không gian phục vụ khách rộng khoảng 80 m2 với 20 bàn loại dành cho 4 người. Phía sau khu vực phục vụ khách là bếp chế biến.
                Ý tưởng làm phở bát đá được chị Linh lấy cảm hứng từ việc dùng bát đá để giữ ấm đồ ăn của người Hàn Quốc. Bát đá được nhập từ Bình Định, bọc thêm nhôm bên ngoài để không bị nứt và bền hơn khi liên tục chịu nhiệt cao.
                Bát đá được dùng để đựng nước phở ninh từ xương bò trong 12 - 15 tiếng cùng quế, hồi, thảo quả và một số gia vị theo công thức nấu phở gia truyền của gia đình chị Linh. Khi thực khách gọi món, nước dùng được đổ vào các bát đá và nấu trên bếp lửa ở nhiệt độ 200 - 300 độ C trong 7 phút. Sử dụng một chiếc gắp nhôm để nhấc bát đá đặt lên một tấm gỗ lót. Khi bưng ra phục vụ khách, bát nước dùng vẫn còn sôi sục và nghi ngút khói.
                Chị Linh đặt làm bánh phở tráng tay thủ công, không dùng bánh phở được làm công nghiệp. Phở công nghiệp thường bở và khi thả vào nước dùng đang còn nóng sẽ bị nát còn sợi phở tráng tay dày và dai hơn nên không gặp tình trạng này, theo chị Linh.
                Thịt bò tươi được nhập mới hằng ngày từ 5h sáng. Đối với phở bát đá, thịt khi mang ra phục vụ là thịt sống, vì vậy thực khách có thể quan sát được độ tươi, ngon của thịt.
                Các loại nguyên liệu được sơ chế và đựng trong từng khay riêng. Thịt tại quán có các loại bắp, lõi, nạm, gân để thực khách lựa chọn. Làm tới đâu, quán thái thịt tới đó.
                Tuy là phở bát đá, song từ công thức, hương vị đến cách chế biến vẫn mang đặc trưng của món phở Hà Nội gia truyền. Do vậy, các nguyên liệu đều rất quan trọng để tạo nên hương vị và chất lượng món ăn, chị Linh chia sẻ.
                Một suất phở bát đá mang ra phục vụ khách gồm một đĩa bánh phở, một đĩa đựng rau, hành và thịt bò cùng ớt, chanh, một đĩa đồ tráng miệng và một bát đá đựng nước dùng.
                Phở thịt tái, chín, nạm, gầu có giá 50.000 đồng; tái chín, tái gầu, tái nạm, nạm gầu giá 55.000 đồng; thịt bắp, bắp gầu, bắp nạm giá 65.000 đồng, thịt lõi giá 80.000 đồng và bát đặc biệt có đầy đủ các loại thịt giá 90.000 đồng.
                Thưởng thức phở bát đá mang đến trải nghiệm thú vị cho thực khách khi hóa thân thành đầu bếp và tự quyết định khẩu vị, độ chín của các nguyên liệu.
                Thưởng thức phở bát đá có hai cách. Thực khách có thể cho tất cả các nguyên liệu vào bát nước dùng cùng một lúc. Việc thả thịt sớm cũng giúp tạo thêm độ ngọt cho nước dùng.
                Cách thứ hai là ăn đến đâu thêm đồ đến đó, giống với ăn lẩu. Tuy nhiên cách ăn này đòi hỏi thực khách phải căn độ nóng của nước dùng, nếu để nguội khi thả đồ vào sẽ không chín. Thực khách cũng có thể thêm mắm, muối, tương ớt theo khẩu vị riêng.
                Sau khi cho tất cả các nguyên liệu vào, phở bát đá cũng giống các bát phở khác với sợi phở trắng, thịt bò tái hồng và hành lá trên bề mặt. Nước dùng thanh ngọt, nóng hổi làm sợi phở chín, tơi ra và trở nên dai mướt.
                Thịt bò được thái vừa phải, khi nhúng vào nước dùng mềm dần và chuyển màu hồng nhạt, song vị ngọt vẫn được giữ nguyên. Thực khách có thể gọi thêm quẩy giòn để ăn cùng. Bánh phở được phục vụ thêm miễn phí.
                Đến thưởng thức phở bát đá vào sáng 5/11, gia đình chị Nguyễn Thị Thu (quận Ba Đình) đều gọi phở bát đá đặc biệt giá 90.000 đồng một bát, bao gồm tất cả các loại thịt như bắp, gân, nạm. Theo chị Thu, khi phân vân không biết nên chọn gì thì cứ chọn thập cẩm ăn để cảm nhận và chọn ra loại thịt mình thích nhất.
                Điểm cộng của quán là có suất cho trẻ em với mức giá phải chăng 20.000 đồng. Song việc thưởng thức phở bát đá cũng cần cẩn thận bởi bát đá rất nóng, có thể gây bỏng khi sơ ý.
                Thời điểm mới mở bán, chị Linh nhận nhiều ý kiến trái chiều về món phở bát đá. Nhờ sự kiên trì, hiện quán đã có lượng khách ổn định, trong đó có nhiều khách quen, thường xuyên ghé quán.
                Quán phở của chị cũng phục vụ nhiều khách du lịch, đông nhất là khách Hàn Quốc, Trung Quốc vì "sự kết hợp độc đáo giữa món phở truyền thống của Việt Nam và văn hóa ẩm thực sử dụng bát đá của bên họ", chị Linh chia sẻ thêm.
                Trung bình mỗi ngày, chị Linh bán được khoảng 200 - 300 bát. Vào cuối tuần, gần như khung giờ nào cũng có khách đến ăn phở.
                Để được phục vụ nhanh chóng, thực khách nên tránh đến vào khung giờ cao điểm của quán, khoảng 11h30 - 13h và 19 - 20h. Đến đây, ngoài phở bò, thực khách cũng có thể thưởng thức phở dê bát đá, món ăn nhận được nhiều phản ứng tích cực của khách tại quán.',
                'user_id'=>'1',
                'category_id' => '8',
                'view'=> '0',
            ],
            [
                'title' => 'Kim tự tháp cổ nhất thế giới nằm trong lòng núi',
                'slug'=>'kim-tu-thap-co-nhat-the-gioi-nam-trong-long-nui',
                'image' => 'http://localhost:8000/storage/img/news/8NmfBYbIvMwUAia6VRXrsVJJgqawHyHvJRo6KptC.jpg',
                'description' => 'Nghiên cứu mới hé lộ đài tưởng niệm hình nón nhân tạo cổ xưa nhất có thể được xây ở Indonesia từ 25.000 năm trước.',
                'content' => 'Nghiên cứu mới hé lộ đài tưởng niệm hình nón nhân tạo cổ xưa nhất có thể được xây ở Indonesia từ 25.000 năm trước. Mang tên Gunung Padang, trước đây địa điểm này từng bị nhầm với một ngọn đồi tự nhiên. Công tác thực địa cho thấy toàn bộ công trình được xây bởi bàn tay con người qua vài thiên niên kỷ, IFL Science hôm 3/11 đưa tin.
                Nằm ở quận Cianjur, tỉnh Tây Java, Gunung Padang là một tổ hợp đá cự thạch nằm trên sườn núi. Mãi tới năm 2018, các nhà khảo cổ học lần đầu tiên đặt giả thuyết toàn bộ gò đất có thể là công trình nhân tạo và Gunung Padang chứa đựng nhiều hơn ngoài cấu trúc đá dễ thấy nằm trên bề mặt của nó. Kết luận này đến từ một nhóm nhà nghiên cứu liên ngành đã dành 3 năm khảo sát địa điểm từ năm 2011 đến 2014.
                Tuy ban đầu nhiều chuyên gia không tin tưởng, hiện nay nhóm nghiên cứu công bố mô tả chi tiết cuộc điều tra trên tạp chí Archaeological Prospection, cung cấp bằng chứng xác thực chứng minh giả thuyết Gunung Padang là kim tự tháp cổ nhất thế giới. Kết quả xác định niên đại bằng đồng vị carbon với đất hữu cơ lấy từ công trình phản ánh nhiều giai đoạn xây dựng từ hàng nghìn năm trước Công nguyên. Giai đoạn đầu tiên bắt đầu từ thời Đồ đá cũ.
                Sử dụng kỹ thuật đa dạng bao gồm thăm dò điện chiếu trường (ERT), radar xuyên đất (GPR), và địa chấn chiếu sóng (ST), nhóm nghiên cứu có thể phác họa bức tranh hoàn chỉnh về những đặc điểm bên trong ngọn núi cũng như niên đại xây dựng. Lõi khoan ở 7 địa điểm khác nhau hé lộ kim tự tháp được xây theo 4 giai đoạn riêng biệt, trải dài qua hàng nghìn năm.
                Cao 20 - 30 m, công trình bắt đầu với với Cụm 4. Chôn sâu bên trong ngọn núi, giai đoạn đầu tiên nhiều khả năng bắt nguồn dưới dạng một đồi dung nham tự nhiên, được đục đẽo tỉ mỉ thành hình dạng hiện nay cách đây 25.000 - 14.000 năm trước. Cụm 3 bao gồm các cột đá được sắp xếp như gạch trong tòa nhà, xây trong khoảng năm 7.900 - 6100 năm trước Công nguyên. Xấp xỉ khoảng một thiên niên kỷ sau, giữa năm 6000 và 5.500 trước Công nguyên, một thợ xây tới Gunung Padang và xây dựng Cụm 2. Thợ xây cuối cùng tới đây giữa năm 2000 và 1100 trước Công nguyên và xây Cụm 1.
                Nhóm nghiên cứu cũng tìm thấy bằng chứng về "hốc ẩn hoặc phòng chứa bên trong công trình", chúng cần được khám phá chi tiết trong các đợt khảo sát thực địa tương lai. Các nhà nghiên cứu cho biết phát hiện mới thách thức giả thuyết cho rằng kỹ thuật xây dựng phức tạp chỉ được phát triển với sự ra đời của nông nghiệp khoảng 11.000 năm trước.',
                'user_id'=>'1',
                'category_id' => '9',
                'view'=> '0',
            ],
        ];

        foreach ($data as $record) {
            News::create($record);
        }
    }
}
