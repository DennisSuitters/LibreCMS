<?php
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
if($_SESSION['loggedin']==false)
  $html=$theme['settings']['page_not_found'];
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
      $item=str_replace(array('<print order=ordernumber>','<print order="ordernumber">'),$r['qid'].$r['iid'],$item);
      $item=str_replace(array('<print order=status>','<print order="status">'),ucfirst($r['status']),$item);
      if($r['iid_ti']>0)
        $item=str_replace(array('<print order=date>','<print order="date">'),date($config['dateFormat'],$r['iid_ti']),$item);
      else
        $item=str_replace(array('<print order=date>','<print order="date">'),date($config['dateFormat'],$r['qid_ti']),$item);
      $item=str_replace(array('<print order=duedate>','<print order="duedate">'),date($config['dateFormat'],$r['due_ti']),$item);
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
      if($config['postcode']==0)$config['postcode']='';
      if($ru['postcode']==0)$ru['postcode']='';
      if($r['iid_ti']>0)
        $order=str_replace(array('<print order=date>','<print order="date">'),date($config['dateFormat'],$r['iid_ti']),$order);
      else
        $order=str_replace(array('<print order=date>','<print order="date">'),date($config['dateFormat'],$r['qid_ti']),$order);
      $order=str_replace(array(
        '<print order=notes>','<print order="notes">',
        '<print config=business>','<print config="business">',
        '<print config=abn>','<print config="abn">',
        '<print config=address>','<print config="address">',
        '<print config=suburb>','<print config="suburb">',
        '<print config=city>','<print config="city">',
        '<print config=state>','<print config="state">',
        '<print config=postcode>','<print config="postcode">',
        '<print config=email>','<print config="email">',
        '<print config=phone>','<print config="phone">',
        '<print config=mobile>','<print config="mobile">',
        '<print config=bank>','<print config="bank">',
        '<print config=bankAccountName>','<print config="bankAccountName">',
        '<print config=bankAccountNumber>','<print config="bankAccountNumber">',
        '<print config=bankBSB>','<print config="bankBSB">',
        '<print user=name>','<print user="name">',
        '<print user=address>','<print user="address">',
        '<print user=suburb>','<print user="suburb">',
        '<print user=city>','<print user="city">',
        '<print user=state>','<print user="state">',
        '<print user=postcode>','<print user="postcode">',
        '<print user=email>','<print user="email">',
        '<print user=phone>','<print user="phone">',
        '<print user=mobile','<print user="mobile">',
        '<print order=ordernumber>','<print order="ordernumber">',
        '<print order=duedate>','<print order="duedate">',
        '<print order=status>','<print order="status">'
      ),array(
        htmlspecialchars(rawurldecode($r['notes']),ENT_QUOTES,'UTF-8'),htmlspecialchars(rawurldecode($r['notes']),ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['abn'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['abn'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['suburb'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['suburb'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['city'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['city'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['state'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['state'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['email'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['email'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['phone'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['phone'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['mobile'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['mobile'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['bank'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['bank'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['bankAccountName'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['bankAccountName'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['bankAccountNumber'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['bankAccountNumber'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($config['bankBSB'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['bankBSB'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($ru['name'].' ['.$ru['username'].']',ENT_QUOTES,'UTF-8'),htmlspecialchars($ru['name'].' ['.$ru['username'].']',ENT_QUOTES,'UTF-8'),
        htmlspecialchars($ru['address'],ENT_QUOTES,'UTF-8'),htmlspecialchars($ru['address'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($ru['suburb'],ENT_QUOTES,'UTF-8'),htmlspecialchars($ru['suburb'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($ru['city'],ENT_QUOTES,'UTF-8'),htmlspecialchars($ru['city'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($ru['state'],ENT_QUOTES,'UTF-8'),htmlspecialchars($ru['state'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($ru['postcode'],ENT_QUOTES,'UTF-8'),htmlspecialchars($ru['postcode'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($ru['email'],ENT_QUOTES,'UTF-8'),htmlspecialchars($ru['email'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($ru['phone'],ENT_QUOTES,'UTF-8'),htmlspecialchars($ru['phone'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($ru['mobile'],ENT_QUOTES,'UTF-8'),htmlspecialchars($ru['mobile'],ENT_QUOTES,'UTF-8'),
        $r['qid'].$r['iid'],$r['qid'].$r['iid'],
        date($config['dateFormat'],$r['due_ti']),date($config['dateFormat'],$r['due_ti']),
        htmlspecialchars($r['status'],ENT_QUOTES,'UTF-8'),htmlspecialchars($r['status'],ENT_QUOTES,'UTF-8'),
      ),$order);
      $ois=$db->prepare("SELECT * FROM orderitems WHERE oid=:oid");
      $ois->execute(array(':oid'=>$r['id']));
      $outitems='';
      $total=0;
      while($oir=$ois->fetch(PDO::FETCH_ASSOC)){
        $is=$db->prepare("SELECT id,code,title FROM content WHERE id=:id");
				$is->execute(array(':id'=>$oir['iid']));
				$i=$is->fetch(PDO::FETCH_ASSOC);
        $sc=$db->prepare("SELECT * FROM choices WHERE id=:id");
        $sc->execute(array(':id'=>$oir['cid']));
        $c=$sc->fetch(PDO::FETCH_ASSOC);
        $item=$orderItem;
        $item=str_replace(array(
          '<print orderitem=code>','<print orderitem="code">',
          '<print orderitem=title>','<print orderitem="title">',
          '<print choice>',
          '<print orderitem=quantity>','<print orderitem="quantity">',
          '<print orderitem=cost>','<print orderitem="cost">',
          '<print orderitem=subtotal>','<print orderitem="subtotal">'
        ),array(
          htmlspecialchars($i['code'],ENT_QUOTES,'UTF-8'),htmlspecialchars($i['code'],ENT_QUOTES,'UTF-8'),
          htmlspecialchars($i['title'],ENT_QUOTES,'UTF-8'),htmlspecialchars($i['title'],ENT_QUOTES,'UTF-8'),
          htmlspecialchars($c['title'],ENT_QUOTES,'UTF-8'),
          htmlspecialchars($oir['quantity'],ENT_QUOTES,'UTF-8'),htmlspecialchars($oir['quantity'],ENT_QUOTES,'UTF-8'),
          htmlspecialchars($oir['cost'],ENT_QUOTES,'UTF-8'),htmlspecialchars($oir['cost'],ENT_QUOTES,'UTF-8'),
          htmlspecialchars($oir['cost']*$oir['quantity'],ENT_QUOTES,'UTF-8'),htmlspecialchars($oir['cost']*$oir['quantity'],ENT_QUOTES,'UTF-8')
        ),$item);
        $total=$total+($oir['cost']*$oir['quantity']);
        $outitems.=$item;
      }
      $sr=$db->prepare("SELECT * FROM rewards WHERE id=:id");
      $sr->execute(array(':id'=>$r['rid']));
      if($sr->rowCount()>0){
        $reward=$sr->fetch(PDO::FETCH_ASSOC);
        $order=str_replace(array('<print rewards=code>','<print rewards="code">'),$reward['code'],$order);
        if($reward['method']==1){
          $method='$'.$reward['value'].' Off';
          $total=$total-$reward['value'];
        }else{
          $method=$reward['value'].'% Off';
          $total=($total*((100-$reward['value'])/100));
        }
        $order=str_replace(array('<print rewards=method>','<print rewards="method">'),$method,$order);
        $order=str_replace(array('<print rewards=value>','<print rewards="value">'),$total,$order);
        $order=str_replace(array('<rewards>','</rewards>'),'',$order);
      }else
        $order=preg_replace('~<rewards>.*?<\/rewards>~is','',$order,1);
      if($r['postage']>0){
        $order=str_replace(array('<print order=postage>','<print order="postage">'),$r['postage'],$order);
        $total=$total+$r['postage'];
        $order=str_replace(array('<postage>','</postage>'),'',$order);
      }else
        $order=preg_replace('~<postage>.*?<\/postage>~is','',$order,1);
      $order=str_replace(array('<print order=total>','<print order="total">'),$total,$order);
      $order=str_replace(array('<print order=id>','<print order="id">'),$r['id'],$order);
      $order=preg_replace('~<orderitems>~is',$outitems,$order,1);
      $html=preg_replace('~<order>~is',$order,$html,1);
    }else
      $html=preg_replace('~<order>~is','',$html,1);
  }else
    $html=preg_replace('~<order>~is','',$html,1);
}
$content.=$html;
