<?php


namespace Controller;

class Main{

  public $db;
  public $params = array();

  public function before(){
   $newparam = [];
    if(!empty($this->params)){
     foreach($this->params as $p){
      if(strpos($p,'=')!==FALSE) $tmp = explode('=',$p);
      $newparam[$tmp[0]] = $tmp[1];
     }
     $this->params = $newparam;
   }

  }
  public function index(){
    return 'Hello';
  }

  public function getcards(){
    if(!empty($this->params) && $this->params['sort']) {
        $sort = !empty($this->params['sort']) ? $this->params['sort'] : 'serie';
    }
    //$sort = isset($_GET['sort']) ? $_GET['sort'] : 'serie';
    $sortcount = false;
    if($sort === 'countorders') {
      $sort = 'serie';
      $sortcount = true;
    }
    $result = $this->db->query("select * from `cards` as c order by c.$sort ASC");

    $cards = [];
    $status = ['не активирована','активирована','просрочена'];

      $i=0;
        $rows = $result->rows();
      foreach($rows as &$row){
      $countorders =  $this->db->query("select COUNT(*) from `cardorders` where `card_id`=:id", [':id' => $row['id']]);
      $countord = $countorders->row();
     $row['created_at'] =  date('d-m-Y', strtotime($row['created_at']));
     $row['active_until'] =  date('d-m-Y', strtotime($row['active_until']));
     $row['last_active'] =  date('d-m-Y', strtotime($row['last_active']));
     $row['status'] =  $status[$row['status']];
     $row['countorders'] = $countord['COUNT(*)'];
     $row['sql'] = $result->sql();
     $row['sortcount'] = $sortcount;
     $cards[] =$row;

     $i++;
    }

    if($sortcount) {
      usort($cards, function($a, $b){
        return ($a['countorders'] - $b['countorders']);
          }
      );
    }
    //return $rows;
    return $cards;
  }
  public function addcard(){
     $data = json_decode(file_get_contents("php://input"), TRUE);
     $data = $data['data'];
     $data['bonus'] = 1000;
     $data['created_at'] = date('Y-m-d H:i:s', strtotime('now'));
     $data['active_until'] = date('Y-m-d H:i:s', strtotime('+ 1 year'));
     $table = $this->db->table('cards');
     $id = $table->insert($data);
     $sum = $data['sum'];
     $bonus = $data['bonus'];
     if($sum<1) return $data;
      $ordcount = rand(3, 10);
      while($ordcount>0){
        $order = $this->db->table('cardorders');
        $used = date('Y-m-d H:i:s', strtotime('+ ' .rand(1,100).' days'));
        $orderdata = array (
          'card_id'=>$id,
          'status' => rand(0,100) > 50 ? 1 : 0,
          'cost' => rand(1,$sum),
          'bonus' => rand(1,$bonus),
          'used_at' => $used
        );
        $ordid = $order->insert($orderdata);
        $sum = $sum - $orderdata['cost'];
        $bonus = $bonus - $orderdata['bonus'];
        $table->set($id,['sum' => $sum,'bonus' => $bonus,'last_active'=>$used]);
        if($sum < 10 || $bonus < 10) break;
        $ordcount--;
      }

    return $data;
  }
  public function removecard(){
      $id = !empty($this->params['id']) ? $this->params['id'] : null;
      if(!$id) return '';
      $table = $this->db->table('cards');
      if($table->get($id)){
        $res = $this->db->query("delete from `cardorders` where `card_id`=$id");
        $table->rm($id);
      }
      return 'ok';
  }
  public function getorders(){
    $status = ['не оплачено','оплачено'];
    $id = !empty($this->params['id']) ? $this->params['id'] : null;
    if(!$id) return '';
    $result = $this->db->query("select * from `cardorders` where `card_id`=$id")->rows();
    foreach($result as &$r) {
      $r['status'] = $status[$r['status']];
      $r['used_at'] =  date('d-m-Y', strtotime($r['used_at']));
    }
    return $result;
  }
  public function activatecard(){
    $id = !empty($this->params['id']) ? $this->params['id'] : null;
    $num = !empty($this->params['num']) ? $this->params['num'] : 0;
    echo $num;
    if(!$id || $num === null) return '';

      $res = $this->db->query("update `cards` as c set c.status= $num WHERE c.id = $id");
      return $res;
  }

}
