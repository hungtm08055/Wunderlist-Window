<?php
    ob_start(); // khởi động vùng đệm của server để chứa tạm thời nội dung echo (xuất) vào đó.

    include "../PHPMailer-master/src/Exception.php";
    include "../PHPMailer-master/src/OAuth.php";
    include "../PHPMailer-master/src/PHPMailer.php";
    include "../PHPMailer-master/src/POP3.php";
    include "../PHPMailer-master/src/SMTP.php";
    include "connect.php";
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    session_start();

    $username = $_POST['email'];
    $html = rand(100000,999999); // hàm rand để gửi 1 dãy số trong 6 chữ số

    $mail = new PHPMailer(true);                              // Khai báo đối tượng mail
    try 
    {
        //Server settings
        $mail->SMTPDebug = 2;                                 // Khai báo để biết chi tiết lỗi ntn, nhập số 0 thì sẽ ko xuất hiện lỗi
        $mail->isSMTP();                                      // smtp là server chuyên dùng để gửi gmail
        $mail->Host = 'smtp.gmail.com';                       // truy xuất tới host của gmail
        $mail->SMTPAuth = true;                               // kích hoạt xác thực SMTP 
        $mail->Username = 'tranmanhhung102@gmail.com';        // Gmail mà mình làm host để gửi
        $mail->Password = 'chung2409';                        // Mật khẩu của Gmail 
        $mail->SMTPSecure = 'tls';                            // Kích hoạt mã hóa TLS để bảo mật thông tin truyền(ssl tương tự nhưng ko update nên ít dùng, dc thay thế bởi TLS)
        $mail->Port = 587;                                    // Gmail PORT 587 tương ứng với Host : smtp.gmail.com
    
        //Recipients
        $mail->CharSet = 'UTF-8';
        $mail->setFrom('tranmanhhung102@gmail.com', 'Hùng Trần'); // khi khách hàng nhận mail sẽ biết mail gửi từ đâu
        $mail->addAddress($username, 'Guest');     // Địa chỉ mail khách hàng
        $mail->addReplyTo('tranmanhhung102@gmail.com', 'Infomation'); // khi khách hàng thay đổi sẽ gửi lại về gmail cho mình
        // $mail->addCC('cc@example.com'); đến 1 mail khác
        // $mail->addBCC('bcc@example.com');
    
        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments // bổ sung file hoặc ảnh
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    
        //Content
        $mail->isHTML(true);                                  // đặt format cho email dưới dạng HTML
        $mail->Subject = 'Xác nhận thay đổi mật khẩu';
        $mail->Body = $html."<br>"."<br>"."Mời bạn xác nhận dãy số vừa nhận được để có thể thay đổi mật khẩu theo đường link"."<br>".
        "http://localhost:8080/TechLead_Project_restock/html/resetPassword.php?confirmCode=1";
        $_SESSION['randomNumber'] = $html;
    
        $mail->send();
    } 
    catch (Exception $e)
    {
            echo 'Tin nhắn gửi thất bại ! ', $mail->ErrorInfo;
    }
    
    $thongbao = true;
    header("location:../../html/verify-code.php?confirmEmail=".$thongbao);
    
    ob_end_flush(); // dùng để đưa dữ liệu từ vùng đệm của server về lại phần nội dung.
?>