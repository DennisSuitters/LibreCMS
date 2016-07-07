<?php
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
if($_SESSION['loggedin']==false)$html=$theme['settings']['page_not_found'];
else{
    if(stristr($html,'<order>')){
        preg_match('/<order>([\w\W]*?)<\/order>/',$html,$matches);
        $order=$matches[1];
        $html=preg_replace('~<order>.*?<\/order>~is','<order>',$html,1);
    }
    if(stristr($html,'<items>')){
        preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
        $items=$matches[1];
        $output='';
        $s=$db->prepare("SELECT * FROM orders WHERE uid=:uid AND status!='archived' ORDER BY ti DESC");
        $s->execute(array(':uid'=>$_SESSION['uid']));
        while($r=$s->fetch(PDO::FETCH_ASSOC)){
            $item=$items;
            $item=str_replace('<print order="ordernumber">',$r['qid'].$r['iid'],$item);
            $item=str_replace('<print order="status">',ucfirst($r['status']),$item);
            if($r['iid_ti']>0)
                $item=str_replace('<print order="date">',date($config['dateFormat'],$r['iid_ti']),$item);
            else
                $item=str_replace('<print order="date">',date($config['dateFormat'],$r['qid_ti']),$item);
            $item=str_replace('<print order="duedate">',date($config['dateFormat'],$r['due_ti']),$item);
            $item=str_replace('<print link>',URL.'orders/'.$r['qid'].$r['iid'],$item);
            $output.=$item;
        }
        $html=preg_replace('~<items>.*?<\/items>~is',$output,$html,1);
    }
    if(isset($args[0])&&$args[0]!=''){
        preg_match('/<items>([\w\W]*?)<\/items>/',$order,$matches);
        $orderItem=$matches[1];
        $order=preg_replace('~<items>.*?<\/items>~is','<orderitems>',$order,1);
        $s=$db->prepare("SELECT * FROM orders WHERE qid=:id OR iid=:id AND status!='archived' AND uid=:uid");
        $s->execute(array(':id'=>$args[0],':uid'=>$_SESSION['uid']));
        if($s->rowCount()>0){
            $r=$s->fetch(PDO::FETCH_ASSOC);
            $su=$db->prepare("SELECT * FROM login WHERE id=:uid");
            $su->execute(array(':uid'=>$_SESSION['uid']));
            $ru=$su->fetch(PDO::FETCH_ASSOC);
            $order=str_replace('<print order="notes">',$r['notes'],$order);
            $order=str_replace('<print config="business">',$config['business'],$order);
            $order=str_replace('<print config="abn">',$config['abn'],$order);
            $order=str_replace('<print config="address">',$config['address'],$order);
            $order=str_replace('<print config="suburb">',$config['suburb'],$order);
            $order=str_replace('<print config="city">',$config['city'],$order);
            $order=str_replace('<print config="state">',$config['state'],$order);
            if($config['postcode']==0)$config['postcode']='';
            $order=str_replace('<print config="postcode">',$config['postcode'],$order);
            $order=str_replace('<print config="email">',$config['email'],$order);
            $order=str_replace('<print config="phone">',$config['phone'],$order);
            $order=str_replace('<print config="mobile">',$config['mobile'],$order);
            $order=str_replace('<print config="bank">',$config['bank'],$order);
            $order=str_replace('<print config="bankAccountName">',$config['bankAccountName'],$order);
            $order=str_replace('<print config="bankAccountNumber">',$config['bankAccountNumber'],$order);
            $order=str_replace('<print config="bankBSB">',$config['bankBSB'],$order);
            $order=str_replace('<print user="name">',$ru['name'].' ['.$ru['username'].']',$order);
            $order=str_replace('<print user="address">',$ru['address'],$order);
            $order=str_replace('<print user="suburb">',$ru['suburb'],$order);
            $order=str_replace('<print user="city">',$ru['city'],$order);
            $order=str_replace('<print user="state">',$ru['state'],$order);
            if($ru['postcode']==0)$ru['postcode']='';
            $order=str_replace('<print user="postcode">',$ru['postcode'],$order);
            $order=str_replace('<print user="email">',$ru['email'],$order);
            $order=str_replace('<print user="phone">',$ru['phone'],$order);
            $order=str_replace('<print user="mobile">',$ru['mobile'],$order);
            $order=str_replace('<print order="ordernumber">',$r['qid'].$r['iid'],$order);
            if($r['iid_ti']>0)$order=str_replace('<print order="date">',date($config['dateFormat'],$r['iid_ti']),$order);
            else$order=str_replace('<print order="date">',date($config['dateFormat'],$r['qid_ti']),$order);
            $order=str_replace('<print order="duedate">',date($config['dateFormat'],$r['due_ti']),$order);
            $order=str_replace('<print order="status">',$r['status'],$order);
            $ois=$db->prepare("SELECT * FROM orderitems WHERE oid=:oid");
            $ois->execute(array(':oid'=>$r['id']));
            $outitems='';
            $total=0;
            while($oir=$ois->fetch(PDO::FETCH_ASSOC)){
                $is=$db->prepare("SELECT id,code,title FROM content WHERE id=:id");
				$is->execute(array(':id'=>$oir['iid']));
				$i=$is->fetch(PDO::FETCH_ASSOC);
                $item=$orderItem;
                $item=str_replace('<print orderitem="code">',$i['code'],$item);
                $item=str_replace('<print orderitem="title">',$i['title'],$item);
                $item=str_replace('<print orderitem="quantity">',$oir['quantity'],$item);
                $item=str_replace('<print orderitem="cost">',$oir['cost'],$item);
                $item=str_replace('<print orderitem="subtotal">',$oir['cost']*$oir['quantity'],$item);
                $total=$total+($oir['cost']*$oir['quantity']);
                $outitems.=$item;
            }
            $order=str_replace('<print order="total">',$total,$order);
            $order=str_replace('<print order=id>',$r['id'],$order);
            $order=preg_replace('~<orderitems>~is',$outitems,$order,1);
            $html=preg_replace('~<order>~is',$order,$html,1);
        }else$html=preg_replace('~<order>~is','',$html,1);
    }else$html=preg_replace('~<order>~is','',$html,1);
}
$content.=$html;
