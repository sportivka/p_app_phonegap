<?php

include 'api.php';

$token = md5("testtest_");
$action = $_GET['act'];

//if (!empty($_GET['token']) )  {
// if ( $_GET['token'] == $token) {

$api = new api;
$link =       $api -> mysql_init('localhost','root','root','test_project');
$array_get =  $api -> ActionApi($_GET);
echo $array_get;

/*
if ($_GET['act'] == "load_point_list") {
   $list_arr_test[0] =  array(
       "id" => "131",
       "company" => "Фабрика",
       "adress" => "Владивосток ,район Луговая ,ул. Светланская, 189",
       "m_bet" => 10,
       "img" => "131.jpg"
);
    $list_arr_test[1] =   array(
        "id" => "312",
        "company" => "Moloko&Mёd",
        "adress" => "Владивосток ,район Центр, ул. Суханова, 6а ",
        "m_bet" =>14,
        "img" => "312.jpg"
);
    $list_arr_test[2] =   array(
        "id" => "322",
        "company" => "Порто-Франко",
        "adress" => "Владивосток ,район Центр, ул. Светланская, 13 ",
        "m_bet" => 11,
        "img" => "322.png"
);
    $list_arr_test[3] =   array(
        "id" => "912",
        "company" => "Мацури",
        "adress" => "Владивосток ,район Цирк-Гайдамак,ул. Светланская, 195а ",
        "m_bet" => 17,
        "img" => "912.jpg"
);
echo json_encode($list_arr_test);
}


if ($_GET['act'] == "load_point_info" && is_numeric($_GET['point_id']) ) {
     $list_arr_test[131] =  array(
       "id" => 131,
       "company" => "Фабрика",
       "adress" => "Владивосток ,район Луговая ,ул. Светланская, 189",
       "m_bet" => 10,
       "desc" => 'Комплекс ФАБРИКА. Ресторан: Каждый день живой звук. Боулинг: 10 дорожек "BRUNSWICK". Бильярд: 13 столов русского бильярда, 7 пула. Служба доставки еды.',
        "hours" => "Вс.-Чт с 12.00 до 2.00 Пт.-Сб. с 12.00 до 4.00 ",
        "geo_lat" => "37.42156911970850",
        "geo_lat" => "37.42156911970850",
        "contacts" =>  "+7(423) 237-02-02",
        "sait" =>"", 
       "img" => "131.jpg"
    );
    $list_arr_test[312] =   array(
        "id" => 312,
        "company" => "Moloko&Mёd",
        "adress" => "Владивосток ,район Центр, ул. Суханова, 6а ",
        "m_bet" =>14,
        "desc" => 'Кафе MOLOKO&MЁD – это место, созданное известным журналистом-путешественником и передовой группой рестораторов города Владивостока. Блюда и напитки, привезенные лично создателями кафе со всех уголков планеты. Гастрономические новинки каждую неделю. Атмосфера уютного дома, где рады каждому гостю.',
        "hours" => "Пн.-Чт., Вс. с 10.00 до 00.00 Пт.-Сб. с 10.00 до 02.00",
        "geo_lat" => "37.42156911970850",
        "geo_lat" => "37.42156911970850",
        "contacts" => "+7(423) 258-90-90 ",
        "sait" =>"http://www.milknhoney.ru", 
        "img" => "312.jpg"
    );
    $list_arr_test[322] =   array(
        "id" => 322,
        "company" => "Порто-Франко",
        "adress" => "Владивосток ,район Центр, ул. Светланская, 13 ",
        "m_bet" => 11,
        "desc" => 'Когда-то, в 1919-1922 гг здесь существовал знаменитый кабачок футуристов “Балаганчик", основанный Давидом Бурлюком, другом Владимира Маяковского. В кабачке любила собираться богема и элита города, известные писатели, поэты, художники музыканты и актеры.',
        "hours" => "Пн.-Чт.,Вс. с 12.00 до 24.00 Пт.-Сб. с 12.00 до 02.00 ",
        "geo_lat" => "37.42156911970850",
        "geo_lat" => "37.42156911970850",
        "contacts" => "+7(423) 241-42-68 </br> +7(423) 270-76-99  ",
        "sait" =>"http://portofrankovl.ru/", 
        "img" => "322.png"
);
    $list_arr_test[912] =   array(
        "id" => 912,
        "company" => "Мацури",
        "adress" => "Владивосток ,район Цирк-Гайдамак,ул. Светланская, 195а ",
        "m_bet" => 17,
        "desc" => 'Семейный ресторан современной азиатской кухни "Мацури".',
        "hours" => "Ежедневно с 12.00 до 01.00  ",
        "geo_lat" => "37.42156911970850",
        "geo_lat" => "37.42156911970850",
        "contacts" => "+7(423) 266-77-03 </br> +7(423) 226-42-42  ",
        "sait" =>"http://www.matsurivl.ru", 
        "img" => "912.jpg"
    );
 
  echo json_encode($list_arr_test[$_GET['point_id']]);
}

if ($_GET['act'] == "get_balance") {
   echo json_encode( array("cur_balance" => rand(1,100),"cur_shot" => rand(1,40)) );
}

if ($_GET['act'] == "check_code" && !(empty($_GET['code'])) && $_GET['code'] == 'XJNDW3') {
   echo json_encode( array("sum" => rand(1,100)));}


}else{ echo json_encode(array("state" => "error"));}}

if ($_GET['act'] == "login_app" && !empty($_GET['login']) && !empty($_GET['password'])) {
$login = $_GET['login'];
$password = $_GET['password'];
if ($login == "sportivka" && $password == "testtest") {
  echo json_encode(array("state" =>"success","token" => $token ) );
}else{
  echo json_encode(array("state" => "error"));
} 
}
*/

?>