<?php
    class ImportsController extends AppController {
        public function index(){
            
        }
        // csvインポート処理
        public function upload() {

            if ($this->request->is('post')) {
                $time_start = microtime(true);
                $this->Import->create();
                $tmp_file_name = $this->request->data['Import']['submittedfile']['tmp_name'];
                $data = array();
                if (is_uploaded_file($tmp_file_name)){
                    $fp = tmpfile();
                    fwrite($fp, mb_convert_encoding(file_get_contents($tmp_file_name), 'UTF-8', 'ASCII, JIS, UTF-8, SJIS, sjis-win'));
                    rewind($fp);
                    while(($csv_content = fgetcsv($fp, 0, ",")) !==FALSE){
                        $data[] =  $csv_content; 
                    }
                }
                

                $item = array();
                $i = 0;
                foreach($data as $part){
                    $item[$i]['localGovermentCode'] = $part[0];
                    $item[$i]['oldZipcode'] = $part[1];
                    $item[$i]['zipCode'] = $part[2];
                    $item[$i]['prefectureOfKatakana'] = $part[3];
                    $item[$i]['cityOfKatakana'] = $part[4];
                    $item[$i]['townOfKatakana'] = $part[5];
                    $item[$i]['prefectureOfKanji'] = $part[6];
                    $item[$i]['cityOfKanji'] = $part[7];
                    $item[$i]['townOfKanji'] = $part[8];
                    $item[$i]['info1'] = $part[9];
                    $item[$i]['info2'] = $part[10];
                    $item[$i]['info3'] = $part[11];
                    $item[$i]['info4'] = $part[12];
                    $item[$i]['info5'] = $part[13];
                    $item[$i]['info6'] = $part[14];
                    $i++;
                }
                
                if($this->Import->saveMany($item)){
                    $this->Flash->success(__('CSVファイルを追加しました'));
                    //処理時間計測
                    $time = microtime(true) - $time_start;
                    echo "{$time} 秒";
                    return $this->redirect(['action' => 'index']);
                } else {
                    //$this->log(print_r($deposits->getErrors(), true), LOG_DEBUG);
                    $this->Flash->error(__('CSVファイルを追加できませんでした'));
                }
            }
        }
        //csv更新処理
        public function update(){
            if ($this->request->is('post')){
                $time_start = microtime(true);
                //旧データ
                $oldData = $this->Import->find('all');
                //新データ
                $tmp_file_name = $this->request->data['Import']['submittedfile']['tmp_name'];
                $newData = array();
                if (is_uploaded_file($tmp_file_name)){
                    $fp = tmpfile();
                    fwrite($fp, mb_convert_encoding(file_get_contents($tmp_file_name), 'UTF-8', 'ASCII, JIS, UTF-8, SJIS, sjis-win'));
                    rewind($fp);
                    while(($csv_content = fgetcsv($fp, 0, ",")) !==FALSE){
                        $newData[] =  $csv_content; 
                    }
                }
                
                if (count($oldData) == count($newData)){
                    $transOldData = array();
                    for ($i=0; $i<count($oldData); $i++) {
                        $x = $i +1;
                        $transOldData = $oldData[$i]['Import'];
                        if (implode($transOldData) !== $x.implode($newData[$i])){
                            $sql = 'update imports set 
                            localGovermentCode="'.$newData[$i][0].'", 
                            oldZipcode="'.$newData[$i][1].'", 
                            zipCode="'.$newData[$i][2].'", 
                            prefectureOfKatakana="'.$newData[$i][3].'", 
                            cityOfKatakana="'.$newData[$i][4].'", 
                            townOfKatakana="'.$newData[$i][5].'", 
                            prefectureOfKanji="'.$newData[$i][6].'", 
                            cityOfKanji="'.$newData[$i][7].'", 
                            townOfKanji="'.$newData[$i][8].'", 
                            info1="'.$newData[$i][9].'", 
                            info2="'.$newData[$i][10].'", 
                            info3="'.$newData[$i][11].'", 
                            info4="'.$newData[$i][12].'", 
                            info5="'.$newData[$i][13].'", 
                            info6="'.$newData[$i][14].'" where id="'.$x.'"';
                            $this->Import->query($sql);
                        }
                    }
                    Debugger::dump("テスト1".implode($oldData[0]['Import']));
                    Debugger::dump("テスト2".implode($newData[0]));

                } else {
                    $this->Flash->error(__('更新できませんでした'.count($oldData)."----".count($newData)));
                }
                $time = microtime(true) - $time_start;
                $this->Flash->success(__($time));
            }
        }

        //地方検索処理
        public function search(){
            //ajax通信で実装
            if($this->request->is('ajax')) {
                $this->autoRender = FALSE;
                $zipCode = filter_input(INPUT_POST, "zipCode");
                $options = array(
                                'conditions' => array(
                                'zipCode' => $zipCode
                                )
                            );
                $data = $this->Import->find('first', $options);
                echo json_encode($data);
            }
        }

        //選択処理
        public function select() {
            $sql = "select distinct prefectureOfKanji from imports";
            $datas = $this->Import->query($sql);
            $data = array();
            foreach($datas as $list) {
                $data[] = $list['imports']['prefectureOfKanji'];
            }
            $this->set('data', $data);
        }

        //選択処理(ajax通信1)
        public function cityShow() {
            $this->autoRender = FALSE;
            if($this->request->is('ajax')) {
                $prefecture = filter_input(INPUT_POST, "prefecture");
                $sql = 'select distinct cityOfKanji from imports where prefectureOfKanji="'.$prefecture.'"';
                $datas = $this->Import->query($sql);
                $data = array();
                foreach($datas as $list) {
                    $data[] = $list['imports']['cityOfKanji'];
                }
                header('Content-Type: application/json');
                echo json_encode($data);
            }
        }

        //選択処理(ajax通信2)
        public function townShow() {
            $this->autoRender = FALSE;
            if($this->request->is('ajax')) {
                $city = filter_input(INPUT_POST, "city");
                $sql = 'select distinct townOfKanji from imports where cityOfKanji="'.$city.'"';
                $datas = $this->Import->query($sql);
                $data = array();
                foreach($datas as $list) {
                    $data[] = $list['imports']['townOfKanji'];
                }
                header('Content-Type: application/json');
                echo json_encode($data);
            }
        }
    }


?>