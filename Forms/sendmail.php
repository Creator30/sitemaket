<?php
    use PHPmailer\PHPMailer\PHPMailer;
    use PHPmailer\PHPMailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';

    $mail = new PHPMailer(true);
    $mail->CharSet = 'UNF-8';
    $mail -> setLanguage('ru', 'phpmailer/language');
    $mail-> IsHTML(true);

    //От кого письмо
    $mail->setFrom('yarikkhrebto@gmail.com', 'Ярослав Хребто');
    //Кому отправить
    $mail->addAdress('ksenialamanova64@gmail.com');
    //Тема письма
    $mail->Subject ='Привет!';

    //Рука
    $hand="Правая";
    if($_POST['hand'] == "left"){
        $hand = "Левая";
    }

    //Тело письма
    $body = '<h1>Это супер письмо!</h1>';

    if(trim!empty($_POST['name']))){
        $body.= '<p><strong>Имя:</strong>' .$_POST['name'].'</p>';
    }
    if(trim!empty($_POST['email']))){
        $body.= '<p><strong>E-mail:</strong>' .$_POST['email'].'</p>';
    }
    if(trim!empty($_POST['hand']))){
        $body.= '<p><strong>Рука:</strong>' .$hand['name'].'</p>';
    }
    if(trim!empty($_POST['age']))){
        $body.= '<p><strong>Возраст:</strong>' .$_POST['age'].'</p>';
    }
    if(trim!empty($_POST['message']))){
        $body.= '<p><strong>Сообщение:</strong>' .$_POST['message'].'</p>';
    }
    
    //Прикрепить файл
    if(!empty($_FILES['image']['tmp_name'])){
        //путь загрузки файла
        $filePath = __DIR__ . "files/" . $_FILES['image']['name'];
        //грузим файл
        if(copy($_FILES['image']['tmp_name'], $filePath)){
            $fileAttach =$filePath;
            $body.='<p><strong>Фото в приложении к письму</strong>';
            $mail->addAttachment($fileAttach);
        }
    }

    $mail->Body =$body;

    //Отправляем
    if(!$mail->seend()){
        $message = 'Ошибка';

    }else{
        $message= 'Данные отправлены!';
    }
    $response = ['message'=>$mesage];

    header('Content-type:application/json');
    echo json_encode($response);
    ?>