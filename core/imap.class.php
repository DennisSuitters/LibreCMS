<?php 
/** 
 * LICENSE: The MIT License 
 * Copyright (c) 2010 Chris Nizzardini (http://www.cnizz.com)  

Permission is hereby granted, free of charge, to any person obtaining a copy 
of this software and associated documentation files (the "Software"), to deal 
in the Software without restriction, including without limitation the rights 
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell 
copies of the Software, and to permit persons to whom the Software is 
furnished to do so, subject to the following conditions: 

The above copyright notice and this permission notice shall be included in 
all copies or substantial portions of the Software. 

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER 
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, 
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN 
THE SOFTWARE. 

 * largely a wrapper class for php imap functions but since the classes on phpclasses.org are so shitty here we go.... 
 * @see http://www.php.net/manual/en/book.imap.php 
 * @uses imap_mailboxmsginfo 
 * @uses imap_headers 
 * @uses imap_list 
 * @uses imap_headerinfo 
 */ 

class Imap 
{ 
    private $stream; 
    private $mbox; 
    private $is_connected = 0; 
    private $host; 
    private $username; 
    private $password;
    private $port; 
    private $tls; 
     
    function __construct($host,$username,$password,$port=143,$tls='notls'){ 
        $this->username = $username;
        $this->password = $password;
        $this->host = $host;
        $this->port = $port;
        $this->tls = $tls;
        $this->openMailBox();
    }
    
    /** 
     * returnImapMailBoxmMsgInfoObj - returns general mailbox information 
     * @see http://www.php.net/manual/en/function.imap-mailboxmsginfo.php 
     * @param void 
     * @return object 
     */ 
    public function returnImapMailBoxmMsgInfoObj(){ 
        return imap_mailboxmsginfo($this->stream); 
    } 
     
    /** 
     * returnMailBoxHeaderArr - this is all you need to see email header information for all emails within a mailbox 
     * @param void 
     * @return array 
     */ 
    public function returnMailBoxHeaderArr($mailbox) 
    { 
        $array = array(); 
        $this->openMailBox($mailbox);
        $arr = $this->returnImapHeadersArr(); 

        if(is_array($arr)){ 
            foreach($arr as $i){ 
                $i = trim($i); 
                // check for unread emails 
                if(substr($i,0,1) == 'U'){ 
                    $i = substr($i,1,strlen($i)); 
                } 
                $i = trim($i);                 
                // display if not pending deletion 
                if(substr($i,0,1) != 'D'){ 
                    $position = strpos($i,')');
                    $msgno = preg_replace('/\D/','',substr($i,0,$position)); 
                    $array[] = $this->returnEmailHeaderArr($msgno); 
                } 
            } 
        }
        return $array; 
    } 
     
    /** 
     * returnMailboxListArr - returns lists of mailboxes 
     * @see http://www.php.net/manual/en/function.imap-list.php 
     * @param void 
     * @return array 
     */     
    public function returnMailboxListArr(){ 
        return imap_list($this->stream,$this->mbox,'*'); 
    } 
     
    /** 
     * returnEmailHeaderArr 
     * This returns detailed header information for the given message number 
     * @param messageNumber 
     * @return array 
     */ 
    public function returnEmailHeaderArr($messageNumber) 
    { 
        $head = $this->returnHeaderInfoObj($messageNumber);

        $array['date'] = $head->date; 
        $array['subject'] = $head->subject; 
        $array['to'] = $head->toaddress; 
        $array['message_id'] = $head->message_id; 
        $array['from'] = $head->from[0]->mailbox.'@'.$head->from[0]->host; 
        $array['sender'] = $head->sender[0]->mailbox.'@'.$head->sender[0]->host; 
        $array['reply_toaddress'] = $head->reply_toaddress; 
        $array['size'] = $head->Size; 
        $array['msgno'] = $head->Msgno; 
         
        if($head->Unseen == 'U'){ 
            $array['status'] = 'Unread'; 
        } 
        else{ 
            $array['status'] = 'Read'; 
        } 
        return $array; 
    } 
     
    /** 
     * returnEmailMessageArr 
     * This returns the entire email for the given message number 
     * @param unknown_type $messageNumber 
     * @return array 
     * @example array('header'=>object,'plain'=>'','html'=>'','attachment'=>array()); 
     */ 
    public function returnEmailMessageArr($messageNumber,$withEncodedAttachment=0) 
    { 
        $array = array(); 
         
        $o = $this->returnMessageStructureObj($messageNumber); 
        //print_r($o); 
        //$this->returnRawBodyStr($messageNumber); 
        if(is_object($o)) 
        { 
            $array['header'] = $this->returnEmailHeaderArr($messageNumber); 
            if(isset($o->parts) && is_array($o->parts)) 
            { 
                $attachments = 0;
                // first build plain and/or html part of array 
                foreach($o->parts as $x => $i) 
                { 
                    if(isset($i->parts) && is_array($i->parts)) 
                    { 
                        foreach($i->parts as $j => $k) 
                        { 
                            if($k->subtype == 'PLAIN'){ 
                                $array['plain'] = $this->returnBodyStr($messageNumber,'1.1'); 
                            } 
                            else if($k->subtype == 'HTML'){ 
                                $array['html'] = $this->returnBodyStr($messageNumber,'1.2'); 
                            } 
                            else if($k->disposition == 'ATTACHMENT'){ 
                                $attachments++; 
                            } 
                        } 
                    } 
                    else{ 
                        if($i->subtype == 'PLAIN'){ 
                            $array['plain'] = $this->returnBodyStr($messageNumber,'1'); 
                        } 
                        else if($i->subtype == 'HTML'){ 
                            $array['html'] = $this->returnBodyStr($messageNumber,'2'); 
                        } 
                        else if($i->disposition == 'ATTACHMENT'){ 
                            $attachments++; 
                            $array['attachments'][] = array('type'=>$i->subtype,'bytes'=>$i->bytes,'name'=>$i->parameters[0]->value,'part'=>"2"); 
                        } 
                    } 
                } 
                 
                if(isset($attachments) && $attachments > 1){ 
                    $array['attachments'] = array(); 
                    foreach($o->parts as $x => $i) 
                    { 
                        if($i->disposition == 'ATTACHMENT') 
                        { 
                            $part = $x+1; 
                            $array['attachments'][] = array('type'=>$i->subtype,'bytes'=>$i->bytes,'name'=>$i->parameters[0]->value,'part'=>$part,'msgno'=>$messageNumber); 
                        } 
                    } 
                } 
            } 
            // simple plain text email 
            else if($o->subtype == 'PLAIN'){ 
                $array['plain'] = $this->returnBodyStr($messageNumber,'1'); 
            } 
            else{ 
                $array['error'][] = 'Error encountered parsing email'; 
            } 
        } 
        else{ // report error 
             
        } 
        return $array; 
    } 
     
