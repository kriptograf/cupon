<?php

class ParsingController extends Controller
{
    public $defaultAction = 'index';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index','title','content'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Парсим в базу ссылки по категориям
     * @param integer $id the ID of the model to be displayed
     */
    public function actionIndex()
    {
       Yii::import('ext.phpQuery.*');
       require_once('phpQuery.php');

       $url = 'http://fryazino.info/index.php?mod=business';
       $fr = file_get_contents($url);
       
       $fr = mb_convert_encoding($fr, 'UTF-8', 'CP-1251');
  
       $document = phpQuery::newDocument($fr);
       //получаем корневые категории
       $root = $document->find('td.content table h1');
       $i=0;
       foreach ($root as $h)
       {
           $pq = pq($h); // Это аналог $ в jQuery      
           $res = str_replace(' Фрязино', '', $pq->text());//удаляем фрязино
           $e[$i] = $res;
           $cat = new CategoriesCompany();
           $cat->name = $e[$i]; 
           $cat->parent_id=NULL;
           if($cat->save())
           {
               $this->childs($url, $i, $cat->id);
           }
           else
           {
               echo CVarDumper::dump($cat->getErrors(),10,true);exit;
           }
           
           $i++;
       }
    }
    
    public function actionContent()
    {
        Yii::import('ext.phpQuery.*');
       require_once('phpQuery.php');
       
       $link = FrCat::model()->findAllByAttributes(array('pid'=>57));

       foreach ($link as $l)
       {
           $url = 'http://fryazino.info/'.$l->link;
            $fr = file_get_contents($url);

            $fr = mb_convert_encoding($fr, 'UTF-8', 'CP-1251');

            $document = phpQuery::newDocument($fr);

            $root = $document->find('td.content table td');

            foreach ($root as $k=>$h)
            {
                $pq = pq($h); // Это аналог $ в jQuery      

                if(!$pq->find('h2 > a:eq(0)')->attr('href'))
                {
                    continue;
                }
                $e[] = $pq->find('h2 > a:eq(0)')->attr('href');

                
            }
            
       }
       echo CVarDumper::dump(array_unique($e),10,true);
    }

    

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function childs($url, $root, $pid)
    {
//       Yii::import('ext.phpQuery.*');
//       require_once('phpQuery.php');

//       $url = 'http://fryazino.info/index.php?mod=business';
       
       $fr = file_get_contents($url);
       
       $fr = mb_convert_encoding($fr, 'UTF-8', 'CP-1251');
  
       $document = phpQuery::newDocument($fr);
       
       $elem = $document->find('td.content table td:eq('.$root.')');
       
       foreach ($elem->find('a') as $h)
       {
           $pq = pq($h); // Это аналог $ в jQuery
           
           
           //$e[] = $pq->attr('href');
           
           $subcat = new FrCat();
           $subcat->pid = $pid;
           $subcat->link = $pq->attr('href');
           $subcat->save();
           
       }
       
       //Сохраняем в бд ссылки на ктегории 
    }
    
    public function extractdata($html, $pattern)
    {
            preg_match_all($pattern, $html, $data); 	  
            return $data[1];
    }
}
