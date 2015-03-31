<?php

/**
 * This is the model class for table "categories_company".
 *
 * The followings are the available columns in table 'categories_company':
 * @property integer $id
 * @property string $name
 * @property integer $sort
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Companies[] $companies
 */
class CategoriesCompany extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CategoriesCompany the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'categories_company';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('sort,status', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, sort', 'safe', 'on' => 'search'),
            array('parent_id,name', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'companies' => array(self::HAS_MANY, 'Companies', 'category_id'),
            'countCompanies' => array(self::STAT, 'Companies', 'category_id', 'condition'=>'city_id='.Yii::app()->user->getState('currentCity',1).' AND checked=1 AND t.status=1'),
            'childs' => array(self::HAS_MANY, get_class($this), 'parent_id'),
            'parent' => array(self::BELONGS_TO, get_class($this), 'parent_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'parent_id'=>'Родительская категория',
            'name' => 'Название категории',
            'sort' => 'Сортировка',
            'status' => 'Публикация',
        );
    }


    public static function getCountChildsItems($parent)
    {
        $models = self::model()->findAllByAttributes(array('parent_id' => $parent));
        $count = 0;

        foreach ($models as $model)
        {
            $count += $model->countCompanies;
        }
        return $count;
    }
    
    

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name);
        $criteria->compare('sort', $this->sort);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getRootCategories()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('id IN (SELECT DISTINCT parent_id FROM categories_company WHERE parent_id IS NOT NULL)');
        return $this->findAll($criteria);
    }

    /**
     * Создать дерево для представления в CTreeView
     * Используется для вывода
     * @param array $models
     */
    public static function generateTree()
    {
        $criteria = new CDbCriteria();
        $criteria->compare('status',1);
        $models = self::model()->findAll($criteria);
        $data = array();

        foreach ($models as $category)
        {
            if ($category->parent_id == NULL)
            {
                $data[$category->id] = array(
                    'id' => $category->id,
                    'text' => '<span class="label">' . $category->name . ' <span class="count-cat">' . self::getCountChildsItems($category->id) . '</span></span>' ,
                );
            }

            foreach ($category->childs as $item)
            {
                $class = (Yii::app()->request->getParam('id') == $item->id || Yii::app()->request->getParam('category') == $item->id) ? 'active' : '';
                $data[$category->id]['children'][$item->id] = array(
                    'id' => $item->id,
                    'text' => '<a class="' . $class . '" href="/category/' . $item->id . '">&raquo;&nbsp;' . $item->name . ' <span class="count-cat">' . $item->countCompanies . '</span></a> ',
                    'expanded' => false,
                );
            }
        }
        return $data;
    }

    /**
     * ******************************************************************************************
     *                         Иерархический вывод селекта
     * ******************************************************************************************
     */

    /**
     * Получить все категории подготовленными для вставки в $form->dropDownList
     * 
     * @return array
     */
    public function getAllCategoriesForSelect()
    {
        $categoryData = CategoriesCompany::model()->findAll();
        $categoryDataTree = CategoriesCompany::model()->dbResultToForest($categoryData, 'id', 'parent_id', 'name');
        $categoryDataSelect = CategoriesCompany::model()->converTreeArrayToSelect($categoryDataTree, 0);
        /**
         * Формирование массива для dropDown - 
         * id - id модели
         * name- поле название категории
         * group - группа(корнеая категория )
         */
        return CHtml::listData($categoryDataSelect, 'id', 'name', 'group');
    }

    /**
     * Строим иерархическую структуру из результатов выборки.
     * db result must conist id, parent_id, value
     * 
     * @param Object $rows
     * @param string $idName name of id key in result query
     * @param string $pidName name of parent id for query result
     * @param string $labelName name of value field in query result
     * @return array heriarhical tree
     */
    public function dbResultToForest($rows, $idName, $pidName, $labelName = 'label')
    {
        $totalArray = array();
        $children = array(); // children of each ID
        $ids = array();
        $k = 0;
        // Collect who are children of whom.
        foreach ($rows as $i => $r)
        {
            $element = array(
                'id' => $rows[$i][$idName], //id - id модели 
                'parent_id' => $rows[$i][$pidName],
                'name' => $rows[$i][$labelName]//name- поле название категории
            );
            $totalArray[$k++] = $element;
            $row = &$totalArray[$k - 1];
            $id = $row['id'];
            if ($id === null)
            {
                // Rows without an ID are totally invalid and makes the result tree to
                // be empty (because PARENT_ID = null means "a root of the tree"). So
                // skip them totally.
                continue;
            }
            $pid = $row['parent_id'];
            if ($id == $pid)
            {
                $pid = null;
            }
            $children[$pid][$id] = & $row;
            if (!isset($children[$id]))
            {
                $children[$id] = array();
            }
            $row['childNodes'] = &$children[$id];
            $ids[$id] = true;
        }

        // Root elements are elements with non-found PIDs.
        $forest = array();
        foreach ($totalArray as $i => $r)
        {
            $row = &$totalArray[$i];
            $id = $row['id'];
            $pid = $row['parent_id'];
            if ($pid == $id)
                $pid = null;
            if (!isset($ids[$pid]))
            {
                $forest[$row[$idName]] = & $row;
            }
        }
        return $forest;
    }

    /**
     * Recursive function converting tree like array to single array with
     * delimiter. Such type of array used for generate drop down box
     * 
     * @param array $data data of tree like
     * @param int $level current level of recursive function
     * @return array converted array
     */
    public function converTreeArrayToSelect($data, $level = 0)
    {
        $returnArray = array();

        foreach ($data as $item)
        {
            /**
             * Если у элемента есть потомки, перебираем их в массиве
             */
            if ($item['childNodes'])
            {
                /**
                 * 
                 */
                foreach ($item['childNodes'] as $child)
                {
                    /**
                     * добавляем к потомку в свойство group название корневой категории 
                     * для формирования тега oprgroup
                     */
                    $child['group'] = $item['name'];
                    //записываем все это дело в результирующий массив
                    $returnArray[] = $child;
                }
            }
        }
        return $returnArray;
    }
    
    /**
     * *******************************************************************************************
     *              Дерево для CGridView
     * *******************************************************************************************
     */
    
    /**
     * Get All categories data prepared for insert into $form->dropDownList
     * 
     * @return array
     */
    public function getAllCategoriesForGrid()
    {
        $categoryData = CategoriesCompany::model()->findAll();
        $categoryDataTree = CategoriesCompany::model()->dbResultToForestGrid($categoryData, 'id', 'parent_id', 'name');
        $categoryDataSelect = CategoriesCompany::model()->converTreeArrayToGrid($categoryDataTree, 0);
        //return CHtml::listData($categoryDataSelect, 'id', 'name');
        return $categoryDataSelect;
    }

    /**
     * Build heriarhal result from DB Query result.
     * db result must conist id, parent_id, value
     * 
     * @param Object $rows
     * @param string $idName name of id key in result query
     * @param string $pidName name of parent id for query result
     * @param string $labelName name of value field in query result
     * @return array heriarhical tree
     */
    public function dbResultToForestGrid($rows, $idName, $pidName, $labelName = 'label')
    {
        $totalArray = array();
        $children = array(); // children of each ID
        $ids = array();
        $k = 0;
        // Collect who are children of whom.
        foreach ($rows as $i => $r)
        {
            $element = array('id' => $rows[$i][$idName], 'parent_id' => $rows[$i][$pidName], 'value' => $rows[$i][$labelName]);
            $totalArray[$k++] = $element;
            $row = &$totalArray[$k - 1];
            $id = $row['id'];
            if ($id === null)
            {
                // Rows without an ID are totally invalid and makes the result tree to
                // be empty (because PARENT_ID = null means "a root of the tree"). So
                // skip them totally.
                continue;
            }
            $pid = $row['parent_id'];
            if ($id == $pid)
            {
                $pid = null;
            }
            $children[$pid][$id] = & $row;
            if (!isset($children[$id]))
            {
                $children[$id] = array();
            }
            $row['childNodes'] = &$children[$id];
            $ids[$id] = true;
        }

        // Root elements are elements with non-found PIDs.
        $forest = array();
        foreach ($totalArray as $i => $r)
        {
            $row = &$totalArray[$i];
            $id = $row['id'];
            $pid = $row['parent_id'];
            if ($pid == $id)
                $pid = null;
            if (!isset($ids[$pid]))
            {
                $forest[$row[$idName]] = & $row;
            }
        }
        return $forest;
    }

    /**
     * Recursive function converting tree like array to single array with
     * delimiter. Such type of array used for generate drop down box
     * 
     * @param array $data data of tree like
     * @param int $level current level of recursive function
     * @return array converted array
     */
    public function converTreeArrayToGrid($data, $level = 0)
    {
        foreach ($data as $item)
        {
            $subitems = array();
            $elementName = "| " . str_repeat("-- ", $level * 2) . " " . $item['value'];
            $returnItem = array('name' => $elementName, 'id' => $item['id'], 'parent_id'=>$item['parent_id']);
            if ($item['childNodes'])
            {
                $subitems = $this->converTreeArrayToGrid($item['childNodes'], $level + 1);
            }

            $returnArray[] = $returnItem;

            if ($subitems != array())
            {
                $returnArray = array_merge($returnArray, $subitems);
            }
        }
        return $returnArray;
    }

}