    /** 
     * saveAttachmentAndReturnFullFilePathStr 
     * @param messageNumber(int),part(str),saveToFile(str) 
     * @example saveToFile = '/var/www/attachment/myAttachement' (do not include an extension i do this for you at return!) 
     * @return string 
     */ 
    public function saveAttachment($messageNumber,$part,$saveToFile) 
    { 
        $arr = $this->returnEmailMessageArr($messageNumber,1); 
         
        if(is_array($arr['attachments'])) 
        { 
            foreach($arr['attachments'] as $i){ 
                if($i['part'] == $part){ 
                    $extensionArr = explode('.',$i['name']); 
                    $extension = $extensionArr[(count($extensionArr) - 1)]; 
                    $file = $saveToFile.'.'.$extension; 
                    $f = fopen($file,'w+'); 
                    fwrite($f,base64_decode($this->returnBodyStr($messageNumber,$part))); 
                    fclose($f); 
                    $f = fopen($file,'r'); 
                    fread($f,filesize($file)); 
                    return $file; 
                } 
            } 
        } 
        return ''; 
    } 
     
    public function get_is_connected(){ 
        return $this->is_connected; 
    } 
    public function get_mbox(){ 
        return $this->mbox; 
    }     
    public function get_host(){ 
        return $this->host; 
    } 
    public function get_username(){ 
        return $this->username; 
    }     
    public function get_password(){ 
        return $this->password; 
    } 
    public function get_folder(){ 
        return $this->folder; 
    }     
    public function get_port(){ 
        return $this->port; 
    } 
    public function get_tls(){ 
        return $this->tls; 
    }     
    public function get_stream(){ 
        return $this->stream; 
    } 
     
    // METHODS BELOW ARE PRIVATE - YOU CAN CHANGE THESE TO PUBLIC IF NEED BE - BUT THE ABOVE METHODS SHOULD GIVE YOU EVERYTHING YOU NEED 
     
    private function openMailBox($mailbox=''){
        
        $this->mbox = (empty($mailbox)) ? '{'.$this->host.':'.$this->port.'/'.$this->tls.'}' : $mailbox;
        
        try{
            $this->stream = imap_open($this->mbox,$this->username,$this->password); 
        }
        catch(Exception $e){
            var_dump($e);
        }
        
        if($this->stream != false){ 
            $this->is_connected = 1; 
        } 
    }
    
    /** 
     * returnHeaderInfoObj 
     * @see http://www.php.net/manual/en/function.imap-headerinfo.php 
     * @param void 
     * @return object 
     */ 
    private function returnHeaderInfoObj($messageNumber){ 
        return @imap_headerinfo($this->stream,$messageNumber); 
    } 
     
    /** 
     * returnMessageStructureObj 
     * @see http://www.php.net/manual/en/function.imap-fetchstructure.php 
     * @param unknown_type $messageNumber 
     * @return object 
     */ 
    private function returnMessageStructureObj($messageNumber){ 
        return imap_fetchstructure($this->stream,$messageNumber); 
    } 
     
    /** 
     * returnRawMessageBodyStr 
     * @see http://www.php.net/manual/en/function.imap-body.php 
     * @param unknown_type $messageNumber 
     * @return string 
     */ 
    private function returnRawBodyStr($messageNumber){ 
        return imap_body($this->stream,$messageNumber); 
    } 
     
    /** 
     * returnImapHeadersArr - returns general info on emails in this box 
     * @see http://www.php.net/manual/en/function.imap-headers.php 
     * @param void 
     * @return array 
     */ 
    private function returnImapHeadersArr(){
        return imap_headers($this->stream); 
    } 
     
    /** 
     * returnMessageBodyStructureObj 
     * @see http://www.php.net/manual/en/function.imap-bodystruct.php 
     * @param $messageNumber(int),part(int) 
     * @return object 
     */ 
    private function returnBodyStructureObj($messageNumber,$part){ 
        return imap_bodystruct($this->stream,$messageNumber,$part); 
    } 
     
    /** 
     * returnBodyStr 
     * @see http://www.php.net/manual/en/function.imap-fetchbody.php 
     * @param $messageNumber(int),part(int) 
     * @return string 
     */ 
    private function returnBodyStr($messageNumber,$section){ 
        return imap_fetchbody($this->stream,$messageNumber,$section); 
    } 
} 
