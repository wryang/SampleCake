<?php

class SampleController extends Controller
{
    /**
     * Declares class-based actions.
     * 
     */
    
    //public $layout = "//layout/main";
    
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model=new ContactForm;
        if(isset($_POST['ContactForm']))
        {
            $model->attributes=$_POST['ContactForm'];
            if($model->validate())
            {
                $headers="From: {$model->email}\r\nReply-To: {$model->email}";
                mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
                Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact',array('model'=>$model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model=new LoginForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login',array('model'=>$model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionLoadProductBox()
    {
        if(isset($_POST['year']) && isset($_POST['month']) && isset($_POST['day'])) {
            $year = $_POST['year'];
            $month = $_POST['month'];
            $day = $_POST['day'];

            $timestamp = array("year"=>$year, "month"=>$month, "day"=>$day);
            echo $this->renderPartial('productBox', array("timestamp"=>$timestamp), true);
            //echo json_encode($timestamp);
            return;
        }else {
            $month = "3";
            $day = "1";
            $year = "2012";
        
            $timestamp = array('day'=>$day, 'month'=>$month, 'year'=>$year);
            $this->renderPartial('productBox', array('timestamp'=>$timestamp));
        }

    }

    public function actionLoadCakeDetail()
    {
        //$json = array('name'=>'y');
        // $view = $this->render("jhhf", true);
        // echo json_encode($json);
        $productID = $_GET['id'];
        $date = $_GET['date'];
        $month = $_GET['month'];
        $year = $_GET['year'];
        $timestamp = $year."-".$month."-".$date;
        //$purchaseable = $_GET['purchaseable'];

        // $productID = 9;
        $sql = "SELECT * FROM `product` WHERE id=$productID";
        $product = Product::model()->findBySql($sql);
        $sql = "SELECT * FROM `sales` WHERE pid=".$productID." AND timestamp='".$year."-".$month."-".$date."'";
        $object = Sales::model()->findBySql($sql);

        $count = 0;
        $purchaseBtns = "(还未上架)";
        if($object){
            $count = $object->count;
            $purchaseBtns = '<img class="button" src="/sampleCake/images/reservationBtn.png" id="reservationBtn"/>' ;

            //查询今日是否可购买
            $thistime = date('Y-m-d');
            $sql = "SELECT * FROM `sales` WHERE pid=".$productID." AND timestamp='".$thistime."'";
            $isToday = Sales::model()->findBySql($sql);
            if (!Yii::app()->user->isGuest) {
                $identity = Yii::app()->user->identity;
            }
            

            /*if('true' == $purchaseable){
                $purchaseBtns ='<img class="button" src="/sampleCake/images/purchaseBtn.png" id="purchaseBtn"/><img class="button" src="/sampleCake/images/reservationBtn.png" id="reservationBtn"/>';*/
            if($isToday){
                if (!Yii::app()->user->isGuest) {
                    $identity = Yii::app()->user->identity;
                    if(0==$identity || 2==$identity){
                        $purchaseBtns ='<img class="button" src="/sampleCake/images/purchaseBtn.png" id="purchaseBtn"/><img class="button" src="/sampleCake/images/reservationBtn.png" id="reservationBtn"/>';
                    }
                }
            }
        }

        
        

        $productInfo = array('id'=>$product->id, 'name'=>$product->name, 'price'=>$product->price,
            'description'=>$product->description, 'imgurl'=>$product->imgurl, 'count'=>$count, 'purchaseBtns'=>$purchaseBtns);
        //echo json_encode($productInfo);
        $this->render('cakeDetail', array('productInfo'=>$productInfo));
    }

    public function actionLoadHot()
    {
        $date = $_POST['date'];
        $month = $_POST['month'];
        $year = $_POST['year'];
        $thistime = $year.'-'.$month.'-'.$date;

      //  echo $date;$thistime = date("Y-m-d");
        // $thistime = date("Y-m-d");
        // $sql = 'SELECT * FROM `order` WHERE timestamp="'.$thistime.'" order by count DESC limit 0, 5';
        $sql = "SELECT pid, sum( count ) AS total\n"
                . "FROM (\n"
                . "SELECT pid, count\n"
                . "FROM `order`\n"
                . "WHERE timestamp = '".$thistime
                . "') sta\n"
                . "GROUP BY pid\n"
                . "ORDER BY total DESC limit 0, 5";
        $orders = Order::model()->findAllBySql($sql);

        $array = array();
        $index = 0;



        foreach($orders as $order){
            $hotPro = $order->p;
            $array[$index]['name'] = $hotPro->name;
            $array[$index]['id'] = $hotPro->id;
            $array[$index]['imgurl'] = $hotPro->imgurl;
            $index++;
        }

        echo json_encode($array);
    }

    public function actionLoadProductsByDate()
    {
        $date = $_POST['date'];
        $month = $_POST['month'];
        $year = $_POST['year'];
        $startIndex = $_POST['startIndex'];
        $endIndex = $_POST['endIndex'];


        $sql = "SELECT * FROM `sales` WHERE timestamp='".$year."-".$month."-".$date."' limit ".$startIndex.",".$endIndex;
        $products = Sales::model()->findAllBySql($sql);

        $result = array();

        if($products){
            $index = 0;
            foreach($products as $product){
                $pid = $product->pid;
                $result[$index]['id'] = $pid;
                $sql = "SELECT imgurl FROM `product` WHERE id=".$pid;
                $imgUrl = Product::model()->findBySql($sql)->imgurl;
                $result[$index]['imgurl'] = $imgUrl;
                /*if(!Yii::app()->user->isGuest)
                {
                    $result[$index]['identity'] = Yii::app()->user->identity;
                }*/
                
                $index++;
            }

            echo json_encode($result);
        }else{
            $result = true;
            echo $result;
        }
    }

    public function actionPurchaseByPid()
    {
        $pid = $_POST['productID'];
        $timestamp = $_POST['date'];
        $orderCount = $_POST['orderCount'];
        $membershipCard = $_POST['membershipCard'];
        $optionState = $_POST['optionState'];
        /*$day = $_POST['day'];
        $month = $_POST['month'];
        $year = $_POST['year'];*/
        
        /*$pid = 19;
        $day = 3;
        $month = 3;
        $year = 2012;
        $orderCount = 3;*/


        // $uid = Yii::app()->user->id;
        // $timestamp = $year."-".$month."-".$day;

        //计算订单需要多少钱
        $sql = "SELECT price FROM `product` WHERE id=".$pid;
        $price = Product::model()->findBySql($sql)->price;
        $totalprice = $price * $orderCount;
        //查看该产品还有多少可以销售
        $sql = "SELECT * FROM `sales` WHERE pid=".$pid." AND timestamp='".$timestamp."'";
        $sale = Sales::model()->findBySql($sql);
        $pCount = $sale->count;
        //判断会员卡中是否有钱
        $result = array();
        $result['succeed'] = false;

        $sql = "SELECT * FROM `membership_card` WHERE cardnumber=".$membershipCard;
        $membershipCardInfo = MembershipCard::model()->findBySql($sql);
        
        
        //if(accurate)
        $uid = Yii::app()->user->id;
        $identity = Yii::app()->user->identity;
        if($membershipCardInfo && ($uid == $membershipCardInfo->uid || 1 != $identity)){
            $result['hasMembershipCard'] = true;

            if("1" == $membershipCardInfo->state){
                $result['mCardState'] = true;
                //根据会员累计消费的多少来判断减价的多少
            $accumulated = $membershipCardInfo->accumulated;
            if($accumulated > 200){
                if($accumulated > 500){
                    if($accumulated > 1000){
                        $totalprice *= 0.85;
                    }else{
                        $totalprice *= 0.9;
                    }
                }else{
                    $totalprice *= 0.95;
                }
            }
            if($orderCount <= $pCount){
                $result['hasEnoughProducts'] = true;
                $balance = $membershipCardInfo->balance;
                if($balance >= $totalprice){
                    $result['hasEnoughAccount'] = true;
                    //会员卡存在，商品足够，且账户余额足够，则可购买

                    //减少sale中的销售数量
                    // $sql = "SELECT id FROM `sales` WHERE pid=".$pid." AND timestamp='".$date."'";
                    // $sale = Sales::model()->findBySql($sql)->id;
                    // $count = $sale->count;
                    $sid = $sale->id;
                    $pCount = $pCount - $orderCount;
                    //$sql = "UPDATE `sales` SET count=".$count." WHERE id=".$sid;
                    $sale->count = $pCount;
                    $sale->save();

                    //减少账户余额
                    $balance = $balance - $totalprice;
                    $membershipCardInfo->balance = $balance;
                    
                    $accumulated += $totalprice;
                    $membershipCardInfo->accumulated = $accumulated;
                    $membershipCardInfo->save();

                    //存入订单
                    // $sql = "INSERT INTO `order`( `pid`, `uid`, `count`, `timestamp`) VALUES (".$pid.",".$uid.",".$orderCount.",".$timestamp.")";
                    //Order::model()->INSERT(array $)
                    $uid = $membershipCardInfo->uid;
                    $newOrder = new Order;
                    $newOrder->pid = $pid;
                    $newOrder->uid = $uid;
                    $newOrder->count = $orderCount;
                    $newOrder->timestamp = $timestamp;
                    $newOrder->amount = $totalprice;
                    $newOrder->cardnumber = $membershipCard;
                    //如若是管理员或店员（即为购买行为），则将订单状态转换为完结
                    $identity = Yii::app()->user->identity;
                    // if(0 == $identity || 2 == $identity){
                    //     $newOrder->state = true;
                    // }
                    // if(1 == $identity){
                    //     $newOrder->state = false;
                    // }else{
                        $newOrder->state = $optionState;
                    // }

                    if($newOrder->save())
                        $result['succeed'] = true;
                }else{
                //会员账户余额不足
                    $result['hasEnoughAccount'] = false;
                }
            }else{
                //该产品库存不足
                $result['hasEnoughProducts'] = false;
            }
        }else{
            $result['mCardState'] = false;
        }
            
            
        }else{
            //会员卡不存在
            $result['hasMembershipCard'] = false;
        }

        echo json_encode($result);
    }

    public function actionIsGuest()
    {
        $isguest = Yii::app()->user->isGuest;
        $result = array();
        $result['isguest'] = $isguest;
        if(!$isguest){
            $result['username'] = Yii::app()->user->name;
            $result['uid'] = Yii::app()->user->id;
            $result['identity'] =  Yii::app()->user->identity;
        }
        echo json_encode($result);
    }

    public function actionGetMembershipCards()
    {
        $identity = Yii::app()->user->identity;
        if(1 == $identity){
            $uid = Yii::app()->user->id;
            $sql = "SELECT cardnumber FROM `membership_card` WHERE uid=".$uid;
            $cardnumbers = MembershipCard::model()->findAllBySql($sql);

            $result = array();
            //如若该会员有会员卡
            if($cardnumbers){
                foreach ($cardnumbers as $cardnumber) {
                    $result[]=$cardnumber->cardnumber;
                }
            }

            echo json_encode($result);

        }
    }

    public function actionGetRerservableDate()
    {
        $pid = $_POST['productID'];
        $thistime = date("Y-m-d");

        $sql = "SELECT timestamp FROM `sales` WHERE timestamp>='".$thistime."' AND pid=".$pid;
        $timestamps = Sales::model()->findAllBySql($sql);

        $result = array();
        if($timestamps){
            foreach ($timestamps as $timestamp) {
                    $result[]=$timestamp->timestamp;
            }
        }

        echo json_encode($result);
    }

    public function actionTurnToManage()
    {
        $this->render('manageMembers');
    }

    public function actionShowByType(){
        $typeID = $_GET['typeID'];
        //$typeID = 2;
        //$this->render('showByType', array('typeID'=>$typeID), true);
        $sql = 'SELECT COUNT(id) FROM product WHERE tid='.$typeID;
        $pageCount = Product::model()->countBySql($sql);
        $this->render('showByType', array('typeID'=>$typeID , 'pageCount'=>$pageCount));
        //$this->render('cakeDetail', array('typeID'=>$typeID));
    }

    public function actionGetPagination()
    {
        $timestamp = $_POST['timestamp'];
        //$timestamp ='2012-03-05';
        $sql = "SELECT COUNT(pid) AS PAGE FROM sales WHERE timestamp='".$timestamp."'";
        $pageCount = Sales::model()->countBySql($sql);
        echo $pageCount;
    }

    public function actionGetProductsByType()
    {
        $typeID = $_POST['typeID'];
        $startIndex = $_POST['startIndex'];
        $endIndex = $_POST['endIndex'];

        $sql = "SELECT * FROM `product` WHERE tid=".$typeID." limit ".$startIndex.", ".$endIndex;
        $products = Product::model()->findAllBySql($sql);

        if($products){
            $result = array();
            $i = 0;
            foreach ($products as $product) {
                $result[$i]['pname'] = $product->name;
                $result[$i]['id'] =  $product->id;
                $result[$i]['imgurl'] = $product->imgurl; 
                $i++;
            }
            echo json_encode($result);
        }else{
            $result = false;
            echo $result;
        }
        
    }

    public function actionManageMember(){
        $this->render('manageMemCards');
    }

    public function actionBindingMCard(){
        $username = $_POST['username'];
        $mCard = $_POST['mCard'];
        /*$gender = $_POST['gender'];
        $birthday = $_POST['birthday'];*/

        $result = array();

        $sql = "SELECT * FROM user WHERE name='".$username."'";
        $user = User::model()->findBySql($sql);

        if($user){
            $result['hasUsername'] = true;
            $sql = 'SELECT id FROM membership_card WHERE cardnumber='.$mCard;
            if(MembershipCard::model()->findBySql($sql)){
                $result['cardError'] = true;
            }else{
                $result['cardError'] = false;
                $deadline = mktime(0,0,0,date("m"),date("d"),date("Y")+1);
                $membershipCard = new MembershipCard;
                $membershipCard->uid = $user->id;
                $membershipCard->deadline = date("Y-m-d", $deadline);
                $membershipCard->cardnumber = $mCard;
                $membershipCard->save();
            }
        }else{
            $result['hasUsername'] = false;
        }

        echo json_encode($result);
    }

    public function actionRecharge(){
        $mCard = $_POST['mCard'];
        $amount = $_POST['amount'];

        $sql = "SELECT * FROM `membership_card` WHERE cardnumber=".$mCard;
        $membershipCard = MembershipCard::model()->findBySql($sql);

        $result = array();
        if($membershipCard){
            $result['hasMembershipCard'] = true;
            $balance = $membershipCard->balance;
            $balance += $amount;

            $membershipCard->balance = $balance;

            //充值100以上激活会员卡
            if(!$membershipCard->state && $amount >= 100){
                $membershipCard->state = true;
                $deadline = mktime(0,0,0,date("m"),date("d"),date("Y")+1);
                $membershipCard->deadline = date("Y-m-d", $deadline);
            }

            $membershipCard->save();
        }else{
            $result['hasMembershipCard'] = false;
        }

        echo json_encode($result);
    }

    public function actionAddUser(){
        $username = $_POST['username'];
        $identity = $_POST['identity'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $birthday = $_POST['birthday'];
        $password = $_POST['password'];
        /*$username = "new";
        $identity = 1;
        $gender = 1;
        $address = "玄武区";
        $birthday = "";*/

        $sql = "SELECT id FROM user WHERE name='".$username."'";
        $user = User::model()->findBySql($sql);

        $result = array();
        $result['UsernameError'] = true;
        if(!$user){
            //该用户名不存在
            
            $newUser = new User;
            $newUser->name = $username;
            $newUser->authority = $identity;
            $newUser->gender = $gender;
            if("" == $address){
                $newUser->address = "玄武区";
            }else{
                $newUser->address = $address;
            }
            
            if("" == $birthday){
                $newUser->birthday = date('Y')."-".date("m")."-".date('d');
            }else{
                $newUser->birthday = $birthday;
            }

            if("" != $password){
                $newUser->password = $password;
            }
            $newUser->save();
            $result['UsernameError'] = false;
        }

        echo json_encode($result);
    }

    public function actionGetMCardState(){
        $mCard = $_POST['mCard'];
        // $mCard = '05';
        $sql = "SELECT * FROM membership_card WHERE cardnumber=".$mCard;
        $membershipCard = MembershipCard::model()->findBySql($sql);

        $result = array();
        //该会员卡不存在
        $result['mCardError'] = true;  
        if($membershipCard){
            $result['mCardError'] = false;
            $state = $membershipCard->state;
            if("0" == $state){
                $state = false;
            }else if("1" == $state){
                $state = true;
            }
            $result['state'] = $state;
        }
        echo json_encode($result);
    }

    public function actionCheckMCard(){
        $deadline = date("Y-m-d");
        $sql = "SELECT * FROM `membership_card` WHERE deadline<'".$deadline."'";
        $mCards = MembershipCard::model()->findAllBySql($sql);

        foreach ($mCards as $mCard) {
            $mCard->state = 0;
            $mCard->save();
        };
    }

    public function actionManagePersonalInfo(){
        $this->render('personalInfo');
    }

    public function actionUpdatePersonalInfo(){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $birthday = $_POST['birthday'];

        /*$uid = Yii::app()->user->id;
        $sql = "SELECT * FROM user WHERE id='".$uid."'";
        $user = User::model()->findBySql($sql);*/

        $sql = "SELECT id FROM user WHERE name='".$username."'";
        $hasuser = User::model()->findBySql($sql);

        $uid = Yii::app()->user->id;

        $result = array();
        $result['UsernameError'] = true;
        if($uid == $hasuser->id){
            //该用户名不存在
            $sql = "SELECT * FROM user WHERE id='".$uid."'";
            $user = User::model()->findBySql($sql);

            $user->name = $username;
            $user->password = $password;
            $user->gender = $gender;
            $user->address = $address;
            if("" != $birthday){
                $user->birthday = $birthday;
            }
            $user->save();
            $result['UsernameError'] = false;
        }
        echo json_encode($result);
    }

    public function actionGetPersonalInfo(){
        $uid = Yii::app()->user->id;
        $sql = "SELECT * FROM user WHERE id='".$uid."'";
        $user = User::model()->findBySql($sql);

        $personalInfo = array();
        if($user){
            $personalInfo['username'] = $user->name;
            $personalInfo['password'] = $user->password;
            $personalInfo['gender'] = $user->gender;
            $personalInfo['birthday'] = $user->birthday;
            $personalInfo['address'] = $user->address;
        }

        echo json_encode($personalInfo);
    }

    public function actionGetPersonalOrders(){
        $uid = Yii::app()->user->id;
        // echo "(".$uid.")";
        $sql = "SELECT * FROM `order` WHERE uid= ".$uid;
        // $sql = "SELECT * FROM `order` WHERE uid=5";
        $orders = Order::model()->findAllBySql($sql);

        $result = array();
        $index = 0;
        foreach ($orders as $order) {
            $result[$index]['oid'] = $order->id;
            
            $pid = $order->pid;
            $sql = "SELECT * FROM product WHERE id=".$pid;
            $product = Product::model()->findBySql($sql);
            $result[$index]['productName'] = $product->name;
            $result[$index]['productPrice'] = $product->price;
            $result[$index]['count'] = $order->count;
            $result[$index]['amount'] = $order->amount;
            $result[$index]['timestamp'] = $order->timestamp;
            $result[$index]['state'] = $order->state;
            $index++;
        }

        echo json_encode($result);
    }

    public function actionGetPersonalCards(){
        $uid = Yii::app()->user->id;
        $sql = "SELECT * FROM `membership_card` WHERE uid= ".$uid; 
        $cards = MembershipCard::model()->findAllBySql($sql);

        $result = array();
        $index = 0;

        foreach ($cards as $card) {
             $result[$index]['cardnumber'] = $card->cardnumber;
             $result[$index]['balance'] = $card->balance;
             $result[$index]['state'] = $card->state;
             $result[$index]['deadline'] = $card->deadline;
             $accumulated = $card->accumulated;
             $level = "普通会员";
             if($accumulated>200){
                if($accumulated > 500){
                    if($accumulated > 1000){
                        $level = "钻石会员";
                    }else{
                        $level = "金卡会员";
                    }
                }else{
                    $level = "高级会员";
                }
             }
             $result[$index]['accumulated'] = $accumulated;
             // echo "(".$accumulated.")";
             $result[$index]['level'] = $level;
             $index++;
         } 

         echo json_encode($result);
    }

    public function actionManageSales(){
        $this->render('manageSales');
    }

    public function actionAddProduct(){
        $productName = $_POST['productName'];
        $productPrice = $_POST['productPrice'];
        $productImg = $_POST['productImg'];
        $productType = $_POST['productType'];
        $description = $_POST['description'];

        $newProduct = new Product;
        $newProduct->name = $productName;
        $newProduct->price = $productPrice;
        $newProduct->imgurl = $productImg;
        $newProduct->tid = $productType;
        $newProduct->description = $description;
        $newProduct->save();

        $result = true;
        echo $result;
    }

    public function actionGetAllOrdersByM(){
        $state = $_POST['state'];
        $sql = "SELECT * FROM `order` WHERE state=".$state;

        $orders = Order::model()->findAllBySql($sql);
        $result = array();
        $index = 0;
        foreach ($orders as $order) {
            $result[$index]['oid'] = $order->id;
            $result[$index]['cardnumber'] = $order->cardnumber;
            $pid = $order->pid;

            $sql = "SELECT * FROM `product` WHERE id=".$pid;
            $productName = Product::model()->findBySql($sql)->name;

            $result[$index]['productName'] = $productName;
            $result[$index]['count'] = $order->count;
            $result[$index]['timestamp'] = $order->timestamp;
            $index++;
        }

        echo json_encode($result);
    }

    public function actionReachOrder(){
        $oid = $_POST['oid'];

        $sql = "SELECT * FROM `order` WHERE id=".$oid;
        $order = Order::model()->findBySql($sql);
        $result = false;
        if($order){
            $order->state = 1;
            $order->save();
            $result = true;
        }
        echo $result;
    }

    public function actionShowRSChar(){
        $timestamp = $_POST['timestamp'];
         // $timestamp = '2012-03-04';
        //预定情况
        /*$sql = "SELECT COUNT(id) FROM `order` WHERE timestamp>=".$timestamp." AND state=0";

        $result = array();
        $reservation = Order::model()->countBySql($sql);
        $result['reservation'] = $reservation;

        $sql = "SELECT COUNT(id) FROM `order` WHERE timestamp>=".$timestamp." AND state=1";
        $purchased = Order::model()->countBySql($sql);
        $result['purchased'] = $purchased;*/

        //预定情况
        $result = array();
        for($index=0; $index<5; $index++){
            $result['purchased'][$index] = 0;
            $result['reservation'][$index] = 0;
        }

        $sql = "SELECT pid,SUM(count) AS count,state FROM `order` WHERE state=0 AND timestamp>='".$timestamp."' GROUP BY pid";
        $orders = Order::model()->findAllBySql($sql);
        foreach ($orders as $order) {

            $pid = $order->pid;
            $sql = "SELECT tid FROM `product` WHERE id=".$pid;

            $count = $order->count;
            $tid = Product::model()->findBySql($sql)->tid;
            if(6 == $tid){
                $result['reservation'][4] += $count;
            }else{
                $result['reservation'][$tid-1] += $count;
            }
        }

        $sql = "SELECT pid,SUM(count) AS count,state FROM `order` WHERE state=1  AND timestamp>='".$timestamp."' GROUP BY pid";
        $orders = Order::model()->findAllBySql($sql);
        foreach ($orders as $order) {
            $pid = $order->pid;
            $sql = "SELECT tid FROM `product` WHERE id=".$pid;
            $tid = Product::model()->findBySql($sql)->tid;
            $count = $order->count;
            if(6==$tid){
                $result['purchased'][4] += $count;
            }else{
                $result['purchased'][$tid-1] += $count;
            }
        }
        echo json_encode($result);

    }

    public function actionShowChartOfMember(){
        // $sql = "SELECT uid,SUM(amount) AS amount  FROM `order`  GROUP BY uid";
        // $orders = Order::model()->findAllBySql($sql);

        $sql = "SELECT * FROM `user` WHERE authority=1";
        $users = User::model()->findAllBySql($sql);
        // echo $users;

        $result = array();
        for($i=0; $i<11; $i++){
            $result[0][$i]=0;
            $result[1][$i]=0;
        }
        $index = 0;
        // foreach ($orders as $order) {
        foreach ($users as $user) {
            // $uid = $order->uid;
            // $sql = "SELECT * FROM `user` WHERE id=".$uid;
            // $user = User::model()->findBySql($sql);

            $birthday = $user->birthday; 
            $birthday = str_split($birthday,1);
            $year = $birthday[0].$birthday[1].$birthday[2].$birthday[3];
            
            $month = $birthday[5].$birthday[6];
            $day = $birthday[8].$birthday[9];

            // echo $year.'/'.$month."/".$day;
            // $currentTime = strtotime("now");


            $currentYear = date('Y');
            $currentMonth = date("m");
            $currentDay = date("d");
            // echo $currentYear."/".$currentMonth."/".$currentDay;
            $age = 0;
            if($currentMonth > $month){
                $age = $currentYear - $year;
            }else if($currentMonth == $month){
                if($currentDay >= $day){
                    $age = $currentYear - $year;
                }else{
                    $age = $currentYear - $year - 1;
                }
            }else{
                $age = $currentYear - $year - 1;
            }

            // echo "(".$age.")";

            $gender = $user->gender;

            if($age>=0 && $age<=9){
                $result[$gender][0]++;
            }else if($age>9 && $age<=19){
                $result[$gender][1]++;
            }else if($age>19 && $age<=29){
                $result[$gender][2]++;
            }else if($age>29 && $age<=39){
                $result[$gender][3]++;
            }else if($age>39 && $age<=49){
                $result[$gender][4]++;
            }else if($age>49 && $age<=59){
                $result[$gender][5]++;
            }else if($age>59 && $age<=69){
                $result[$gender][6]++;
            }else if($age>69 && $age<=79){
                $result[$gender][7]++;
            }else if($age>79 && $age<=89){
                $result[$gender][8]++;
            }else if($age>89 && $age<=99){
                $result[$gender][9]++;
            }else if($age>99){
                $result[$gender][10]++;
            }
            // echo "---".$age;
        }

        echo json_encode($result);
    }

    public function actionShowChartOfAddr(){
        $sql = "SELECT COUNT(id) AS count, address FROM `user` WHERE authority=1 GROUP BY address";
        // $addressList = User::model()->findAllBySql($sql);
        $db = Yii::app()->db;
        $dataReader = $db->createCommand($sql)->query();
        $addressList = $dataReader->readAll();
        // echo var_dump($addressList);
        // die();
        // echo('___'.$addressList);

        $result = array();
        $result["玄武区"] = 0;
        $result['白下区'] = 0;
        $result['建邺区'] = 0;
        $result['秦淮区'] = 0;
        $result['雨花台区'] = 0;
        $result['下关区'] = 0;
        $result['浦口区'] = 0;
        $result['鼓楼区'] = 0;
        $result['栖霞区'] = 0;
        $result['江宁区'] = 0;
        $result['六合区'] = 0;
        $result['溧水县'] = 0;
        $result['高淳县'] = 0;

        $length = count($addressList);
        // echo $length;
        for($index=0; $index<$length; $index++){
            $addr = $addressList[$index];
            $result[$addr['address']] = $addr['count']+0;
            // echo "(".$result[$addr['address']].")";
        }

        echo json_encode($result);
    }

    public function actionShowCardsState(){
        $result = array();
        $sql = "SELECT COUNT(id) FROM membership_card WHERE state=1";
        $isUsing = MembershipCard::model()->countBySql($sql);
        $result['isUsing'] = $isUsing;
        $sql = "SELECT COUNT(id) FROM membership_card WHERE state=0";
        $disuse = MembershipCard::model()->countBySql($sql);
        $result['disuse'] = $disuse;

        $total = $isUsing + $disuse;
        $result['disuse'] = 100*$disuse/$total;
        $result['isUsing'] = 100*$isUsing/$total;

        echo json_encode($result);

    }

    public function actionGetAllProducts(){
       
        $sql = "SELECT id, name FROM `product` ";
        $products = Product::model()->findAllBySql($sql);
        $result = array();
        $index = 0;
        foreach ($products as $product) {
            $result[$index]['pid'] = $product->id;
            $result[$index]['pname'] = $product->name;
            $index++;
        }
        echo json_encode($result);
    }

    public function actionAddSales(){
        $pid = $_POST['pid'];
        $saleDate = $_POST['saleDate'];
        $saleCount = $_POST['saleCount'];
        // $pid = 9;
        // $saleDate = '2012-03-10';
        // $saleCount = 7;

        $sql = "SELECT * FROM product WHERE id=".$pid;
        $product = Product::model()->findBySql($sql);
        $result = false;
        if($product){
            // $sql = "SELECT * FROM sales WHERE pid=".$pid." AND timestamp=".$saleDate;
            $sql = "SELECT * FROM sales WHERE pid=".$pid." AND timestamp='".$saleDate."'";
            $haveSale = Sales::model()->findBySql($sql);
            // echo var_dump($haveSale);
            // die();

            if(null == $haveSale){
                // echo "yes";
                $newSale = new Sales;
                $newSale->pid = $pid;
                $newSale->count = $saleCount;
                $newSale->timestamp = $saleDate;
                $newSale->save();
                $result = true;
            }
        }

        echo $result;
    }

    public function actionRegister(){
        $username = $_POST['username'];
        $identity = 1;
        $gender = 0;
        $address = "玄武区";
        $birthday = $_POST['birthday'];
        $password = $_POST['password'];
        /*$username = "new";
        $identity = 1;
        $gender = 1;
        $address = "玄武区";
        $birthday = "";*/

        $sql = "SELECT id FROM user WHERE name='".$username."'";
        $user = User::model()->findBySql($sql);

        $result = array();
        $result['UsernameError'] = true;
        if(!$user){
            //该用户名不存在
            
            $newUser = new User;
            $newUser->name = $username;
            $newUser->authority = $identity;
            $newUser->gender = $gender;
            if("" == $address){
                $newUser->address = "玄武区";
            }else{
                $newUser->address = $address;
            }
            
            if("" == $birthday){
                $newUser->birthday = date('Y')."-".date("m")."-".date('d');
            }else{
                $newUser->birthday = $birthday;
            }
            $newUser->save();
            $result['UsernameError'] = false;
        }

        echo json_encode($result);
    }

    public function actionGetAllClerks(){
       $sql = "SELECT * FROM `user` WHERE authority=2";
       $clerks = User::model()->findAllBySql($sql);

       $result = array();
       $index = 0;
       foreach ($clerks as $clerk) {
            $result[$index]['clerkname'] = $clerk->name;
            $result[$index]['uid'] = $clerk->id;
            $index++;
        } 

        echo json_encode($result);
    }

    public function actionDeleteClerk(){
        $uid = $_POST['uid'];

        $sql = "SELECT * FROM `user` WHERE id=".$uid;
        $user = User::model()->findBySql($sql);

        $result = false;

        if($user){
            $user->delete();
            $result = true;
        }
        echo $result;
    }

    public function actionGetProductTypes(){
        $sql = "SELECT * FROM `product_type`";

        $productTypes = ProductType::model()->findAllBySql($sql);

        $result = array();
        $index = 0;
        foreach ($productTypes as $type) {
            $result[$index]['ptypeName'] = $type->name;
            $result[$index]['typeID'] = $type->id;
            $index++;
        }
        
        echo json_encode($result);
    }

    public function actionAddProductType(){
        $ptypeName=$_POST['ptypeName'];
        // $ptypeName = "糕点2";
        // echo $ptypeName;

        $sql = 'SELECT * FROM  `product_type` WHERE name="'.$ptypeName.'"';
        $type = ProductType::model()->findBySql($sql);
        // echo var_dump($type);
        $result = true;
        if($type){
            //该种类已存在
            $result = false;
        }else{
            $ptype = new ProductType;
            $ptype->name = $ptypeName;
            if( !$ptype->save()) {
                $result = false;
            }
        }

        echo json_encode($result);
    }

    public function actionDeleteType(){
        $typeID = $_POST['typeID'];

        $sql = "SELECT * FROM `product_type` WHERE id=".$typeID;
        $type = ProductType::model()->findBySql($sql);
        $result = false;
        if($type){
            $type->delete();
            $result = true;
        }

        echo $result;
    }

    public function actionGetIdentity(){
        $identity = 4;
        if (!Yii::app()->user->isGuest) {
                $identity = Yii::app()->user->identity;
            }
        echo $identity;
    }
}