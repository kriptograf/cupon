<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 20.03.13
 * Time: 23:20
 * To change this template use File | Settings | File Templates.
 */
class FrontBannerWidget extends CWidget
{
    /**
     * @var string pos - текстовое обозначение позиции на странице
     */
    public $pos;
    /**
     * @var int city_id - идентификатор города
     */
    protected $city_id;

    public function init()
    {
        /**
         * Инициализируем город
         */
        $this->city_id = Yii::app()->user->getState('currentCity',1);
        parent::init();
    }
    public function run()
    {
        /**
         * Запускаем виджет
         */
        $this->renderContent($this->pos, $this->city_id);
        parent::run();
    }
    public function renderContent($pos,$city_id)
    {
        /**
         * Получаем идентификатор позиции
         */
        $position = PosBanner::model()->find('pos=:pos',array(':pos'=>$pos));


        /**
         * Критерии выборки баннера с учетом процента показов
         */
        $criteria = new CDbCriteria();
        $criteria->compare('pos_id',$position->id);
        $criteria->compare('status', 1);
        $criteria->compare('city_id',$city_id);
        $criteria->addCondition('timer != 0');
        //$criteria->order = 'percent*RAND(id,percent) DESC';
        $criteria->order = 'FLOOR(percent + RAND() * (100-percent)) DESC';
        $criteria->limit = '1';
        /**
         * Извлечь один случайный баннер
         */
        $model = Banners::model()->find($criteria);
        /**
         * Если нет результатов выборки, обновляем таймера нужных баннеров
         * и снова извлекаем баннер
         */
        if(!$model)
        {
            if(!$this->updateTimer($position->id))
            {
                return false;
            }
            else
            {
                $model = Banners::model()->find($criteria);
            }
        }

        /**
         * Записываем статистику по баннерам
         */
        $statistic = new StatBanner();
        $statistic->banner_id = $model->id;
        $statistic->date = date('Y-m-d H:i', time());
        $statistic->city_id = $city_id;
        $statistic->pos_id = $position->id;
        $statistic->save();
        /**
         * Если баннеров все таки нет, возвращаем false
         * Что бы не отображать блок
         */
        if(!$model)
        {
             return false;
        }
        /**
         * Увеличиваем количество просмотров баннера
         * И уменьшаем таймер на 1
         */
        $model->views = $model->views+1;
        $model->timer = $model->timer-1;
        $model->save();


        $this->render('banner', array('model'=>$model));
    }

    /**
     * Обновление таймеров всех баннеров с заданнной позицией
     * @param $pos
     * @return bool
     */
    private function updateTimer($pos)
    {
        $models = Banners::model()->findAllByAttributes(array('pos_id'=>$pos, 'status'=>1));

        foreach($models as $model)
        {
            $model->timer = $model->percent;
            if(!$model->save())
            {
                return false;
            }
        }
        return true;
    }
}